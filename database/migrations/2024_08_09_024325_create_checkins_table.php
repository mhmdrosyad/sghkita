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
            $table->string('reservation_code')->nullable();
            $table->string('guest_name');
            $table->string('instansi');
            $table->decimal('total_tagihan', 10, 2);
            $table->dateTime('checkin_time');
            $table->dateTime('checkout_time')->nullable();
            $table->enum('status', ['checkin', 'checkout'])->default('checkin'); // Menambahkan kolom status
            $table->timestamps();

            $table->foreign('reservation_code')
                ->references('order_code')
                ->on('reservations')
                ->onDelete('set null');
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
