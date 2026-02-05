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
        Schema::table('rental_prices', function (Blueprint $table) {
            $table->foreignId('rental_period_id')->nullable()->constrained()->nullOnDelete();
            $table->dropColumn('period');
        });
    }

    public function down(): void
    {
        Schema::table('rental_prices', function (Blueprint $table) {
            $table->dropForeign(['rental_period_id']);
            $table->dropColumn('rental_period_id');
            $table->string('period')->nullable();
        });
    }
};
