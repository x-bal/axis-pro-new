<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNoInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('no_invoices', function (Blueprint $table) {
            $table->id();
            $table->string('no_invoice');
            $table->date('due_date');
            $table->date('date_invoice');
            $table->integer('created_by');
            $table->integer('status_paid');
            $table->integer('is_active');
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
        Schema::dropIfExists('no_invoices');
    }
}
