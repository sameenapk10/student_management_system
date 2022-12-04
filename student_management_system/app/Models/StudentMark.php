<?php

namespace App\Models;

use App\Models\Base\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StudentMark extends BaseModel
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
