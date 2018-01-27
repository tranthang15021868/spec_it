<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTicketImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ticket_images', function (Blueprint $table) {
            $table->integer('ticket_id')->unsigned();
            $table->foreign('ticket_id')->references('id')->on('tickets')->onDelete('cascade');
            $table->string('url_image',255);
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
        Schema::dropIfExists('ticket_images');
    }
}
