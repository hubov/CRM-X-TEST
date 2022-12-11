<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTimestampsToImporterLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $columns = Schema::getColumnListing('importer_log');

        Schema::table(
            'importer_log',
            function (Blueprint $table) use ($columns) {
                if (!in_array(['created_at'], $columns)) {
                    $table->timestamp('created_at');
                }
                if (!in_array(['modified_at'], $columns)) {
                    $table->timestamp('modified_at');
                }
            }
        );
    }

    /**
     * Reverse the migration.
     *
     * @return void
     */
    public function down()
    {
        $columns = Schema::getColumnListing('importer_log');

        Schema::table(
            'importer_log',
            function (Blueprint $table) use ($columns) {
                if (in_array('modified_at', $columns)) {
                    $table->dropColumn(['modified_at']);
                }
                if (in_array('created_at', $columns)) {
                    $table->dropColumn(['created_at']);
                }
            }
        );
    }
}