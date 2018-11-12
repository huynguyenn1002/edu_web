<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;

/**
 * @property \Carbon\Carbon $created_at
 * @property int $id
 * @property \Carbon\Carbon $updated_at
 * @property mixed $teachingCourses
 */
class User extends Authenticatable
{
    use Notifiable;

    const GENDER_MALE = 1;
    const GENDER_FEMALE = 2;
    const GENDER_OTHER = 3;

    protected $fillable = [
        'name', 'email', 'password', 'DOB', 'gender', 'address',
        'balance', 'level', 'learning_score', 'teaching_score', 'avatar',
        'description'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function teachingCourses(){
        return $this->hasMany(Course::class, 'teacher_id');
    }

    public function enrolledCourses(){
        return $this->belongsToMany(
                Course::class,
                'buy_courses',
                'buyer_id',
                'course_id'
        )->withPivot('date_bought', 'rating');
    }

    public function getTodayPaid(){
        $todayPaid = DB::select("SELECT users.id as id,SUM(courses.cost) as pay 
            FROM  courses, buy_courses, users
            WHERE users.id = $this->id
            AND courses.id = buy_courses.course_id
            AND users.id = buy_courses.buyer_id
            AND (extract(day from now())=extract(day from date_bought))
            AND (extract(month from now())=extract(month from date_bought))
            AND (extract(year from now())=extract(year from date_bought))
            GROUP BY users.id");

        return isset($todayPaid[0]) ? $todayPaid[0]->pay : 0;
    }
    public function getWeekPaid(){
        $weekPay = DB::select("SELECT users.id as id, SUM(courses.cost) as pay 
            FROM  courses, buy_courses, users
            WHERE users.id = $this->id
            AND courses.id = buy_courses.course_id
            AND users.id = buy_courses.buyer_id
            AND (extract(day from now())- extract(day from date_bought)<=7)
            AND (extract(month from now())=extract(month from date_bought))
            AND (extract(year from now())=extract(year from date_bought))
            GROUP BY users.id");
        return isset($weekPay[0]) ? $weekPay[0]->pay:0;
    }
    public function getTotalPaid(){
        $totalPay = DB::select("SELECT users.id as id, SUM(courses.cost) as pay 
            FROM  courses, buy_courses, users
            WHERE users.id = $this->id
            AND courses.id = buy_courses.course_id
            AND users.id = buy_courses.buyer_id
            GROUP BY users.id");
        return isset ($totalPay[0]) ? $totalPay[0]->pay:0;
    }
    public function getTodaySold(){
        $todaySale = DB::select("SELECT courses.teacher_id as id,SUM(courses.cost) as sale
                                       FROM courses,users u1,users u2,buy_courses
                                       WHERE courses.teacher_id = $this->id
                                       AND u1.id = courses.teacher_id
                                       AND u2.id = buy_courses.buyer_id
                                       AND courses.id = buy_courses.course_id
                                       AND (extract(day from now()) =extract(day from date_bought))
                                       AND (extract(month from now())=extract(month from date_bought))
                                       AND (extract(year from now())=extract(year from date_bought))
                                       GROUP BY courses.teacher_id;");
        return isset($todaySale[0])? $todaySale[0]->sale:0;
    }
    public function getWeekSold(){
        $weekSale = DB::select("SELECT courses.teacher_id as id,SUM(courses.cost) as sale
                                       FROM courses,users u1,users u2,buy_courses
                                       WHERE courses.teacher_id = $this->id
                                       AND u1.id = courses.teacher_id
                                       AND u2.id = buy_courses.buyer_id
                                       AND courses.id = buy_courses.course_id
                                       AND (extract(day from now())-extract(day from date_bought)<=7)
                                       AND (extract(month from now())=extract(month from date_bought))
                                       AND (extract(year from now())=extract(year from date_bought))
                                       GROUP BY courses.teacher_id;");
        return isset($weekSale[0])? $weekSale[0]->sale:0;
    }
    public function getTotalSold(){
        $totalSale = DB::select("SELECT courses.teacher_id as id,SUM(courses.cost) as sale
                                       FROM courses,users u1,users u2,buy_courses
                                       WHERE courses.teacher_id = $this->id
                                       AND u1.id = courses.teacher_id
                                       AND u2.id = buy_courses.buyer_id
                                       AND courses.id = buy_courses.course_id
                                       GROUP BY courses.teacher_id;");
        return isset($totalSale[0])? $totalSale[0]->sale:0;
    }
}
