<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TeacherSubject extends Model
{
    protected $fillable = [
        'subject_id',
        'teacher_id',
    ];

    public function subject()
    {
        return $this->belongsTo(Subject::class,'subject_id','id');
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class,'teacher_id','id');
    }

}
