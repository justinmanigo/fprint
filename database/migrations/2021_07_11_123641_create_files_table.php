<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('printPrice_id')->nullable();
            // $table->unsignedBigInteger('order_id')->nullable();
            $table->string('filename');
            $table->integer('pageFrom');
            $table->integer('pageTo');
            $table->integer('totalPages');
            $table->float('noOfCopy');
            // $table->float('total_price');
            $table->timestamps();
          
            // foreign key
            //  $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
             $table->foreign('printPrice_id')->references('id')->on('print_prices')->onDelete('cascade');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('files');
    }
}
