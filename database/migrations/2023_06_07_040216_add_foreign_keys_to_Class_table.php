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
        Schema::table('Class', function (Blueprint $table) {
            $table->foreign(['major_id'], 'FK__Class__major_id__46E78A0C')->references(['major_id'])->on('Majors')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Class', function (Blueprint $table) {
            $table->dropForeign('FK__Class__major_id__46E78A0C');
        });
    }
};
