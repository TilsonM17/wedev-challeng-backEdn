<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\ProductEnums;
use App\Models\Merchant;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150);
            $table->decimal('price', 10, 2);
            $table->foreignIdFor(Merchant::class, 'merchant_id');
            $table->enum('status', [
                ProductEnums::OUT_OF_STOCK->value,
                ProductEnums::IN_STOCK->value,
            ])->default(ProductEnums::IN_STOCK->value);  
            $table->timestamps();
        });


        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
