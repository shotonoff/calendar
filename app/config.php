<?php

return [
    'config' => [
        'twig' => [
            'template_path' => __DIR__ . '/../templates',
            'cache_path' => __DIR__ . '/../cache/twig',
        ],
        'logger' => [
            'name' => 'aulinks-app',
            'path' => getenv('APP_LOG_DIR') . '/app.log',
            'level' => \Monolog\Logger::DEBUG,
        ],
        'doctrine' => [
            'meta' => [
                'entity_path' => [
                    'src/Entity'
                ],
                'auto_generate_proxies' => true,
                'proxy_dir' => __DIR__ . '/../cache/proxies',
                'cache' => null,
            ],
            'connection' => [
                'driver' => 'pdo_mysql',
                'host' => 'aulinks-mysql',
                'dbname' => 'aulinks_db',
                'user' => 'root',
                'password' => 'root',
            ],
            'migrations' => [
                'directory' => __DIR__ . '/../app/migrations',
                'table_name' => 'migration_versions',
                'namespace' => 'aulinks\Migration',
            ]
        ],
        'mailer' => [
            'smtp' => [
                'host' => getenv('MAIL_SMTP_HOST'),
                'port' => getenv('MAIL_SMTP_PORT'),
                'security' => getenv('MAIL_SMTP_SECURITY'),
                'username' => getenv('MAIL_SMTP_USERNAME'),
                'password' => getenv('MAIL_SMTP_PASSWORD'),
            ]
        ]
    ]
];