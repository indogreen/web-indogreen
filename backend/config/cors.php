<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Dibatasi ke FRONTEND_URL dan hanya mengizinkan metode GET, POST, OPTIONS.
    |
    */

    'paths' => ['api/*'],

    'allowed_methods' => ['GET', 'POST', 'OPTIONS', 'HEAD'],

    'allowed_origins' => array_filter(array_map('trim', explode(',', env('FRONTEND_URL', 'http://localhost:3000')))),

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['Content-Type', 'Accept', 'Authorization', 'X-Requested-With', 'If-None-Match'],

    'exposed_headers' => ['ETag', 'Cache-Control', 'X-Content-Version'],

    'max_age' => 86400,

    'supports_credentials' => false,

];
