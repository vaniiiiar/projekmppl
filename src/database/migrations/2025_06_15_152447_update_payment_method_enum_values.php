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
        // Modify the method column enum values
        Schema::table('payments', function (Blueprint $table) {
            $table->enum('method', ['va', 'dana', 'gopay'])
                  ->default('va')
                  ->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert back to original enum values
        Schema::table('payments', function (Blueprint $table) {
            $table->enum('method', ['cash', 'credit_card', 'debit_card', 'e-wallet'])
                  ->default('cash')
                  ->change();
        });
    }
};