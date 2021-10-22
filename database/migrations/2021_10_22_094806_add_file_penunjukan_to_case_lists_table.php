<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFilePenunjukanToCaseListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('case_lists', function (Blueprint $table) {
            $table->string('file_penunjukan')->after('file_status_id');
            $table->string('document_policy')->after('file_penunjukan');
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
            $table->dropColumn('file_penunjukan');
            $table->dropColumn('document_policy');
        });
    }
}
