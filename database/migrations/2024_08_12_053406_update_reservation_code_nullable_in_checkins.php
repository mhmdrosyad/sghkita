<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateReservationCodeNullableInCheckins extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::table('checkins', function (Blueprint $table) {
        //     $table->string('reservation_code')->nullable()->change();
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::table('checkins', function (Blueprint $table) {
        //     $table->string('reservation_code')->nullable(false)->change();
        // });
    }
}
