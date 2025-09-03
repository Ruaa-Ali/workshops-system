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
        Schema::create("workshops", function (Blueprint $table) {
            $table->id();
            $table->string("title", 255);
            $table->text("description");
            $table->integer("duration_hours");
            $table->decimal("base_price");
            $table->text("image");
            $table->foreignId("created_by")->constrained("users");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("workshops");
    }
};
