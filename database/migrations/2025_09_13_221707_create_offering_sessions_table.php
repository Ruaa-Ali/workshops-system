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
        Schema::create("offering_sessions", function (Blueprint $table) {
            $table->id();
            $table->date("session_date");
            $table
                ->enum("status", ["scheduled", "completed", "off"])
                ->default("scheduled");
            $table
                ->foreignId("workshop_offering_id")
                ->constrained("workshop_offerings");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("offering_sessions");
    }
};
