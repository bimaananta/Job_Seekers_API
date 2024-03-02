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
        Schema::create('validations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_category_id')->constrained('job_categories')->onDelete('cascade');
            $table->foreignId('society_id')->constrained('societies')->onDelete('cascade');
            $table->foreignId('validator_id')->constrained('validators')->onDelete('cascade');
            $table->enum('status', ['accepted', 'declined','pending'])->nullable();
            $table->text('work_experience')->nullable()->default('text');
            $table->text('job_position')->nullable()->default('text');
            $table->text('reason_accepted')->nullable()->default('text');
            $table->text('validator_notes')->nullable()->default('text');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('validations');
    }
};
