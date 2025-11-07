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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->constrained('organizations')->onDelete('cascade');
            $table->foreignId('patient_id')->constrained('patients')->onDelete('restrict');
            $table->foreignId('responsible_user_id')->constrained('users')->onDelete('restrict');
            $table->dateTime('starts_at');
            $table->integer('duration_min')->default(30);
            $table->enum('status',['scheduled', 'done', 'canceled'])->default('scheduled');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index('organization_id');
            $table->index('patient_id');
            $table->index('responsible_user_id');
            $table->index('starts_at');
            $table->index(['organization_id', 'starts_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
