<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChequeTransmissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cheque_transmissions', function (Blueprint $table) {
            $table->id();
            $table->string('chequeholder');
            $table->string('branchcode');
            $table->string('remarks');
            $table->string('phone_number');
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
        Schema::dropIfExists('cheque_transmissions');
    }
}
