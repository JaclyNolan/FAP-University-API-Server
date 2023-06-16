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
        Schema::create('Class_schedules', function (Blueprint $table) {
            $table->increments('class_schedule_id');
            $table->integer('class_course_id');
            $table->date('day');
            $table->integer('slot');
            $table->integer('room');
            $table->integer('status');
            $table->dateTime('created_at');
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
        Schema::dropIfExists('Class_schedules');
    }
};