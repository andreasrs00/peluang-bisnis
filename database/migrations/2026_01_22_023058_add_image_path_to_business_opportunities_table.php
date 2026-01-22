<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('business_opportunities', function (Blueprint $table) {
            $table->string('image_path')->nullable()->after('slug');
            // kalau kamu mau lebih rapi, bisa after('partner_need') atau sesuai urutan kolommu
        });
    }

    public function down(): void
    {
        Schema::table('business_opportunities', function (Blueprint $table) {
            $table->dropColumn('image_path');
        });
    }
};
