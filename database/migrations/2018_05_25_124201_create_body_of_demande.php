<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBodyOfDemande extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('demandes', function (Blueprint $table) {
            $table->date('firstDay')->nullable();
            $table->date('lastDay')->nullable();
            $table->date('arriveOn')->nullable();
            $table->integer('totalDays')->nullable();
            $table->string('congeType')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('demande', function (Blueprint $table) {
            $table->dropIfExists('demandes');
        });
    }
}
