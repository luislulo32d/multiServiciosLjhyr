<?php
return [
    'app_name'    => 'Multiservicios Ljhyr',
'app_url'     => getenv('APP_URL') ?: 'http://localhost:8080',
'db' => [
    'host' => getenv('DB_HOST') ?: 'db',
    'port' => getenv('DB_PORT') ?: '3306',
    'name' => getenv('DB_NAME') ?: 'ljhyr',
    'user' => getenv('DB_USER') ?: 'ljhyr',
    'pass' => getenv('DB_PASS') ?: 'ljhyr123',
],
'uploads_dir' => __DIR__ . '/../../public/uploads',
'uploads_url' => '/uploads',
];
