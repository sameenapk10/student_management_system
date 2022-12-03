<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Base\ResourceController;
use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentsController extends ResourceController
{
    protected $className = Student::class;

    public function getInitData(Request $request)
    {
        logger('req', $request->all());
        return [
            'statuses' => ['Active', 'Inactive'],
            'teachers' => ['abc', 'xyz'],
        ];
    }

    public function index(Request $request)
    {
        $this->builder->orderBy('updated_at', 'DESC');
        if ($request->has('all_students')) $this->builder->whereIn('status', ['Active', 'Inactive']);
        if ($request->has('active_students')) $this->builder->where('status', 'Active');
        if ($request->has('inactive_students')) $this->builder->where('status', 'Inactive');
        return $this->builder->get();
    }

    public function store(Request $request)
    {
        $student = Student::findOrNew($request->id);
        $validationRules = [
            'name' => 'required|string',
            'age' => 'required|integer',
            'gender' => 'required|string',
            'status' => 'required|string',
            'reporting_teacher' => 'required|string',
        ];
        $request->validate($validationRules);
        $student->fill($request->all());
        $student->save();
        return $student;
    }
}
