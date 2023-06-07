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
        Schema::table('Feedbacks', function (Blueprint $table) {
            $table->foreign(['class_enrollment_id'], 'FK__Feedbacks__class__5535A963')->references(['class_enrollment_id'])->on('Class_enrollments')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Feedbacks', function (Blueprint $table) {
            $table->dropForeign('FK__Feedbacks__class__5535A963');
        });
    }
};
