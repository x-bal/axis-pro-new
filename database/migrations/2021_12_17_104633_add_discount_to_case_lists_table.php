<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDiscountToCaseListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('case_lists', function (Blueprint $table) {
            $table->char('discount')->after('wip_usd')->default(0);
            $table->char('discount_percent')->after('discount')->default(0);
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
            $table->dropColumn('discount');
            $table->dropColumn('discount_percent');
        });
    }
}
