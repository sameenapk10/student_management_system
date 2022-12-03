@extends('layouts.admin')

@section('content')
    <div class="col-md-12">
        <div class="row justify-content-center" >
            <div class="card" id="add_student">
                <div class="container">
                    <button type="button" ng-click="closeAddStudent()" class="close mt-2 position-absolute" style="right: 15px;" >
                        <span class="material-icons">close</span>
                    </button>
                    <div class="card-header card-header-icon card-header-rose">
                        <div class="card-icon">
                            <i class="material-icons">perm_identity</i>
                        </div>
                        <h4 class="card-title">Student</h4>
                    </div>
                    <div class="card-body">
                        <div errors></div>
                        <div class="row">
                            <div class="col-md-6">
                                <div input-text class="row" model="add_student.name" label="Student Name"></div>
                            </div>
                            <div class="col-md-6">
                                <div input-select-text class="row" model="add_student.status" options="data.statuses" label="Status"></div>
                            </div>
                            <div class="col-md-6">
                                <div input-text class="row" model="add_student.age" label="Age"></div>
                            </div>
                            <div class="col-md-6">
                                <div input-select-text class="row" model="add_student.reporting_teacher" options="data.teachers"></div>
                            </div>
                            <div class="col-md-6">
                                <div input-text class="row" model="add_student.remarks" label="Remarks"></div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="form-check-label">Gender</label>
                                    </div>
                                    <div class="col-md-3 p-1">
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="radio" ng-model="add_student.gender" value="F" checked=""> Female
                                                <span class="circle">
                                                    <span class="check"></span>
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-3 p-1">
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="radio" ng-model="add_student.gender" value="M"  checked="">Male
                                                <span class="circle">
                                                    <span class="check"></span>
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row container justify-content-end" >
                            <button class="btn btn-fill btn-primary float-right" ng-click="save($event,add_student)">Submit</button>
                            <button class="btn btn-fill btn-danger float-right" ng-click="add_student=null">Clear</button>
                        </div>
                    </div>
                </div>
            </div>
{{--            @include('pcc.pcc_more')--}}
        </div>
        <div class="card">
            <div class="card-header card-header-primary">
                <h4 class="card-title">Student
                    <span class="badge badge-default">@{{ pager.totalItems }}</span>
                </h4>
                <div class="box-tools mr-2 d-none d-sm-block">
                    <button class="btn btn-info" ng-click="addStudent()"><span class="material-icons">add</span></button>
                    <button class="btn btn-info" ng-click="updateTable()"><span class="material-icons">refresh</span></button>
                </div>
            </div>
            <div class="card-body">
                @include('html_components.pagination_links')
                @include('html_components.table_loader')
                <div class="table-responsive">
                    <table class="table table-card">
                        <thead>
                        <tr>
                            <th>Sl.No</th>
                            <th>Student Id</th>
                            <th>Name</th>
                            <th>Age</th>
                            <th>Gender</th>
                            <th>Status</th>
                            <th>Reporting Teacher</th>
                            <th>Remark</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
{{--                        <tr>--}}
{{--                            <td label="Sl.no"></td>--}}
{{--                            <td label="id"></td>--}}
{{--                            <td label="Check No"><input type="text" class="form-control" ng-model="add_student.name"></td><!-- name -->--}}
{{--                            <td label="Amount"><input type="text" class="form-control" ng-model="add_student.age"></td><!-- details -->--}}
{{--                            <td label="Month"><input type="text" class="form-control" ng-model="add_student.gender"></td><!-- date -->--}}
{{--                            <td label="Date"><input select-date type="text" ng-model="check_bounce.date"></td><!-- date -->--}}
{{--                            <td label="Date"><input select-date type="text" ng-model="check_bounce.date"></td><!-- date -->--}}
{{--                            <td label=""><a href="#" ng-click="save($event, check_bounce)"><i class="material-icons">add_circle</i></a></td><!-- Action -->--}}
{{--                        </tr>--}}
                        <tr ng-repeat="student in students | filter : studentsFilter" ng-class="{'lightblue':student.id==id}">
                            <td label="Sl no">@{{ $index + 1 }}</td>
                            <td label="id">@{{ student.id }}</td>
                            <td label="name">@{{ student.name }}</td>
                            <td label="age">@{{ student.age }}</td>
                            <td label="gender">@{{ student.gender }}</td>
                            <td label="gender">@{{ student.status }}</td>
                            <td label="teacher">@{{ student.reporting_teacher }}</td>
                            <td label="remark">@{{ student.remarks }}</td>
                            <td >
                                <a href="javascript:;" ng-click="edit(student)"><i class="material-icons">edit</i></a>
                                <a href="javascript:;" ng-click="delete(student.id)" ><i class="material-icons">delete</i></a>
                                <a href="javascript:;" ng-click="show(student.id)"><i class="material-icons">more_vert</i></a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        $('#add_student' ).hide();app.controller('myCtrl', function ($scope, $controller, api, utils) {
            angular.extend(this, $controller('resourceController', {$scope:$scope, api:api, utils:utils}));
            $scope.defaults.updateTableOnSave = true;
            $scope.fetchInitData();
            $scope.updateTable();

            $scope.addStudent = function () {
                $('#add_student').fadeIn();
                $scope.student = null;
                $scope.add_student = null;
            }
            $scope.closeAddStudent = function () {
                $('#add_student').hide();
                $scope.add_student =null;
            }
            $scope.onSaved = function (response){
                if (response.success) {
                    $('#add_student').hide();
                    $scope.add_student =null;
                }
                else $scope.error_messages = response.data;
            }
            $scope.edit = function (item) {
                $scope.add_student = angular.copy(item);
                $('#add_student').fadeIn();
            }
        });
    </script>
@endpush

