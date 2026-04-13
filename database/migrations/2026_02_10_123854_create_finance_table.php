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
            $table->string('receiver_name', 191)->nullable();
            $table->string('receiver_address', 255)->nullable();
            $table->string('receiver_street', 191)->nullable();
            $table->string('receiver_house_number', 191)->nullable();
            $table->string('receiver_city', 191)->nullable();
            $table->string('receiver_postcode', 191)->nullable();
            $table->string('receiver_phone', 191)->nullable()->nullable();
            $table->string('receiver_mobile', 191)->nullable();

            $table->date('invoice_date')->nullable();

            $table->integer('value_added_tax')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });

        // finance_invoice_items
        Schema::create('finance_invoice_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invoice_id')->constrained('finance_invoices')->cascadeOnDelete();
            $table->foreignId('item_type_id')->nullable()->constrained('finance_invoice_item_types')->cascadeOnDelete();

            $table->enum('quantity', [1, 2, 3, 4, 5, 6, 7, 8, 9, 10])->nullable();
            $table->enum('quantity_type', ['person', 'hour'])->nullable();
            $table->string('item_title', 255)->nullable();
            $table->text('description')->nullable();
            $table->date('item_date')->nullable();
            $table->decimal('unit_price', 10, 2)->default(0);

            $table->timestamps();
            $table->softDeletes();
        });

        // finance_invoice_item_types
        Schema::create('finance_invoice_item_types', function (Blueprint $table) {
            $table->id();
            $table->string('name',191);
            $table->text('comment')->nullable();

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
    }
};
