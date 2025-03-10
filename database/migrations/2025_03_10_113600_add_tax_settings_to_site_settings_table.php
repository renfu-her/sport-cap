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
        Schema::table('site_settings', function (Blueprint $table) {
            $table->enum('tax_type', ['included', 'excluded'])->default('excluded')->after('custom_js');
            $table->decimal('tax_rate', 5, 2)->default(5.00)->after('tax_type');
            $table->decimal('max_price_no_tax', 10, 2)->default(0.00)->after('tax_rate');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->dropColumn(['tax_type', 'tax_rate', 'max_price_no_tax']);
        });
    }
}; 