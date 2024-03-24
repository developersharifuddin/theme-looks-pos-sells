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
        Schema::create('sells', function (Blueprint $table) {
            $table->id();
            $table->string('sells_type')->default('product');
            $table->integer('customer_id')->nullable();
            $table->longText('shipping_address')->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('email', 20)->nullable();
            $table->longText('additional_info')->nullable();
            $table->string('sells_status', 20)->nullable()->default('Pennding');
            $table->integer('process_status')->nullable();
            $table->string('payment_type', 20)->nullable();
            $table->string('payment_status', 20)->nullable()->default('unpaid');
            $table->longText('payment_details')->nullable();
            $table->double('gift_wrap', 20, 2)->nullable()->default(0);
            $table->double('grand_total', 20, 2)->nullable()->default(0);
            $table->double('discount', 20, 2)->nullable()->default(0);
            $table->double('offer')->nullable();
            $table->double('service_charge', 20, 2)->nullable();
            $table->double('payable')->nullable();
            $table->double('paid')->nullable();
            $table->double('due')->nullable();
            $table->string('sale_code')->nullable();
            $table->integer('sale_status')->default(0);
            $table->string('ref_no')->nullable();
            $table->string('sent_sms')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sells');
    }
};
