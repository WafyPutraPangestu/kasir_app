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
        Schema::create('orders', function (Blueprint $table) {
            $table->id(); // atau $table->uuid('id')->primary(); jika ingin pakai UUID
            $table->foreignId('table_id')->constrained('tables')->onDelete('cascade');
            $table->enum('status', ['draft', 'pending', 'paid', 'preparing', 'completed', 'cancelled'])->default('draft');
            $table->decimal('total_amount', 10, 2)->default(0);
            $table->string('snap_token')->nullable(); // untuk Midtrans Snap
            $table->string('payment_ref')->nullable();
            $table->string('midtrans_order_id')->nullable()->after('payment_ref'); // untuk ID transaksi Midtrans
            $table->string('payment_type')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
