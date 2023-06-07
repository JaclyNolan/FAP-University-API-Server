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
        Schema::create('Attendances', function (Blueprint $table) {
            $table->increments('attendance_id');
            $table->integer('class_schedule_id');
            $table->integer('class_enrollment_id');
            $table->integer('attendance_status');
            $table->date('attendance_time');
            $table->dateTime('update_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Attendances');
    }
};
