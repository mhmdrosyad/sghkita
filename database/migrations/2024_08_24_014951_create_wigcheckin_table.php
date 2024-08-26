<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('wig_checkins', function (Blueprint $table) {
            $table->string('checkin_code')->primary();
            $table->string('guest_name');
            $table->string('room');
            $table->decimal('rate', 10, 2);
            $table->timestamp('checkin_time');
            $table->timestamp('checkout_time');
            $table->enum('status', ['checkin', 'checkout'])->default('checkin');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('wig_checkins');
    }
};
