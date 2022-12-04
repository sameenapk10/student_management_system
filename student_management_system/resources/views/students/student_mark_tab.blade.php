<div class="tab-pane" ng-controller="markController" id="mark-updates-tab">
<div class="row">
        <div class="col">
            <div class="table-responsive">
                <table class="table table-bordered table-card ">
                    <thead>
                    <tr>
                        <th>Id</th>
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
                        <td label="id"></td>
                        <td label="maths"><input type="text" class="form-control" ng-model="add_mark.maths_mark"></td>
                        <td label="science"><input type="text" class="form-control" ng-model="add_mark.science_mark"></td>
                        <td label="history"><input type="text" class="form-control" ng-model="add_mark.history_mark"></td>
                        <td label="term"><div input-select-text class="min" model="add_mark.term" options="data.terms"></div></td>
                        <td label="total"></td>
                        <td label="Date"></td><!-- date -->
                        <td label=""><a href="#" ng-click="save($event, add_mark)"><i class="material-icons">add_circle</i></a></td><!-- Action -->
                    </tr>
                    <tr ng-repeat="mark in student_marks | filter : markFilter">
                        <td label="id">@{{ mark.id }}</td>
                        <td label="maths">@{{ mark.maths_mark  }}</td>
                        <td label="science">@{{ mark.science_mark }}</td>
                        <td label="history">@{{ mark.history_mark }}</td>
                        <td label="term">@{{ mark.term }}</td>
                        <td label="total">@{{ mark.total_mark }}</td>
                        <td label="Date">@{{ mark.created_at  }}</td>
                        <td label="">
                            <a href="javascript:;" ng-click="copy('add_mark', mark)"><i class="material-icons">edit</i></a>
                            <a href="javascript:;" ng-click="delete(mark.id)"><i class="material-icons">delete</i></a>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@push('js')
    <script>
        app.controller('markController', function ($scope,$rootScope, $controller, api, utils) {
            angular.extend(this, $controller('resourceController', {$scope:$scope, api:api, utils:utils}));
            $scope.defaults.pathName = '/student_marks';
            $scope.defaults.updateTableOnSave = true;
            $scope.fetchInitData();
            $scope.updateTable();
            $scope.$on('onTabClicked', function(e, data) {
                $('#mark-updates-tab').fadeIn();
                console.log(data);
                if (!(data.tabName === "student-mark-tab")) return;
                $scope.student_id = data.studentId;
                $scope.student = data.student;
                $scope.defaultMark = {student_id:data.studentId};
                $scope.defaults.updateTableParams = 'student_id='+data.studentId;
                $scope.updateTable();
            });
            $scope.onSaving = function (object){
                object.student_id = $scope.student.id;
                console.log('saving', object);
            }
            $scope.onSaved = function (response){
                if (response.success) {
                    $scope.add_mark =null;
                }
                else $scope.error_messages = response.data;
            }
        });
    </script>
@endpush

