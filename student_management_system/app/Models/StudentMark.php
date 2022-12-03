<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentMark extends Model
{
    use HasFactory;
    protected $fillable = ['student_id','maths_mark','history_mark','science_mark','term','total_mark'];
    protected $casts = [
        'student_id' => 'string',
    ];
    public function student(){
        return $this->belongsTo('App\Models\Student');
    }
}
