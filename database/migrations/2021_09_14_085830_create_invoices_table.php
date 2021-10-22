<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bank_id')->nullable();
            $table->foreignId('case_list_id');
            $table->foreignId('member_id');
            $table->string('no_invoice');
            $table->date('due_date');
            $table->date('date_invoice');
            $table->integer('grand_total');
            $table->integer('status_paid')->default(0);
            $table->integer('is_active');
            $table->timestamp('deleted_at')->nullable();
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
        Schema::dropIfExists('invoices');
    }
}
