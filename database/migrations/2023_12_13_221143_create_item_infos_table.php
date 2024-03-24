<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('item_infos', function (Blueprint $table) {
            $table->id();
            $table->string('name', 250);
            $table->string('slug', 255);
            $table->string('code', 255)->nullable();
            $table->string('sku', 255)->nullable();
            $table->string('unit', 80)->nullable();
            $table->string('unit_value', 80)->nullable();
            $table->decimal('published_price', 10, 2)->nullable();
            $table->decimal('purchase_price', 10, 2)->nullable();
            $table->decimal('sell_price', 10, 2)->nullable();
            $table->integer('discount_type')->nullable();
            $table->decimal('discount_amount', 10, 2)->default(0);
            $table->tinyInteger('tax')->nullable();
            $table->decimal('tax_amount', 20, 2)->nullable();
            $table->integer('current_stock')->default(0);
            $table->string('thumbnail')->default('default.png');
            $table->integer('stock_status')->default(0);
            $table->integer('min_qty')->default(0);
            $table->boolean('approved_status')->default(1);
            $table->boolean('is_published')->default(false);
            $table->boolean('status')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('item_infos', function (Blueprint $table) {
            // Drop foreign key constraints
            $table->dropForeign(['category_id']);
            $table->dropForeign(['brand_id']);
            $table->dropForeign(['size_id']);
        });

        Schema::dropIfExists('item_infos');
    }
};
