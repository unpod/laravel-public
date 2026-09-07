<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\DB;

class WriteDeploymentMarker implements ShouldQueue
{
    use Queueable;

    public function __construct(public string $marker) {}

    public function handle(): void
    {
        DB::table('deployment_markers')->updateOrInsert(['name' => 'queue'], ['value' => $this->marker]);
    }
}
