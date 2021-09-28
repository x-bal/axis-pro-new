<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCaseListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('case_lists', function (Blueprint $table) {
            $table->id();
            $table->string('file_no');
            $table->unsignedBigInteger('insurance_id');
            $table->unsignedBigInteger('adjuster_id');
            $table->unsignedBigInteger('broker_id');
            $table->unsignedBigInteger('incident_id');
            $table->unsignedBigInteger('policy_id');
            $table->integer('category');
            $table->string('insured');
            $table->string('risk_location');
            $table->string('currency');
            $table->string('leader');
            $table->date('begin');
            $table->date('end');
            $table->date('dol');
            $table->integer('no_leader_policy');
            $table->string('leader_claim_no');
            $table->date('instruction_date')->nullable();
            $table->date('survey_date')->nullable();
            $table->date('now_update')->nullable();
            $table->date('ia_date')->nullable();
            $table->bigInteger('ia_amount')->nullable();
            $table->integer('ia_status')->default(0);
            $table->integer('ia_limit')->nullable();
            $table->date('pr_date')->nullable();
            $table->bigInteger('pr_amount')->nullable();
            $table->integer('pr_status')->default(0);
            $table->integer('pr_limit')->nullable();
            $table->integer('ir_status')->nullable();
            $table->date('ir_st_date')->nullable();
            $table->bigInteger('ir_st_amount')->nullable();
            $table->interface('ir_st_status')->default(0);
            $table->interface('ir_st_limit')->nullable();
            $table->date('ir_nd_date')->nullable();
            $table->bigInteger('ir_nd_amount')->nullable();
            $table->integer('ir_nd_status')->nullable();
            $table->date('pa_date')->nullable();
            $table->bigInteger('pa_amount')->nullable();
            $table->integer('pa_status')->default(0);
            $table->integer('pa_limit')->nullable();
            $table->date('fr_date')->nullable();
            $table->bigInteger('fr_amount')->nullable();
            $table->integer('fr_status')->default(0);
            $table->integer('fr_limit')->nullable();
            $table->bigInteger('claim_amount')->nullable();
            $table->bigInteger('fee_idr')->nullable();
            $table->bigInteger('fee_usd')->nullable();
            $table->bigInteger('wip_idr')->nullable();
            $table->bigInteger('wip_usd')->nullable();
            $table->text('remark')->nullable();
            $table->bigInteger('file_status_id')->nullable();
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
        Schema::dropIfExists('case_lists');
    }
}
