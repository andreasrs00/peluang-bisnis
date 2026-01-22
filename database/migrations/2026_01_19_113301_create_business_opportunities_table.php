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
        Schema::create('business_opportunities', function (Blueprint $table) {
            $table->id();
            $table->string('category');
            $table->string('product_name');
            $table->string('social_media')->nullable();  // bisa link IG/Tiktok/WA
            $table->string('website')->nullable();
            $table->text('partner_need')->nullable();    // "mencari mitra..."
            $table->decimal('lat', 10, 7);
            $table->decimal('lng', 10, 7);
            $table->string('slug')->unique();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('business_opportunities');
    }
};
