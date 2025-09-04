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
        Schema::table("workshops", function (Blueprint $table) {
            $table->string("title_ar", 255)->after("title");
            $table->text("description_ar")->after("description");

            $table->renameColumn("title", "title_en");
            $table->renameColumn("description", "description_en");
            $table->renameColumn("base_price", "initial_price");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table("workshops", function (Blueprint $table) {
            $table->dropColumn("title_ar");
            $table->dropColumn("description_ar");

            $table->renameColumn("title_en", "title");
            $table->renameColumn("description_en", "description");
            $table->renameColumn("initial_price", "base_price");
        });
    }
};
