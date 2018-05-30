<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddManagerIdForeignKeyToCollaborateur extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('collaborateurs', function (Blueprint $table) {
            $table->foreign('manager_id')->references('id')->on('collaborateurs');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('collaborateurs', function (Blueprint $table) {
            $table->dropColumn(['manager_id']);
        });
    }
}
