@extends('layouts.admin')

@section('content')
@endsection
@push('js')
    <script>
        app.controller('myCtrl', function ($scope, $controller, api, utils) {
            angular.extend(this, $controller('resourceController', {$scope:$scope, api:api, utils:utils}));
        });
    </script>
@endpush
@push('css')
    <style>
        .job-group{
            padding: 6px;
            margin: 2px;
            border-bottom: 1px solid #eee;
        }
        .job-group:hover{
            background-color: ghostwhite;
        }
        @media screen and (max-width: 576px) {
            .card .card-body {
                padding: 13px;
            }
            .alert {
                padding: 12px 6px;
            }
        }
    </style>
@endpush
