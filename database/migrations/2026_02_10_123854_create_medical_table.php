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
        // medical_certificates
        Schema::create('medical_certificates', function (Blueprint $table) {
            $table->id();

            $table->enum('salutation', ['Mr', 'Ms'])->nullable();
            $table->string('title', 191)->nullable();
            $table->string('first_name', 191);
            $table->string('middle_name', 191)->nullable();
            $table->string('last_name', 191);

            $table->string('employed_at', 255)->nullable();
            $table->string('employer_street', 191)->nullable();
            $table->string('employer_house_number', 191)->nullable();
            $table->string('employer_city', 191)->nullable();
            $table->string('employer_postcode', 191)->nullable();
            $table->string('phone', 191)->nullable();
            $table->string('mobile', 191)->nullable();

            $table->string('certificate_number');

            $table->date('birthday')->nullable();
            $table->date('issue_date')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });

        // medical_activities
        Schema::create('medical_activities', function (Blueprint $table) {
            $table->id();
            $table->string('name',191)->unique();
            $table->string('code',191)->unique();

            $table->timestamps();
            $table->softDeletes();
        });

        // medical_preventions
        Schema::create('medical_preventions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('certificate_id')->constrained('medical_certificates')->cascadeOnDelete();
            $table->foreignId('activity_id')->constrained('medical_activities')->cascadeOnDelete();

            $table->enum('prevention_type', ['Pflichtvorsorge','Angebotsvorsorge'])->nullable();
            $table->date('next_appointment_date')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medical_certificates');
        Schema::dropIfExists('medical_activities');
        Schema::dropIfExists('medical_preventions');
    }
};
