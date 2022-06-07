<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    protected $fillable = [
        'grade_id',
        'name',
        'description',
    ];

    public function grade()
    {
        return $this->hasMany(Grade::class,'id','grade_id');
    }
}
