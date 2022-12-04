<?php

namespace App\Models;

use App\Models\Base\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends BaseModel
{
    use HasFactory;
    protected $fillable = ['name','age','gender','reporting_teacher_id','status','remarks'];
    protected $casts = [
        'reporting_teacher_id' => 'string',
    ];
    public function reportingTeacher(){
        return $this->belongsTo('App\Models\user');
    }
}
