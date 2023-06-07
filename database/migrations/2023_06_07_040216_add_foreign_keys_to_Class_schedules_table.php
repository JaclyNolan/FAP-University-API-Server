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
        Schema::table('Class_schedules', function (Blueprint $table) {
            $table->foreign(['class_course_id'], 'FK__Class_sch__class__5812160E')->references(['class_course_id'])->on('Class_courses')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Class_schedules', function (Blueprint $table) {
            $table->dropForeign('FK__Class_sch__class__5812160E');
        });
    }
};
