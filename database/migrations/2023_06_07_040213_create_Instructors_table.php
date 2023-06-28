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
        Schema::create('Instructors', function (Blueprint $table) {
            $table->string('instructor_id')->primary();
            $table->unsignedInteger('major_id');
            $table->string('full_name');
            $table->date('date_of_birth');
            $table->integer('phone_number')->unique('UQ__Instruct__A1936A6B256394FF');
            $table->boolean('gender');
            $table->string('address');
            $table->string('image');
            $table->integer('position');
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
        Schema::dropIfExists('Instructors');
    }
};
