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
        Schema::create('lead_identification_card_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('leadID');
            $table->enum('id_type',['Drivers Licence','Medicare Card','Passport'])->nullable()->default('Drivers Licence');
            $table->string('id_number')->nullable();
            $table->date('id_expiry_date')->nullable();
            $table->enum('id_issue_state',['VIC', 'SA', 'NSW', 'QLD', 'TAS', 'ACT', 'NT'])->nullable();
            $table->string('id_issue_country')->nullable();
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
        Schema::dropIfExists('lead_identification_card_details');
    }
};
