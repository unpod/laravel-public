<?php

return [
    'commit_marker' => env('QA_COMMIT_MARKER', 'unknown'),
    'secret_marker' => env('QA_SECRET_MARKER'),
    'fail_health' => filter_var(env('QA_FAIL_HEALTH', false), FILTER_VALIDATE_BOOLEAN),
    'fail_migration' => filter_var(env('QA_FAIL_MIGRATION', false), FILTER_VALIDATE_BOOLEAN),
];
