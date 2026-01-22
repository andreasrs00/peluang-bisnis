<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('business_opportunities', function (Blueprint $table) {
            $table->string('phone_number', 20)
                  ->nullable()
                  ->after('website');

            $table->string('product_type')
                  ->after('category');
        });
    }

    public function down(): void
    {
        Schema::table('business_opportunities', function (Blueprint $table) {
            $table->dropColumn(['phone_number', 'product_type']);
        });
    }
};
