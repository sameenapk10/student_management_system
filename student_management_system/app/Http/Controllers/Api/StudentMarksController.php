<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Base\ResourceController;
use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\StudentMark;
use Illuminate\Http\Request;

class StudentMarksController extends ResourceController
{
    protected $className = StudentMark::class;
    protected $with = ['student:id,name'];

    public function getInitData(Request $request)
    {
        return [
            'terms' => ['One', 'Two'],
            'student_names' => Student::all()->get(),
        ];
    }
}
