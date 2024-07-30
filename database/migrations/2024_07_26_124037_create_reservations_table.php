<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->string('order_code')->primary();
            $table->unsignedBigInteger('customer_id');
            $table->date('checkin');
            $table->date('checkout');
            $table->unsignedBigInteger('res_category_id');
            $table->integer('pax');
            $table->decimal('rate', 10, 2);
            $table->text('note')->nullable();
            $table->unsignedBigInteger('id_sp')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->enum('status', ['active', 'waiting_list'])->default('waiting_list');
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->foreign('res_category_id')->references('id_rescategory')->on('res_categories')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            // Optional foreign key for id_sp if it references another table
            $table->foreign('id_sp')->references('id')->on('sales')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reservations');
    }
}
