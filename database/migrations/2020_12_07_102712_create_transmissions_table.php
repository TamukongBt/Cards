<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransmissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transmissions', function (Blueprint $table) {
            $table->id();
            $table->string('cardholder');
            $table->string('card_type');
            $table->string('branchcode');
            $table->string('card_number');
            $table->string('phone_number');
            $table->string('remarks');
            $table->string('collected_by')->nullable();
            $table->boolean('collected')->nullable();
            $table->timestamp('collected_at')->nullable();
            $table->boolean('notified')->default(0);
            $table->timestamp('notified_on')->nullable();

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
        Schema::dropIfExists('transmissions');
    }
}
