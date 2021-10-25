<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddHistoryToCaseListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('case_lists', function (Blueprint $table) {
            $table->unsignedInteger('history_id')->nullable()->after('file_status_id');
            $table->timestamp('history_date')->nullable()->after('history_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('case_lists', function (Blueprint $table) {
            $table->dropColumn('history_id');
            $table->dropColumn('history_date');
        });
    }
}
