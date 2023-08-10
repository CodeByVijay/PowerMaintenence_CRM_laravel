<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->string('title',50)->default('Mr')->nullable();
            $table->string('displayName',50)->nullable();
            $table->string('firstName',50)->nullable();
            $table->string('middleName',50)->nullable()->default(null);
            $table->string('lastName',50)->nullable();
            $table->string('homePhone',15)->nullable();
            $table->string('workPhone',15)->nullable();
            $table->string('email',255)->nullable()->default(null);
            $table->date('dateOfBirth')->nullable()->default(null);
            $table->string('energy',10)->nullable();
            $table->string('gas',10)->nullable();
            $table->string('water',10)->nullable();
            $table->string('phone',10)->nullable();
            $table->string('broadband',25)->nullable();
            $table->string('paytv',10)->nullable();
            $table->string('solar',25)->nullable();
            $table->string('insurance',10)->nullable();
            $table->string('storage',20)->nullable();
            $table->string('removalist',10)->nullable();
            $table->string('finance',20)->nullable();
            $table->string('currentElectricityRetailer',50)->default('Other')->nullable();
            $table->string('currentGasRetailer',50)->default('Other')->nullable();
            $table->string('status',45)->nullable()->default('Unassigned')->comment('Unassigned, Assigned');
            $table->enum('salesType',['Better Deal','Move-In','Retention'])->default('Better Deal');
            $table->date('connectionDate')->nullable()->default(null);
            $table->enum('type',['Lead','Customer'])->default('Lead')->comment('Lead/Customer');
            $table->string('createdBy',100)->nullable()->default(null);
            $table->string('updatedBy',100)->nullable()->default(null);
            $table->string('assignedTo',100)->nullable()->default(null);
            $table->string('assignedBy',100)->nullable()->default(null);
            $table->string('accountType',45)->nullable()->comment('Residential/SME')->default('Residential');
            $table->text('notes')->nullable();
            $table->string('phyUnitnumber',30)->nullable()->default(null);
            $table->string('phyUnitType',50)->nullable()->default(null);
            $table->string('phyLotnumber',10)->nullable()->default(null);
            $table->string('phyStreetnumber',50)->nullable()->default(null);
            $table->string('phyStreetNumberSuffix',100)->nullable()->default(null);
            $table->string('phyStreetSuffix',50)->nullable()->default(null);
            $table->string('phyStreetname',50)->nullable()->default(null);
            $table->string('phyStreetType',50)->nullable()->default(null);
            $table->string('phySuburb',50)->nullable()->default(null);
            $table->string('phyState',50)->nullable()->default(null);
            $table->integer('phyPostcode')->nullable()->default('3205');
            $table->string('leadSource',45)->nullable()->default('Cheapbills');
            $table->tinyInteger('lifeSupport')->default(0);
            $table->string('promocode',50)->nullable()->default(null);
            $table->tinyInteger('crmNotify')->default(0);
            $table->dateTime('assigned_at')->nullable()->default(null);
            $table->enum('hasConcession',['Yes','No'])->nullable()->default("No");
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
        Schema::dropIfExists('leads');
    }
};
