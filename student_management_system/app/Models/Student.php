<?php

namespace App\Models;

use App\Models\Base\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends BaseModel
{
    use HasFactory;
    protected $fillable = ['name','age','gender','reporting_teacher','status','remarks'];
}
