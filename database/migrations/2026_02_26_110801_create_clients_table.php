<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();

            $table->enum('client_type', ['individual', 'business' , 'government' , 'other'])->default('individual');

            $table->string('full_name');
            $table->string('business_name')->nullable();

            $table->string('cnic')->nullable();
            $table->string('registration_number')->nullable();

            $table->text('business_address')->nullable();
            $table->date('business_registration_date')->nullable();

            $table->string('sales_tax_number')->nullable();
            $table->date('portal_registration_date')->nullable();

            // Walk-in or reference
            $table->string('reference')->nullable();

            $table->string('email')->nullable();
            $table->string('phone')->nullable();

            $table->timestamps();

            // Indexes
            $table->index('client_type');
            $table->index('cnic');
            $table->index('registration_number');
            $table->index('sales_tax_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
