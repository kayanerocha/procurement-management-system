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
        Schema::create('product_supplier', function (Blueprint $table) {
            $table->foreignId('product_id')->constrained(indexName: 'product_supplier_product_id')->cascadeOnDelete();
            $table->foreignId('supplier_id')->constrained(indexName: 'product_supplier_supplier_id')->cascadeOnDelete();
            $table->timestamp('created_at')->useCurrent();

            $table->primary(['product_id', 'supplier_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_supplier');
    }
};
