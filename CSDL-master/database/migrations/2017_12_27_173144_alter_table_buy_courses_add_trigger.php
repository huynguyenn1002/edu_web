<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableBuyCoursesAddTrigger extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('
            CREATE OR REPLACE FUNCTION fn_tg_update_course_rating() RETURNS trigger AS
            $$DECLARE
                old_score int4;
                new_score int4;
                teacher_id int4;
            BEGIN
                CASE
                    WHEN OLD.rating = 1 THEN
                        old_score := 50;
                    WHEN OLD.rating = 2 THEN
                        old_score := 100;
                    WHEN OLD.rating = 3 THEN
                        old_score := 150;
                    WHEN OLD.rating = 4 THEN
                        old_score := 200;
                    WHEN OLD.rating = 5 THEN
                        old_score := 300;
                    ELSE
                        old_score := 0;
                END CASE;
                
                CASE
                    WHEN NEW.rating = 1 THEN
                        new_score := 50;
                    WHEN NEW.rating = 2 THEN
                        new_score := 100;
                    WHEN NEW.rating = 3 THEN
                        new_score := 150;
                    WHEN NEW.rating = 4 THEN
                        new_score := 200;
                    WHEN NEW.rating = 5 THEN
                        new_score := 300;
                    ELSE
                        new_score := 0;
                END CASE;
                
                teacher_id := (SELECT courses.teacher_id FROM courses WHERE NEW.course_id = id);
                
                UPDATE users
                SET teaching_score = teaching_score + new_score - old_score
                WHERE id = teacher_id;
                
                RETURN NEW;
            END;
            $$ LANGUAGE plpgsql;
            
            CREATE TRIGGER tg_update_course_rating AFTER UPDATE OF rating
            ON buy_courses FOR EACH ROW
            EXECUTE PROCEDURE fn_tg_update_course_rating();
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP TRIGGER tg_update_course_rating ON buy_courses;');
    }
}
