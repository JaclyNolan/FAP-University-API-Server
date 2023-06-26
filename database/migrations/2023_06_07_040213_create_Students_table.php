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
        Schema::create('Students', function (Blueprint $table) {
            $table->string('student_id')->primary();
            $table->unsignedInteger('major_id');
            $table->string('full_name');
            $table->date('date_of_birth');
            $table->integer('phone_number')->unique('UQ__Students__A1936A6B57713D68');
            $table->boolean('gender');
            $table->string('address');
            $table->string('image');
            $table->integer('academic_year');
            $table->float('gpa', 0, 0)->nullable();
            $table->integer('status')->nullable();
            $table->dateTime('created_at');
            $table->dateTime('updated_at')->nullable();
            $table->dateTime('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Students');
    }
};
