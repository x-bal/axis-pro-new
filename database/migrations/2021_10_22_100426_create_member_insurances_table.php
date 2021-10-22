<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMemberInsurancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member_insurances', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('file_no_outstanding');
            $table->bigInteger('member_insurance');
            $table->string('share');
            $table->integer('is_leader');
            $table->string('invoice_leader');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('member_insurances');
    }
}
