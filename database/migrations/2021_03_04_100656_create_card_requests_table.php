<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCardRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('card_requests', function (Blueprint $table) {
            $table->id();
            $table->string('account_number');
            $table->string('bankcode');
            $table->string('branchcode');
            $table->string('RIB');
            $table->string('accountname');
            $table->string('account_type');
            $table->string('branch_id');
            $table->string('cards');
            $table->string('card_number')->nullable();
            $table->boolean('confirmed')->default(0);
            $table->boolean('is_activated')->default(0);
            $table->boolean('rejected')->default(0);
            $table->boolean('approved')->default(0);
            $table->string('done_by');
            $table->string('requested_by');
            $table->string('reason_rejected')->nullable();
            $table->string('request_type');
            $table->string('email');
            $table->string('tel');
            $table->unique(['account_number','request_type','cards',]);
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
        Schema::dropIfExists('card_requests');
    }
}
