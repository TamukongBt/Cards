<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requests', function (Blueprint $table) {
            $table->id();
            $table->string('account_type');
            $table->string('employee_id');
            $table->string('branch_id');
            $table->bigInteger('number');
            $table->string('cards');
            $table->boolean('confirmed');
            $table->string('done_by');
            $table->bigInteger('account_number');
            $table->string('request_type');
            $table->unique(['branch_id','request_type','id',]);
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
        Schema::dropIfExists('requests');
    }
}
