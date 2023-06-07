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
        Schema::table('Class_courses', function (Blueprint $table) {
            $table->foreign(['course_id'], 'FK__Class_cou__cours__4AB81AF0')->references(['course_id'])->on('Courses')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['instructor_id'], 'FK__Class_cou__instr__4BAC3F29')->references(['instructor_id'])->on('Instructors')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['class_id'], 'FK__Class_cou__class__49C3F6B7')->references(['class_id'])->on('Class')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Class_courses', function (Blueprint $table) {
            $table->dropForeign('FK__Class_cou__cours__4AB81AF0');
            $table->dropForeign('FK__Class_cou__instr__4BAC3F29');
            $table->dropForeign('FK__Class_cou__class__49C3F6B7');
        });
    }
};
