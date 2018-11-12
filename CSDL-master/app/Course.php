<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * @property mixed $teacher
 */
class Course extends Model
{
    const CTYPE_VIDEO_URL = 0;
    const CTYPE_VIDEO_FILE = 1;
    const CTYPE_PROJECT = 2;
    const STATUS_PENDING = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_DEACTIVED = 2;
    const STATUS_REJECTED = 3;

    protected $fillable = [
        'name', 'description', 'cost', 'status', 'teacher_id', 'course_category_id', 'avatar', 'cover', 'reject_reason'
    ];

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function buyers()
    {
        return $this->belongsToMany(
                User::class,
                'buy_courses',
                'course_id',
                'buyer_id'
        )->withPivot('date_bought', 'rating');
    }

    public function videos()
    {
        return $this->hasMany(Video::class);
    }

    public function projects()
    {
        return $this->hasMany(RequiredProject::class);
    }

    public function category()
    {
        return $this->belongsTo(CourseCategory::class);
    }

    public function getTotalBuyers()
    {
        $buyers = $this->buyers->count();
        return $buyers;
    }

    public function getBuyersInPeriod($period)
    {
        $buyers = 0;
        foreach ($this->buyers as $buyer){
            if($buyer->pivot->date_bought >= Carbon::now()->subDays($period)->toDateTimeString()){
                $buyers++;
            };
        }
        return $buyers;
    }

    public function getRatingPoint()
    {
        $buyers = $this->buyers->count();
        $rating = 0;

        foreach ($this->buyers as $buyer){
            $rating += $buyer->pivot->rating;
            if(!$buyer->pivot->rating) {
                $buyers -= 1;
            }
        }

        if($buyers === 0){
            return 0;
        }

        return round($rating / $buyers, 1);
    }

    public function getMonthlyBuyers()
    {
        $monthlyBuyers = DB::table('buy_courses')
            ->select([DB::raw("date_trunc('month', date_bought) as month"), DB::raw('COUNT(buyer_id) as buyers')])
            ->where('course_id', $this->id)
            ->groupBy(DB::raw("date_trunc('month', date_bought)"))
            ->orderBy(DB::raw("date_trunc('month', date_bought)"))->get();

        return $monthlyBuyers;
    }

    public function getRatingRank()
    {
        $rank = DB::select('
            WITH ranks AS (
                SELECT
                    course_id,
                    ROW_NUMBER() OVER (ORDER BY AVG(rating) DESC) AS rank,
                    AVG(rating) AS avg_rating
                FROM buy_courses
                WHERE rating IS NOT NULL
                GROUP BY course_id
            )
            SELECT rank, avg_rating
            FROM ranks
            WHERE course_id = ' . $this->id
        );

        return [
            'rank' => isset($rank[0]) ? $rank[0]->rank : 0,
            'avg_rating' => isset($rank[0]) ? round($rank[0]->avg_rating, 1) : 0
        ];
    }

    public function getBuyingRank()
    {
        $rank = DB::select('
            WITH ranks AS (
                SELECT
                    course_id,
                    ROW_NUMBER() OVER (ORDER BY COUNT(buyer_id) DESC) AS rank,
                    COUNT(buyer_id) AS buyers
                FROM buy_courses
                GROUP BY course_id
            )
            SELECT rank, buyers
            FROM ranks
            WHERE course_id = ' . $this->id
        );

        return [
            'rank' => isset($rank[0]) ? $rank[0]->rank : 0,
            'buyers' => isset($rank[0]) ? round($rank[0]->buyers, 1) : 0
        ];
    }
}
