<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentProject extends Model
{
    const STATUS_WAITING_FOR_APPROVE = 0;
    const STATUS_PASSED = 1;
    const STATUS_REJECTED = 2;

    protected $fillable = [
        'performer_id', 'required_project_id', 'status', 'created_at', 'updated_at', 'reject_reason'
    ];

    public function requiredProject()
    {
        return $this->belongsTo(RequiredProject::class);
    }

    public function performer()
    {
        return $this->belongsTo(User::class, 'performer_id');
    }

    public function files()
    {
        return $this->hasMany(ProjectFile::class);
    }
}
