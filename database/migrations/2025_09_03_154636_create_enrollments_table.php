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
        Schema::create("enrollments", function (Blueprint $table) {
            $table->id();
            $table->dateTime("enrollment_date");
            $table->decimal("paid_price");
            $table->decimal("discount");
            $table->enum("status", ["pedning", "confirmed", "cancelled"]);
            $table
                ->foreignId("workshop_offering_id")
                ->constrained("workshop_offerings");
            $table->foreignId("student_id")->constrained("users");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("enrollments");
    }
};
