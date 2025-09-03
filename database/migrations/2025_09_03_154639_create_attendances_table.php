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
        Schema::create("attendances", function (Blueprint $table) {
            $table->id();
            $table->enum("status", ["present", "apsent"]);
            // $table
            //     ->foreignId("workshop_offering_id")
            //     ->constrained("workshop_offerings");
            $table->foreignId("student_id")->constrained("users");
            $table->foreignId("enrollment_id")->constrained("enrollments"); // you can get the workshop through enrollment
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("attendances");
    }
};
