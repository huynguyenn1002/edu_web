<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RequiredProject extends Model
{
    protected $fillable = [
        'name', 'description', 'url', 'score', 'order_in_course', 'course_id',
    ];

    public function studentProjects() {
        return $this->hasMany(StudentProject::class);
    }
}
