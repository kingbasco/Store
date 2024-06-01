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
        Schema::table('variation_options', function (Blueprint $table) {
            $table->string('digital_file_tracker')->after('product_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('variation_options', function (Blueprint $table) {
            $table->dropColumn('digital_file_tracker');
        });
    }
};
