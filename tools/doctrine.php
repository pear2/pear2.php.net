<?php

set_include_path(
    get_include_path() . PATH_SEPARATOR
    . __DIR__ . '/../vendor/php'
);

require_once 'Doctrine/Common/ClassLoader.php';

$classLoader = new \Doctrine\Common\ClassLoader('Doctrine');
$classLoader->register();

$classLoader = new \Doctrine\Common\ClassLoader('Symfony', 'Doctrine');
$classLoader->register();

$helperSet = null;

require __DIR__ . '/doctrine-config.php';

$helperSet = ($helperSet) ?: new \Symfony\Components\Console\Helper\HelperSet();
$cli = new \Symfony\Components\Console\Application(
    'Doctrine Command Line Interface',
    Doctrine\ORM\Version::VERSION
);
$cli->setCatchExceptions(true);
$cli->setHelperSet($helperSet);
$cli->addCommands(
    array(
        // DBAL Commands
        new \Doctrine\DBAL\Tools\Console\Command\RunSqlCommand(),
        new \Doctrine\DBAL\Tools\Console\Command\ImportCommand(),

        // ORM Commands
        new \Doctrine\ORM\Tools\Console\Command\ClearCache\MetadataCommand(),
        new \Doctrine\ORM\Tools\Console\Command\ClearCache\ResultCommand(),
        new \Doctrine\ORM\Tools\Console\Command\ClearCache\QueryCommand(),
        new \Doctrine\ORM\Tools\Console\Command\SchemaTool\CreateCommand(),
        new \Doctrine\ORM\Tools\Console\Command\SchemaTool\UpdateCommand(),
        new \Doctrine\ORM\Tools\Console\Command\SchemaTool\DropCommand(),
        new \Doctrine\ORM\Tools\Console\Command\EnsureProductionSettingsCommand(),
        new \Doctrine\ORM\Tools\Console\Command\ConvertDoctrine1SchemaCommand(),
        new \Doctrine\ORM\Tools\Console\Command\GenerateRepositoriesCommand(),
        new \Doctrine\ORM\Tools\Console\Command\GenerateEntitiesCommand(),
        new \Doctrine\ORM\Tools\Console\Command\GenerateProxiesCommand(),
        new \Doctrine\ORM\Tools\Console\Command\ConvertMappingCommand(),
        new \Doctrine\ORM\Tools\Console\Command\RunDqlCommand(),
        new \Doctrine\ORM\Tools\Console\Command\ValidateSchemaCommand(),
    )
);

$cli->run();
