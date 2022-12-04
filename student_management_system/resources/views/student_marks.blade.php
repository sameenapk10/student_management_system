@extends('layouts.admin')

@section('content')
    <div class="col-md-12">
        <div class="row justify-content-center" >
            <div class="card" id="add_mark">
                <div class="container">
                    <button type="button" ng-click="closeAddMark()" class="close mt-2 position-absolute" style="right: 15px;" >
                        <span class="material-icons">close</span>
                    </button>
                    <div class="card-header card-header-icon card-header-rose">
                        <div class="card-icon">
                            <i class="material-icons">perm_identity</i>
                        </div>
                        <h4 class="card-title">Student Marks</h4>
                    </div>
                    <div class="card-body">
                        <div errors></div>
                        <div class="row">
                            <div class="col-md-6">
                                <div input-select-model class="row" model="add_mark.student_id" options="data.student_names" label="Student Name"></div>
                            </div>
                            <div class="col-md-6">
                                <div input-text class="row" model="add_mark.maths_mark" ></div>
                            </div>
                            <div class="col-md-6">
                                <div input-text class="row" model="add_mark.science_mark" ></div>
                            </div>
                            <div class="col-md-6">
                                <div input-text class="row" model="add_mark.history_mark" ></div>
                            </div>
                            <div class="col-md-6">
                                <div input-select-text class="row" model="add_mark.term" options="data.terms"></div>
                            </div>
                        </div>
                        <div class="row container justify-content-end" >
                            <button class="btn btn-fill btn-primary float-right" ng-click="save($event,add_mark)">Submit</button>
                            <button class="btn btn-fill btn-danger float-right" ng-click="add_mark=null">Clear</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header card-header-primary">
                <h4 class="card-title">Student Marks
                    <span class="badge badge-default">@{{ student_marks.length }}</span>
                </h4>
                <div class="box-tools mr-2 d-none d-sm-block">
                    <button class="btn btn-info" ng-click="addMark()"><span class="material-icons">add</span></button>
                    <button class="btn btn-info" ng-click="updateTable()"><span class="material-icons">refresh</span></button>
                </div>
            </div>
            <div class="card-body">
                @include('html_components.table_loader')
                <div class="table-responsive">
                    <table class="table table-bordered table-card ">
                        <thead>
                        <tr>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Maths</th>
                            <th>Science </th>
                            <th>History</th>
                            <th>Term</th>
                            <th>Total Mark</th>
                            <th>Created At</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td label="id"><input type="text" class="form-control" ng-model="markFilter.id"></td>
                            <td label="name"><input type="text" class="form-control" ng-model="markFilter.student.name"></td>
                            <td label="maths"><input type="text" class="form-control" ng-model="markFilter.maths_mark"></td>
                            <td label="science"><input type="text" class="form-control" ng-model="markFilter.science_mark"></td>
                            <td label="term"><input type="text" class="form-control" ng-model="markFilter.history_mark"></td>
                            <td label="term"><input type="text" class="form-control" ng-model="markFilter.term"></td>
                            <td label="total"><input type="text" class="form-control" ng-model="markFilter.total_mark"></td>
                            <td label="Date"><input select-date type="text" ng-model="markFilter.created_at"></td><!-- date -->
                            <td label=""><a href="javascript:"><i class="material-icons">search</i></a></td>
                        </tr>
                        <tr ng-repeat="mark in student_marks | filter : markFilter">
                            <td label="id">@{{ mark.id }}</td>
                            <td label="name">@{{ mark.student.name }}</td>
                            <td label="maths">@{{ mark.maths_mark  }}</td>
                            <td label="science">@{{ mark.science_mark }}</td>
                            <td label="history">@{{ mark.history_mark }}</td>
                            <td label="term">@{{ mark.term }}</td>
                            <td label="total">@{{ mark.total_mark }}</td>
                            <td label="Date">@{{ mark.created_at  }}</td>
                            <td label="">
                                <a href="javascript:;" ng-click="edit(mark)"><i class="material-icons">edit</i></a>
                                <a href="javascript:;" ng-click="delete(mark.id)"><i class="material-icons">delete</i></a>
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
        $('#add_mark' ).hide();
        app.controller('myCtrl', function ($scope, $controller, api, utils) {
            angular.extend(this, $controller('resourceController', {$scope:$scope, api:api, utils:utils}));
            $scope.defaults.pathName = '/student_marks';
            $scope.defaults.updateTableOnSave = true;
            $scope.fetchInitData();
            $scope.updateTable();

            $scope.addMark = function () {
                $('#add_mark').fadeIn();
                $scope.add_mark = null;
            }
            $scope.closeAddMark = function () {
                $('#add_mark').hide();
                $scope.add_mark =null;
            }
            $scope.onSaved = function (response){
                if (response.success) {
                    $('#add_mark').hide();
                    $scope.add_mark =null;
                }
                else $scope.error_messages = response.data;
            }
            $scope.edit = function (item) {
                $scope.add_mark = angular.copy(item);
                $('#add_mark').fadeIn();
            }
        });
    </script>
@endpush

