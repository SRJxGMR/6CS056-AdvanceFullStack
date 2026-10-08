<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn("students", "email")) {
            Schema::table("students", function (Blueprint $table): void {
                $table->string("email")->nullable()->unique();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn("students", "email")) {
            Schema::table("students", function (Blueprint $table): void {
                $table->dropUnique(["email"]);
                $table->dropColumn("email");
            });
        }
    }
};
