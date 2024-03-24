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
        Schema::create('sells_items', function (Blueprint $table) {
            $table->id();
            $table->integer('store_id')->nullable();
            $table->unsignedBigInteger('sell_id');
            $table->unsignedBigInteger('product_id');
            $table->string('bar_code')->nullable();
            $table->string('qr_code')->nullable();
            $table->double('discount_amount')->nullable();
            $table->double('published_price');
            $table->double('sell_price', 20, 2)->nullable();
            $table->double('tax', 20, 2)->default(0);
            $table->double('sub_total')->nullable();
            $table->double('shipping_cost', 20, 2)->default(0);
            $table->integer('quantity')->nullable();
            $table->string('payment_status', 10)->default('unpaid');
            $table->string('delivery_status', 20)->nullable()->default('pending');
            $table->string('shipping_type')->nullable();
            $table->string('product_referral_code')->nullable();
            $table->integer('sells_status')->default(0);
            $table->timestamps();
            $table->foreign('sell_id')->references('id')->on('sells')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('item_infos')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sells_items');
    }
};
