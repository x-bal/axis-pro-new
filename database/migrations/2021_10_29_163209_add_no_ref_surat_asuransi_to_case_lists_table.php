<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNoRefSuratAsuransiToCaseListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('case_lists', function (Blueprint $table) {
            $table->string('no_ref_surat_asuransi');
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
            $table->dropColumn('no_ref_surat_asuransi');
        });
    }
}
