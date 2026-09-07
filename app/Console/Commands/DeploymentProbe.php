<?php

namespace App\Console\Commands;

use App\Jobs\WriteDeploymentMarker;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DeploymentProbe extends Command
{
    protected $signature = 'starter:probe {action=status} {--marker=starter-persistent}';

    protected $description = 'Exercise database, storage, queue, and scheduler persistence';

    public function handle(): int
    {
        $action = $this->argument('action');
        $marker = (string) $this->option('marker');
        if ($action === 'write') {
            DB::table('deployment_markers')->updateOrInsert(['name' => 'database'], ['value' => $marker]);
            Storage::disk('local')->put('deployment-marker.txt', $marker);
        } elseif ($action === 'queue') {
            WriteDeploymentMarker::dispatch($marker);
        } elseif ($action !== 'status') {
            return self::INVALID;
        }
        $this->line(json_encode([
            'database_driver' => DB::connection()->getDriverName(),
            'queue_driver' => config('queue.default'),
            'markers' => DB::table('deployment_markers')->pluck('value', 'name')->all(),
            'upload' => Storage::disk('local')->get('deployment-marker.txt'),
        ], JSON_THROW_ON_ERROR));

        return self::SUCCESS;
    }
}
