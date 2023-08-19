<?php

use App\Enums\OrderEnums;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
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
            $table->id();
            $table->foreignIdFor(User::class, 'user_id');
            $table->enum('status', [
                OrderEnums::PENDING->value,
                OrderEnums::PROCESSING->value,
                OrderEnums::COMPLETED->value,
                OrderEnums::DECLINED->value,
            ])->default(OrderEnums::PENDING->value);
            $table->timestamps();
        });

        // Pivot Table
        Schema::create('order_product', function (Blueprint $table) {
            $table->foreignIdFor(Order::class, 'order_id');
            $table->foreignIdFor(Product::class, 'product_id');
            $table->integer('quantity');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
        Schema::dropIfExists('order_product');
    }
};
