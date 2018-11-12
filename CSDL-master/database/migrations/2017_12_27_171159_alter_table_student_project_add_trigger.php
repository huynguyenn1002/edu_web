<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableStudentProjectAddTrigger extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('
            CREATE OR REPLACE FUNCTION fn_tg_update_sproject_status() RETURNS trigger AS
                $$DECLARE
                    project_score int4;
                BEGIN
                    IF(OLD.status != 1) THEN
                        IF(NEW.status = 1) THEN
                            project_score := (SELECT score FROM required_projects WHERE id = NEW.required_project_id);
                            UPDATE users
                            SET learning_score = learning_score + project_score
                            WHERE id = NEW.performer_id;
                        END IF;
                    END IF;
                    
                    IF(OLD.status = 1) THEN
                        IF(NEW.status != 1) THEN
                            project_score := (SELECT score FROM required_projects WHERE id = NEW.required_project_id);
                            UPDATE users
                            SET learning_score = learning_score - project_score
                            WHERE id = NEW.performer_id;
                        END IF;
                    END IF;
                    
                    RETURN NEW;
                END;
                $$ LANGUAGE plpgsql;
                
            CREATE TRIGGER tg_update_sproject_status AFTER UPDATE OF status
            ON student_projects FOR EACH ROW
            EXECUTE PROCEDURE fn_tg_update_sproject_status();
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP TRIGGER tg_update_sproject_status ON student_projects;');
    }
}
