<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExamTimeTable extends Model
{
    protected $fillable = [
        'class_start_time',
        'class_end_time',

        'grade_id',
        'section_id',
        'subject_id',
        'room_id',
        'teacher_id',
        'day',
    ];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class,'teacher_id','user_id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class,'subject_id','id');
    }
}
