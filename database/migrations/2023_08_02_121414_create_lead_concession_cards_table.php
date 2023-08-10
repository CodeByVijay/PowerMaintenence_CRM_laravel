<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lead_concession_cards', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('leadID');
            $table->string('cardType')->nullable();
            $table->string('cardNumber')->nullable();
            $table->date('card_start_date')->nullable();
            $table->date('card_end_date')->nullable();
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->nullable();

            $table->foreign('leadID')->references('id')->on('leads')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lead_concession_cards');
    }
};
