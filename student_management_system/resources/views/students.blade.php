@extends('layouts.admin')

@section('content')
    <div class="col-md-12">
        <div class="row justify-content-center">
        </div>
        <div class="card">
            <div class="card-header card-header-primary">
                <h4 class="card-title">Cheque
{{--                    <span class="badge badge-default">@{{ cheques.length }}</span>--}}
                </h4>
                <div class="box-tools mr-2 d-none d-sm-block">
                    <button class="btn btn-info" ng-click="updateTable()"><span class="material-icons">refresh</span></button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-card">
                        <thead>
                        <tr>
                            <th>Sl.No</th>
                            <th>Lead Name</th>
                            <th>Lead In Hand</th>
                            <th>Cheque No</th>
                            <th>Cheque Date</th>
                            <th>Amount</th>
                            <th>Follow Up Date</th>
                            <th>Remarks</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
{{--                        <tr>--}}
{{--                            <td label="Sl no"></td><!-- Sl No -->--}}
{{--                            <td label="Lead Name"><input type="text" class="form-control" ng-model="chequeFilter.leadInHand.lead.name"></td>--}}
{{--                            <td label="Lead In Hand"><input type="text" class="form-control" ng-model="chequeFilter.leadInHand.id"></td>--}}
{{--                            <td label="Cheque No"><input type="text" class="form-control" ng-model="chequeFilter.cheque_no"></td>--}}
{{--                            <td label="Cheque Date"><input type="text" class="form-control" ng-model="chequeFilter.cheque_date"></td>--}}
{{--                            <td label="Amount"><input type="text" class="form-control" ng-model="chequeFilter.amount"></td><!--  -->--}}
{{--                            <td label="Follow Up Date"><input type="text" class="form-control" ng-model="chequeFilter.followup_date"></td><!--  -->--}}
{{--                            <td label="Remarks"><input type="text" class="form-control" ng-model="chequeFilter.remarks"></td><!--  -->--}}
{{--                            <td><a href="javascript:;" ng-click="search(chequeFilter | objToRequestParams)"><i class="material-icons">search</i></a></td>--}}
{{--                        </tr>--}}
{{--                        <tr ng-repeat="cheque in cheques | filter : chequeFilter" ng-class="{'lightblue':cheque.id==id}">--}}
{{--                            <td label="Sl no">@{{ $index + 1 }}</td>--}}
{{--                            <td label="Lead In Hand">@{{ cheque.lead_in_hand.lead.name }}</td>--}}
{{--                            <td label="Lead In Hand">@{{ cheque.lead_in_hand.id }}</td>--}}
{{--                            <td label="Cheque No">@{{ cheque.cheque_no }}</td>--}}
{{--                            <td label="Cheque Date">@{{ cheque.cheque_date }}</td>--}}
{{--                            <td label="Amount">@{{ cheque.amount }}</td>--}}
{{--                            <td label="Follow Up Date">@{{ cheque.followup_date }}</td>--}}
{{--                            <td label="Remarks">@{{ cheque.remarks }}</td>--}}
{{--                            <td >--}}
{{--                                --}}{{--                                <a href="javascript:;" ng-click="delete(cheque.id)" ><i class="material-icons">delete</i></a>--}}
{{--                                <a href="javascript:;" ng-click="show(cheque.id)"><i class="material-icons">more_vert</i></a>--}}
{{--                            </td>--}}
{{--                        </tr>--}}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection
