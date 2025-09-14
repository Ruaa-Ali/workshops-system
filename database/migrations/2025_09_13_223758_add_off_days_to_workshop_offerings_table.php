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
        Schema::table("workshop_offerings", function (Blueprint $table) {
            $table->string("off_days", 7)->after("end_date")->default("5");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table("workshop_offerings", function (Blueprint $table) {
            $table->dropColumn("off_days");
        });
    }
};
