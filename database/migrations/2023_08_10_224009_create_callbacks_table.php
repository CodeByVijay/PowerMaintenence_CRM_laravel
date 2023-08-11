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
        Schema::create('callbacks', function (Blueprint $table) {
          $table->id();
          $table->unsignedBigInteger('lead_id')->nullable()->comment('lead id');
          $table->string('callback_date')->nullable();
          $table->text('notes')->nullable()->nullable();
          $table->unsignedBigInteger('user_id')->nullable()->comment('Notes create staff id');
          $table->timestamp('created_at')->nullable()->useCurrent();
          $table->timestamp('updated_at')->nullable();

          $table->foreign('lead_id')->references('id')->on('leads')->onDelete('cascade');
          $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('callbacks');
    }
};
