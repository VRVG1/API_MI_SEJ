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
        # Schema::table('events', function (Blueprint $table) {
        #     //
        #     $table->date('register_start_date')->change();
        #     $table->date('register_end_date')->change();
        # });
        DB::statement('ALTER TABLE events ALTER COLUMN register_start_date TYPE date USING register_start_date::date');
        DB::statement('ALTER TABLE events ALTER COLUMN register_end_date TYPE date USING register_end_date::date');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            //
        });
    }
};