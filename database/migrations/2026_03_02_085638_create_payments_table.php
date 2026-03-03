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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained()->cascadeOnDelete();
            $table->foreignId('client_service_id')->constrained()->cascadeOnDelete();
            $table->decimal('amount',12,2);
            $table->enum('payment_method',['cash','bank_transfer','card','check','online']);
            $table->string('reference_no')->nullable();
            $table->text('notes')->nullable();
            $table->foreignId('recorded_by')->constrained('users');
            $table->date('payment_date');
            $table->timestamps();

            $table->index(['client_id','client_service_id','payment_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
