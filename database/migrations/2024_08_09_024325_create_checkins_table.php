<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCheckinsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('checkins', function (Blueprint $table) {
            $table->id();
            $table->string('reservation_code')->nullable(); // Ubah kolom ini menjadi nullable
            $table->dateTime('checkin_time');
            $table->string('guest_name');
            $table->integer('pax');
            $table->decimal('deposit', 10, 2);
            $table->decimal('room_charge', 10, 2);
            $table->dateTime('checkout_time')->nullable();
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('reservation_code')->references('order_code')->on('reservations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('checkins');
    }
}
