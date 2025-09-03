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
        Schema::create("workshop_offerings", function (Blueprint $table) {
            $table->id();
            $table->dateTime("start_date");
            $table->dateTime("end_date"); // should be calculated automatically using duration hours and hours per day
            $table->integer("hours_per_day")->default(3);
            $table->integer("max_capacity");
            $table->decimal("price");
            $table->foreignId("workshop_id")->constrained("workshops");
            $table->foreignId("teacher_id")->constrained("users");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("workshop_offerings");
    }
};
