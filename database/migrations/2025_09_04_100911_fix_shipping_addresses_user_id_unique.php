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
        Schema::table('shipping_addresses', function (Blueprint $table) {
            $table->dropForeign(['user_id']);

            $table->dropUnique('shipping_addresses_user_id_unique');

            $table->foreign('user_id')
                  ->references('id')->on('users')
                  ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('shipping_addresses', function (Blueprint $table) {
            $table->dropForeign(['user_id']);

            $table->unique('user_id');

            $table->foreign('user_id')
                  ->references('id')->on('users')
                  ->cascadeOnDelete();
        });
    }
};
