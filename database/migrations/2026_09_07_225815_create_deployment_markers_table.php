<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (config('starter.fail_migration')) {
            throw new RuntimeException('Requested migration failure');
        }
        Schema::create('deployment_markers', function (Blueprint $table): void {
            $table->string('name')->primary();
            $table->text('value');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('deployment_markers');
    }
};
