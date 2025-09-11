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
        Schema::table("enrollments", function (Blueprint $table) {
            $table->dropColumn("enrollment_date");
            $table->dropColumn("paid_price");
            $table->dropColumn("discount");
            $table->dropColumn("status");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table("enrollments", function (Blueprint $table) {
            $table->dateTime("enrollment_date")->after("id");
            $table->decimal("paid_price")->after("enrollment_date");
            $table->decimal("discount")->after("paid_price");
            $table
                ->enum("status", ["pedning", "confirmed", "cancelled"])
                ->after("discount");
        });
    }
};
