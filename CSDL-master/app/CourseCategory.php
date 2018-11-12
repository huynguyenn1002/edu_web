<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CourseCategory extends Model
{
    protected $fillable = ['name', 'created_at', 'updated_at'];
    public function courses()
    {
        return $this->hasMany(Course::class);
    }
}
