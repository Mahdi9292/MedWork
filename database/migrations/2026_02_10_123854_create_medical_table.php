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
        // medical_comments
        Schema::create('medical_comments', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['employer', 'employee']);
            $table->string('title',191);
            $table->text('content');

            $table->timestamps();
            $table->softDeletes();
        });

        // medical_employers
        Schema::create('medical_employers', function (Blueprint $table) {
            $table->id();
            $table->string('name', 191);
            $table->string('contact_person', 191)->nullable();
            $table->string('address', 255)->nullable();
            $table->string('street', 191)->nullable();
            $table->string('house_number', 191)->nullable();
            $table->string('city', 191)->nullable();
            $table->string('postcode', 191)->nullable();
            $table->string('phone', 191)->nullable();
            $table->string('mobile', 191)->nullable();
            $table->string('email', 191)->nullable();

            $table->timestamps();
            $table->softDeletes();
        });

        // medical_employees
        Schema::create('medical_employees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employer_id')->constrained('medical_employers')->cascadeOnDelete();

            $table->enum('salutation', ['Mr', 'Ms'])->nullable();
            $table->string('title', 191)->nullable();
            $table->string('first_name', 191);
            $table->string('last_name', 191);
            $table->string('address', 191)->nullable();
            $table->string('phone', 191)->nullable();
            $table->string('email', 191)->nullable();

            $table->date('birthday')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });

        // medical_certificates
        Schema::create('medical_certificates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employer_comment_id')->nullable()->constrained('medical_comments')->cascadeOnDelete();
            $table->foreignId('employee_comment_id')->nullable()->constrained('medical_comments')->cascadeOnDelete();

            $table->string('certificate_number');

            $table->text('employer_comment')->nullable();
            $table->text('employee_comment')->nullable();

            $table->string('employer_name');
            $table->string('employer_contact_person')->nullable();
            $table->string('employer_address')->nullable();
            $table->string('employer_street')->nullable();
            $table->string('employer_house_number')->nullable();
            $table->string('employer_city')->nullable();
            $table->string('employer_postcode')->nullable();
            $table->string('employer_phone')->nullable();
            $table->string('employer_mobile')->nullable();
            $table->string('employer_email')->nullable();

            $table->enum('employee_salutation', ['Mr', 'Ms'])->nullable();
            $table->string('employee_title')->nullable();
            $table->string('employee_first_name')->nullable();
            $table->string('employee_last_name')->nullable();
            $table->string('employee_address')->nullable();
            $table->string('employee_phone')->nullable();
            $table->date('employee_birthday')->nullable();
            $table->string('employee_email')->nullable();

            $table->date('issue_date');
            $table->date('examination_date');

            $table->timestamps();
            $table->softDeletes();
        });

        // medical_activities
        Schema::create('medical_activities', function (Blueprint $table) {
            $table->id();
            $table->string('name',191)->unique();
            $table->string('former_name',191)->nullable();

            $table->timestamps();
            $table->softDeletes();
        });

        // medical_preventions
        Schema::create('medical_preventions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('certificate_id')->constrained('medical_certificates')->cascadeOnDelete();
            $table->foreignId('activity_id')->constrained('medical_activities')->cascadeOnDelete();

            $table->enum('prevention_type', ['Pflichtvorsorge','Angebotsvorsorge', 'Wunschvorsorge', 'Eignung'])->nullable();
            $table->date('next_appointment_date');

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
        Schema::dropIfExists('medical_comments');
        Schema::dropIfExists('medical_employers');
        Schema::dropIfExists('medical_employees');
    }
};
