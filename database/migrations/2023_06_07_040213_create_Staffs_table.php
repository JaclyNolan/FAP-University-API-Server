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
        Schema::create('Staffs', function (Blueprint $table) {
            $table->string('staff_id')->primary();
            $table->string('full_name');
            $table->integer('phone_number')->unique('UQ__Staffs__A1936A6B88462095');
            $table->boolean('gender');
            $table->date('date_of_birth');
            $table->string('address');
            $table->string('image');
            $table->string('department');
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
        Schema::dropIfExists('Staffs');
    }
};
