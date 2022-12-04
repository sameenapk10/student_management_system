<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Base\ResourceController;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends ResourceController
{
    protected $className = User::class;
    protected $with = ['reportingTeacher:id,name'];

    public function getInitData(Request $request)
    {
        logger('req', $request->all());
        return [
            'statuses' => ['Active', 'Inactive'],
            'designations' => ['teacher', 'custodian','driver'],
        ];
    }
    public function store(Request $request)
    {
        $staff = User::findOrNew($request->id);
        $validationRules = [
            'name' => 'required|string',
            'designation' => 'required|string',
            'remarks' => 'nullable|string',
            'email' => 'required|string',
        ];
        $request->validate($validationRules);
        $staff->fill($request->all());
        $staff->save();
        return $staff;
    }
}
