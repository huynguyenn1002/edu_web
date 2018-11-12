<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjectFile extends Model
{
    protected $fillable = [
        'link', 'student_project_id', 'name', 'type', 'description'
    ];

    public $timestamps = false;

    public function studentProject()
    {
        return $this->belongsTo(StudentProject::class);
    }
}
