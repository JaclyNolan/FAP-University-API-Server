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
        Schema::create('Enrollments', function (Blueprint $table) {
            $table->increments('enrollment_id');
            $table->string('student_id');
            $table->unsignedInteger('course_id');
            $table->integer('status')->default(1);
            $table->string('status_name')->default("Not Registered");
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
        Schema::dropIfExists('Enrollments');
    }
};
