<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImporterLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('importer_log')) {
            Schema::create('importer_log',
                function (Blueprint $table) {
                    $table->increments('id');
                    $table->tinyInteger('type');
                    $table->dateTime('run_at');
                    $table->integer('entries_processed');
                    $table->integer('entries_created');
                });
        }
    }

    /**
     * Reverse the migration.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('importer_log');
    }
}