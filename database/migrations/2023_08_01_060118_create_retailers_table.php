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
        Schema::create('retailers', function (Blueprint $table) {
            $table->id();
            $table->text('name');
            $table->tinyInteger('energy')->nullable()->comment('1=>Yes,0=>No');
            $table->tinyInteger('broadband')->nullable()->comment('1=>Yes,0=>No');
            $table->string('logo',255)->nullable();
            $table->string('active',5)->comment('Yes or No');
            $table->longText('tncText')->nullable()->comment('Terms & conditions');
            $table->softDeletes();
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('retailers');
    }
};
