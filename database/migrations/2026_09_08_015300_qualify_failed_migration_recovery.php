<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

return new class extends Migration
{
    public function up(): void
    {
        if (config('starter.fail_migration')) {
            DB::table('deployment_markers')->updateOrInsert(['name' => 'migration-failure'], ['value' => 'must-be-restored']);
            Storage::disk('local')->put('migration-failure.txt', 'must-be-restored');

            throw new RuntimeException('Controlled new-source migration failure');
        }
    }

    public function down(): void {}
};
