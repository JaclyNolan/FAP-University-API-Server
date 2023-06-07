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
        Schema::table('Users', function (Blueprint $table) {
            $table->foreign(['role_id'], 'FK__Users__role_id__3C69FB99')->references(['role_id'])->on('Roles')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['student_id'], 'FK__Users__student_i__3D5E1FD2')->references(['student_id'])->on('Students')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['staff_id'], 'FK__Users__staff_id__3E52440B')->references(['staff_id'])->on('Staffs')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['instructor_id'], 'FK__Users__instructo__3F466844')->references(['instructor_id'])->on('Instructors')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Users', function (Blueprint $table) {
            $table->dropForeign('FK__Users__role_id__3C69FB99');
            $table->dropForeign('FK__Users__student_i__3D5E1FD2');
            $table->dropForeign('FK__Users__staff_id__3E52440B');
            $table->dropForeign('FK__Users__instructo__3F466844');
        });
    }
};
