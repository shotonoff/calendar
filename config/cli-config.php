<?php
use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Doctrine\DBAL\Migrations\Configuration\Configuration;
use Doctrine\DBAL\Migrations\Tools\Console\Helper\ConfigurationHelper;

require __DIR__ . '/../vendor/autoload.php';

require __DIR__ . '/../app/bootstrap.php';

$settings = include __DIR__ . '/../app/config.php';
$settings = $settings['config']['doctrine'];

$config = \Doctrine\ORM\Tools\Setup::createAnnotationMetadataConfiguration(
    $settings['meta']['entity_path'],
    $settings['meta']['auto_generate_proxies'],
    $settings['meta']['proxy_dir'],
    $settings['meta']['cache'],
    false
);

$em = \Doctrine\ORM\EntityManager::create($settings['connection'], $config);

$configuration = new Configuration($em->getConnection());
$configuration->setMigrationsTableName($settings['migrations']['table_name']);
$configuration->setMigrationsDirectory($settings['migrations']['directory']);
$configuration->setMigrationsNamespace($settings['migrations']['namespace']);

$helperSet = ConsoleRunner::createHelperSet($em);
$helperSet->set(new ConfigurationHelper($em->getConnection(), $configuration));

return $helperSet;

return ConsoleRunner::createHelperSet($em);