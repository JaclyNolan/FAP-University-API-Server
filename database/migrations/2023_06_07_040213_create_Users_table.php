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
        Schema::create('Users', function (Blueprint $table) {
            $table->increments('user_id');
            $table->integer('role_id');
            $table->string('student_id')->nullable();
            $table->string('staff_id')->nullable();
            $table->string('instructor_id')->nullable();
            $table->string('username')->unique('UQ__Users__F3DBC572605E7EBC');
            $table->string('password');
            $table->string('email')->unique('UQ__Users__AB6E6164A7275E04');
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
        Schema::dropIfExists('Users');
    }
};
