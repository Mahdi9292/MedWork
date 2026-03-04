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
        // finance_invoices
        Schema::create('finance_invoices', function (Blueprint $table) {
            $table->id();

            $table->string('invoice_number');
            $table->string('name', 255);
            $table->string('street', 255);
            $table->string('house_number', 255);
            $table->string('city', 255);
            $table->string('postcode', 255);
            $table->string('phone', 191)->nullable();
            $table->string('mobile', 191)->nullable();

            $table->date('invoice_date')->nullable();

            $table->integer('value_added_tax')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });

        // finance_invoice_services
        Schema::create('finance_invoice_services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invoice_id')->constrained('finance_invoices')->cascadeOnDelete();

            $table->enum('service_type', ['occupational_medical_examination', 'travel_costs', 'labor', 'consulting', 'asa_meeting', 'bem_meeting', 'site_inspection'])->nullable();
            $table->enum('quantity', [1, 2, 3, 4, 5, 6, 7, 8, 9, 10])->nullable();
            $table->string('service_title', 255)->nullable();
            $table->text('description')->nullable();
            $table->date('service_date');
            $table->decimal('unit_price', 10, 2)->default(0);

            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('finance_invoices');
        Schema::dropIfExists('finance_invoice_services');
    }
};
