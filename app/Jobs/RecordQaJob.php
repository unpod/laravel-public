<?php

namespace App\Jobs;

use App\Models\QaMarker;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class RecordQaJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, SerializesModels;

    public function handle(): void
    {
        QaMarker::query()->updateOrCreate(['key' => 'queue'], ['value' => now()->toIso8601String()]);
    }
}
