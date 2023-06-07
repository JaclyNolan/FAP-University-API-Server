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
        Schema::table('Grades', function (Blueprint $table) {
            $table->foreign(['class_enrollment_id'], 'FK__Grades__class_en__52593CB8')->references(['class_enrollment_id'])->on('Class_enrollments')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Grades', function (Blueprint $table) {
            $table->dropForeign('FK__Grades__class_en__52593CB8');
        });
    }
};
