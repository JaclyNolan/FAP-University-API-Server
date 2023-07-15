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
            $table->unsignedInteger('class_schedule_id');
            $table->unsignedInteger('class_enrollment_id');
            $table->boolean('attendance_status')->nullable()->default(false);
            $table->dateTime('attendance_time')->nullable();
            $table->string('attendance_comment')->default('');
            $table->dateTime('created_at');
            $table->dateTime('updated_at')->nullable();
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
