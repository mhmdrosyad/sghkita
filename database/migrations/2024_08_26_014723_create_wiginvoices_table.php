<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWigInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wiginvoices', function (Blueprint $table) {
            $table->id();
            $table->string('checkin_code')->unique();
            $table->decimal('pay', 10, 2);
            $table->enum('payment', ['dp', 'paid']);
            $table->timestamps();

            $table->foreign('checkin_code')->references('checkin_code')->on('wig_checkins')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wiginvoices');
    }
}
