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

            $table->string('invoice_number')->nullable();
            $table->enum('invoice_type', ['person', 'hour', 'employee'])->nullable();
            $table->string('invoice_type_other', 191)->nullable();
            $table->string('receiver_name', 191)->nullable();
            $table->string('receiver_additional_name', 191)->nullable();
            $table->string('receiver_address', 255)->nullable();
            $table->string('receiver_street', 191)->nullable();
            $table->string('receiver_house_number', 191)->nullable();
            $table->string('receiver_city', 191)->nullable();
            $table->string('receiver_postcode', 191)->nullable();
            $table->string('receiver_phone', 191)->nullable();
            $table->string('receiver_email', 191)->nullable();

            $table->date('issue_date')->nullable();

            $table->integer('value_added_tax')->nullable();
            $table->decimal('total_amount', 10, 2)->nullable();

            $table->timestamps();
            $table->softDeletes();
        });

        // finance_invoice_item_types
        Schema::create('finance_invoice_item_types', function (Blueprint $table) {
            $table->id();
            $table->string('name',191)->unique();
            $table->text('comment')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });

        // finance_invoice_items
        Schema::create('finance_invoice_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invoice_id')->constrained('finance_invoices')->cascadeOnDelete();
            $table->foreignId('item_type_id')->nullable()->constrained('finance_invoice_item_types')->cascadeOnDelete();

            $table->string('item_type_other', 255)->nullable();
            $table->date('serving_date')->nullable();

            $table->integer('quantity')->nullable();
            $table->decimal('amount', 8, 2)->nullable();
            $table->string('employee_name', 255)->nullable();

            $table->text('description')->nullable();

            $table->decimal('unit_price', 10, 2)->default(0);

            $table->timestamps();
            $table->softDeletes();
        });

        // finance_invoice_travel_expenses
        Schema::create('finance_invoice_travel_expenses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invoice_id')->constrained('finance_invoices')->cascadeOnDelete();

            $table->string('start_location', 191)->nullable();
            $table->string('destination', 191)->nullable();
            $table->decimal('distance',8, 2)->nullable();
            $table->decimal('price_per_km', 10, 2)->default(0);

            $table->enum('trip_type', ['round_trip', 'one_way'])->nullable();

            $table->date('travel_date')->nullable();

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
        Schema::dropIfExists('finance_invoice_items');
        Schema::dropIfExists('finance_invoice_item_types');
        Schema::dropIfExists('finance_invoice_travel_expenses');
    }
};
