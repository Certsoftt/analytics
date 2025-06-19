<?php
return [
    'enabled' => env('ANALYTICS_ENABLED', true),
    'roles' => ['admin', 'editor'],
    'date_format' => 'Y-m-d',
    'default_range' => 'monthly',
    'export_formats' => ['csv', 'excel'],
    'localization' => true,
];
