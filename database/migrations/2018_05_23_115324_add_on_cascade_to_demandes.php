<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOnCascadeToDemandes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

        public function up()
    {
        DB::statement("ALTER TABLE raison_rejets ADD CONSTRAINT fk_raison FOREIGN KEY (demande_id) REFERENCES demandes(id) ON DELETE CASCADE;");
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
