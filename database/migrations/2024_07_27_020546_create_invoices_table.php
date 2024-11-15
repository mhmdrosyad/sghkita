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
            $table->string('reservation_code');
            $table->text('description')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->decimal('total_bill', 10, 2);
            $table->enum('status', ['done', 'dp', 'unpaid'])->default('unpaid'); // Add this line
            $table->timestamps();
            $table->foreign('reservation_code')->references('order_code')->on('reservations')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropForeign(['reservation_code']);
            $table->dropForeign(['user_id']);
        });

        Schema::dropIfExists('invoices');
    }
}
