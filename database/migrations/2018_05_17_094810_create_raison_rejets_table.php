<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRaisonRejetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('raison_rejets', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('demande_id');
            $table->text('message');
            $table->timestamps();
        });

        Schema::table('raison_rejets', function($table) {
            $table->foreign('demande_id')->references('id')->on('demandes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('raison_rejets');
    }
}
