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
        Schema::table('dokters', function (Blueprint $table) {
            $table->string('slug')->nullable()->after('nama');
        });
        
        // Update existing records with slugs
        DB::statement('UPDATE dokters SET slug = LOWER(REPLACE(REPLACE(REPLACE(nama, " ", "-"), ".", ""), "dr.", "")) WHERE slug IS NULL');
        
        // Make the column unique after populating it
        Schema::table('dokters', function (Blueprint $table) {
            $table->string('slug')->nullable(false)->change();
            $table->unique('slug');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dokters', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
    }
};
