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
        Schema::table('Class_enrollments', function (Blueprint $table) {
            $table->foreign(['student_id'], 'FK__Class_enr__stude__4F7CD00D')->references(['student_id'])->on('Students')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['class_course_id'], 'FK__Class_enr__class__4E88ABD4')->references(['class_course_id'])->on('Class_courses')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Class_enrollments', function (Blueprint $table) {
            $table->dropForeign('FK__Class_enr__stude__4F7CD00D');
            $table->dropForeign('FK__Class_enr__class__4E88ABD4');
        });
    }
};
