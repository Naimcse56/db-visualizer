<?php
return [
    'cache_key' => 'db_visualizer_v1',
    'scan_paths' => [
        app_path(),
        resource_path('views'),
        base_path('Modules'),
    ],
    'cache_ttl' => 3600,
];