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
        Schema::create('client_portal_credentials', function (Blueprint $table) {
            $table->id();

            $table->foreignId('client_id')
                  ->constrained('clients')
                  ->cascadeOnDelete();

            $table->enum('portal_type', ['FBR', 'IRS', 'SRB', 'OTHER']);

            $table->string('username');
            $table->text('password_encrypted');

            $table->text('pin_encrypted')->nullable();

            $table->string('security_question')->nullable();
            $table->text('security_answer_encrypted')->nullable();

            $table->timestamp('last_verified_at')->nullable();

            $table->foreignId('created_by')
                  ->constrained('users')
                  ->cascadeOnDelete();

            $table->timestamps();

            // Indexes
            $table->index(['client_id', 'portal_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_portal_credentials');
    }
};
