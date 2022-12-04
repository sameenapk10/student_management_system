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
            'student_names' => Student::query()->toDropDown(),
        ];
    }
    public function store(Request $request)
    {
        $student_mark = StudentMark::findOrNew($request->id);
        $validationRules = [
            'maths_mark' => 'required|integer',
            'history_mark' => 'required|integer',
            'science_mark' => 'required|integer',
            'term' => 'required|string',
        ];
        abort_if(!$request->student_id ,403,'Please select student');
        $request->validate($validationRules);
        $student_mark->fill($request->all());
        $student_mark->total_mark = $student_mark->maths_mark + $student_mark->history_mark + $student_mark->science_mark;
        $student_mark->save();
        return $student_mark;
    }
}
