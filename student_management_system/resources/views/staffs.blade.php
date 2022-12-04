@extends('layouts.admin')

@section('content')
    <div class="col-md-12">
        <div class="row justify-content-center" >
            <div class="card" id="add_user">
                <div class="container">
                    <button type="button" ng-click="closeAddUser()" class="close mt-2 position-absolute" style="right: 15px;" >
                        <span class="material-icons">close</span>
                    </button>
                    <div class="card-header card-header-icon card-header-rose">
                        <div class="card-icon">
                            <i class="material-icons">perm_identity</i>
                        </div>
                        <h4 class="card-title">Staff</h4>
                    </div>
                    <div class="card-body">
                        <div errors></div>
                        <div class="row">
                            <div class="col-md-6">
                                <div input-text class="row" model="add_user.name" label="Staff Name"></div>
                            </div>
                            <div class="col-md-6">
                                <div input-select-text class="row" model="add_user.status" options="data.statuses" label="Status"></div>
                            </div>
                            <div class="col-md-6">
                                <div input-text class="row" model="add_user.email" label="Email"></div>
                            </div>
                            <div class="col-md-6">
                                <div input-text class="row" model="add_user.age" label="Age"></div>
                            </div>
                            <div class="col-md-6">
                                <div input-select-text class="row" model="add_user.designation" options="data.designations"></div>
                            </div>
                            <div class="col-md-6">
                                <div input-text class="row" model="add_user.remarks" label="Remarks"></div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="form-check-label">Gender</label>
                                    </div>
                                    <div class="col-md-3 p-1">
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="radio" ng-model="add_user.gender" value="F" checked=""> Female
                                                <span class="circle">
                                                    <span class="check"></span>
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-3 p-1">
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="radio" ng-model="add_user.gender" value="M"  checked="">Male
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
                            <button class="btn btn-fill btn-primary float-right" ng-click="save($event,add_user)">Submit</button>
                            <button class="btn btn-fill btn-danger float-right" ng-click="add_user=null">Clear</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header card-header-primary">
                <h4 class="card-title">Staff
                    <span class="badge badge-default">@{{ users.length }}</span>
                </h4>
                <div class="box-tools mr-2 d-none d-sm-block">
                    <button class="btn btn-info" ng-click="addUser()"><span class="material-icons">add</span></button>
                    <button class="btn btn-info" ng-click="updateTable()"><span class="material-icons">refresh</span></button>
                </div>
            </div>
            <div class="card-body">
                @include('html_components.table_loader')
                <div class="table-responsive">
                    <table class="table table-card">
                        <thead>
                        <tr>
                            <th>Staff Id</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Age</th>
                            <th>Gender</th>
                            <th>Status</th>
                            <th>Designation</th>
                            <th>Remark</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td label="Id"><input type="text" class="form-control" ng-model="userFilter.id"></td>
                            <td label="name"><input type="text" class="form-control" ng-model="userFilter.name"></td>
                            <td label="name"><input type="text" class="form-control" ng-model="userFilter.email"></td>
                            <td label="age"><input type="text" class="form-control" ng-model="userFilter.age"></td>
                            <td label="gender"><input type="text" class="form-control" ng-model="userFilter.gender"></td>
                            <td label="status"><input type="text" class="form-control" ng-model="userFilter.status"></td>
                            <td label="designation"><input type="text" class="form-control" ng-model="userFilter.designation"></td>
                            <td label="remark"><input type="text" class="form-control" ng-model="userFilter.remarks"></td>
                            <td label=""><a href="javascript:"><i class="material-icons">search</i></a></td>
                        </tr>
                        <tr ng-repeat="user in users | filter : userFilter" ng-class="{'lightblue':user.id==id}">
                            <td label="id">@{{ user.id }}</td>
                            <td label="name">@{{ user.name }}</td>
                            <td label="name">@{{ user.email }}</td>
                            <td label="age">@{{ user.age }}</td>
                            <td label="gender">@{{ user.gender }}</td>
                            <td label="status">@{{ user.status }}</td>
                            <td label="teacher">@{{ user.designation }}</td>
                            <td label="remark">@{{ user.remarks }}</td>
                            <td >
                                <a href="javascript:;" ng-click="edit(user)"><i class="material-icons">edit</i></a>
                                <a href="javascript:;" ng-click="delete(user.id)" ><i class="material-icons">delete</i></a>
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
        $('#add_user' ).hide();
        app.controller('myCtrl', function ($scope, $controller, api, utils) {
            angular.extend(this, $controller('resourceController', {$scope:$scope, api:api, utils:utils}));
            $scope.defaults.pathName = '/users';
            $scope.defaults.updateTableOnSave = true;
            $scope.fetchInitData();
            $scope.updateTable();

            $scope.addUser = function () {
                $('#add_user').fadeIn();
                $scope.user = null;
                $scope.add_user = null;
            }
            $scope.closeAddUser = function () {
                $('#add_user').hide();
                $scope.add_user =null;
            }
            $scope.onSaved = function (response){
                if (response.success) {
                    $('#add_user').hide();
                    $scope.add_user =null;
                }
                else $scope.error_messages = response.data;
            }
            $scope.edit = function (item) {
                $scope.add_user = angular.copy(item);
                $('#add_user').fadeIn();
            }
        });
    </script>
@endpush

