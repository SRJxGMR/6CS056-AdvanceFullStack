<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table("students", function (Blueprint $table): void {
            if (! Schema::hasColumn("students", "name")) {
                $table->string("name")->nullable();
            }
            if (! Schema::hasColumn("students", "phone")) {
                $table->string("phone", 20)->nullable();
            }
            if (! Schema::hasColumn("students", "address")) {
                $table->string("address", 500)->nullable();
            }
            if (! Schema::hasColumn("students", "date_of_birth")) {
                $table->date("date_of_birth")->nullable();
            }
        });

        Schema::table("courses", function (Blueprint $table): void {
            if (! Schema::hasColumn("courses", "name")) {
                $table->string("name")->nullable();
            }
            if (! Schema::hasColumn("courses", "description")) {
                $table->text("description")->nullable();
            }
            if (! Schema::hasColumn("courses", "duration")) {
                $table->unsignedInteger("duration")->nullable();
            }
            if (! Schema::hasColumn("courses", "fee")) {
                $table->decimal("fee", 10, 2)->nullable();
            }
            if (! Schema::hasColumn("courses", "difficulty")) {
                $table->string("difficulty")->nullable();
            }
            if (! Schema::hasColumn("courses", "is_active")) {
                $table->boolean("is_active")->default(true);
            }
        });
    }

    public function down(): void
    {
        Schema::table("students", function (Blueprint $table): void {
            foreach (["name", "phone", "address", "date_of_birth"] as $column) {
                if (Schema::hasColumn("students", $column)) {
                    $table->dropColumn($column);
                }
            }
        });

        Schema::table("courses", function (Blueprint $table): void {
            foreach (["name", "description", "duration", "fee", "difficulty", "is_active"] as $column) {
                if (Schema::hasColumn("courses", $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
