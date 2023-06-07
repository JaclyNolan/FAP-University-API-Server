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
        Schema::table('Attendances', function (Blueprint $table) {
            $table->foreign(['class_enrollment_id'], 'FK__Attendanc__class__5BE2A6F2')->references(['class_enrollment_id'])->on('Class_enrollments')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['class_schedule_id'], 'FK__Attendanc__class__5AEE82B9')->references(['class_schedule_id'])->on('Class_schedules')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Attendances', function (Blueprint $table) {
            $table->dropForeign('FK__Attendanc__class__5BE2A6F2');
            $table->dropForeign('FK__Attendanc__class__5AEE82B9');
        });
    }
};
