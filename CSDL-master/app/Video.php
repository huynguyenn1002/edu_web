<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $fillable = [
        'name', 'description', 'type', 'url', 'score', 'order_in_course', 'course_id',
    ];
}
