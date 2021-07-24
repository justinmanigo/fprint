<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            // $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('file_id');
            $table->string('referenceNumber')->unique();
            $table->datetime('pickupDate');
            $table->enum('modeOfPayment',['COP','Gcash']);
            $table->string('receipt')->nullable();
            $table->float('grandTotalPrice');
            $table->enum('status',['Processed','Confirmed', 'Cancelled'])->default('Processed');
            $table->string('remarks')->nullable();
            $table->string('cancelledReason')->nullable();
            $table->timestamps();
            
            // foreign key
            //  $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
             $table->foreign('file_id')->references('id')->on('files')->onDelete('cascade');
             
             

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
