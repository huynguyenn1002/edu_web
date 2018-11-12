<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableWatchVideoAddTrigger extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('
            CREATE OR REPLACE FUNCTION fn_tg_insert_watch_videos() RETURNS trigger AS
                $$DECLARE
                    video_score int4;
                BEGIN
                    video_score := (SELECT score FROM videos WHERE id = NEW.video_id);
   
                    UPDATE users
                    SET learning_score = learning_score + video_score
                    WHERE id = NEW.user_id;
                    
                    RETURN NEW;
                END;
                $$ LANGUAGE plpgsql;
                
            CREATE TRIGGER tg_insert_watch_videos
                AFTER INSERT
                ON watch_videos
                FOR EACH ROW
                EXECUTE PROCEDURE fn_tg_insert_watch_videos();
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP TRIGGER tg_insert_watch_videos ON watch_videos;');
    }
}
