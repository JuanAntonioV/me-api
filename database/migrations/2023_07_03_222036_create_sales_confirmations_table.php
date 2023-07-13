<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sales_confirmations', function (Blueprint $table) {
            $table->string('sales_id')->primary();
            $table->foreignId('payment_method_id')->constrained('payment_methods');
            $table->string('account_name');
            $table->dateTime('payment_date');
            $table->decimal('amount', 20, 0);
            $table->string('proof_of_payment');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_confirmations');
    }
};
