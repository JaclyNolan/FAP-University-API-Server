<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Enrollments', function (Blueprint $table) {
            $table->foreign(['course_id'], 'FK__Enrollmen__cours__4316F928')->references(['course_id'])->on('Courses')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['student_id'], 'FK__Enrollmen__stude__4222D4EF')->references(['student_id'])->on('Students')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Enrollments', function (Blueprint $table) {
            $table->dropForeign('FK__Enrollmen__cours__4316F928');
            $table->dropForeign('FK__Enrollmen__stude__4222D4EF');
        });
    }
};
