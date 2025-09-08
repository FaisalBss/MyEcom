<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
         DB::statement("
            UPDATE users
            SET role = CASE
                WHEN LOWER(COALESCE(CAST(role AS CHAR), '')) IN ('admin','superadmin','1','true') THEN 1
                ELSE 0
            END
        ");
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('role')->default(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role', 20)->default('user')->change();
        });
    }
};
