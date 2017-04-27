<?php

$logDir = getenv('APP_LOG_DIR');
$cacheDir = getenv("APP_CACHE_DIR");

return [
    'settings.displayErrorDetails' => true, // set to false in production
    'settings.addContentLengthHeader' => false, // Allow the web server to send the content-length header

    'settings.twig.template_path' => __DIR__ . '/../templates',
    'settings.twig.cache_path' => $cacheDir . '/twig',

    'settings.logger.name' => 'slim-app',
    'settings.logger.path' => $logDir . '/app.log',
    'settings.logger.level' => \Monolog\Logger::DEBUG,

    'settings.doctrine.meta.entity_path' => [
        'src/Entity'
    ],
    'settings.doctrine.meta.auto_generate_proxies' => true,
    'settings.doctrine.meta.proxy_dir' => $cacheDir  . '/proxies',
    'settings.doctrine.meta.cache' => null,

    'settings.doctrine.connection.driver' => 'pdo_mysql',
    'settings.doctrine.connection.host' => 'aulinks-mysql',
    'settings.doctrine.connection.dbname' => 'aulinks_db',
    'settings.doctrine.connection.user' => 'root',
    'settings.doctrine.connection.password' => 'root',
    'settings.doctrine.migrations.directory' => __DIR__ . '/../app/migrations',
    'settings.doctrine.migrations.table_name' => 'migration_versions',
    'settings.doctrine.migrations.namespace' => 'aulinks\Migration',
];