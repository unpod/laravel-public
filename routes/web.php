<?php

use App\Jobs\RecordQaJob;
use App\Models\QaMarker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/probe', function () {
    if (config('qa.fail_health')) {
        return response()->json(['status' => 'failed'], 503);
    }

    $marker = QaMarker::query()->firstOrCreate(['key' => 'health'], ['value' => 'healthy']);

    return response()->json([
        'status' => 'ok',
        'marker' => $marker->value,
        'database' => config('database.default'),
        'commit' => config('qa.commit_marker'),
    ]);
});

Route::get('/qa/state', function () {
    return response()->json([
        'application' => 'unpod-apps-qa',
        'marker' => QaMarker::query()->where('key', 'persistent')->value('value'),
        'queue_marker' => QaMarker::query()->where('key', 'queue')->value('value'),
        'scheduler_marker' => QaMarker::query()->where('key', 'scheduler')->value('value'),
        'database' => config('database.default'),
        'cache' => config('cache.default'),
        'commit' => config('qa.commit_marker'),
        'secret_present' => filled(config('qa.secret_marker')),
    ]);
});

Route::post('/qa/marker', function (Request $request) {
    $data = $request->validate(['value' => ['required', 'string', 'max:120']]);

    QaMarker::query()->updateOrCreate(['key' => 'persistent'], ['value' => $data['value']]);

    return response()->json(['saved' => true]);
});

Route::post('/qa/queue', function () {
    RecordQaJob::dispatch();

    return response()->json(['queued' => true]);
});

Route::get('/qa/upload', function () {
    return view('qa-upload');
});

Route::post('/qa/upload', function (Request $request) {
    $request->validate(['file' => ['required', 'file', 'max:2048']]);
    $path = $request->file('file')->store('qa-uploads');

    return response()->json(['stored' => true, 'path' => $path, 'exists' => Storage::exists($path)]);
});
