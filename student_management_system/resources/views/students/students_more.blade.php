<div class="col-md-12" ng-controller="studentsController">
    <div class="card" id="students_more">
        <div class="container">
            <button type="button" ng-click="close" class="close mt-2 position-absolute" style="right: 15px;" onclick="$('#students_more').fadeOut()">
                <span class="material-icons">close</span>
            </button>
            <button class="close mt-2 position-absolute" ng-click="refreshCard()" style="right: 50px;">
                <span class="material-icons">sync</span>
            </button>
            <div class="card-header text-center">
                <h3 class="card-title mt-3">Student Details</h3>
                <h5 class="card-description">@{{student.name }}</h5>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-md-6">Name : @{{ student.name }}</div>
                    <div class="col-md-6">Age : @{{ student.age }}</div>
                    <div class="col-md-6">Status : @{{student.status }}</div>
                    <div class="col-md-6">Gender : @{{student.gender }}</div>
                    <div class="col-md-6">Reporting teacher : @{{ student.reporting_teacher.name }}</div>
                </div>
            </div>
            <div class="card card-nav-tabs card-plain mt-5">
                <div class="card-header {{ config('md.card-header-color') }}">
                    <div class="nav-tabs-navigation">
                        <div class="nav-tabs-wrapper">
                            <ul class="nav nav-tabs" data-tabs="tabs">
                                <li class="nav-item details">
                                    <a class="nav-link active" href="#student-mark-tab" data-toggle="tab" ng-click="onTabClicked('student-mark-tab')">
                                        <i class="material-icons">home</i>Student Mark</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card-body"><div errors></div>
                    <div class="tab-content text-center">
                        @include('students.student_mark_tab')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
 {{-- @endsection --}}
@push('js')
    <script>
        app.controller('studentsController', function ($scope, api) {
            $scope.onTabClicked = function (tabName) {
                    $scope.$broadcast('onTabClicked',{tabName: tabName, studentId:$scope.student.id ,student:$scope.student });
            }
        });
    </script>
@endpush
