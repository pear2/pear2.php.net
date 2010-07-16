<?php

require_once __DIR__ . '/../vendor/php/Doctrine/Common/ClassLoader.php';

$classLoader = new \Doctrine\Common\ClassLoader(
    'Doctrine',
    __DIR__ . '/../vendor/php'
);
$classLoader->register();

$classLoader = new \Doctrine\Common\ClassLoader(
    'Entities',
    __DIR__ . '/../src'
);
$classLoader->register();

$classLoader = new \Doctrine\Common\ClassLoader(
    'Proxies',
    __DIR__ . '/../src'
);
$classLoader->register();

$config = new \Doctrine\ORM\Configuration();
$config->setMetadataCacheImpl(new \Doctrine\Common\Cache\ArrayCache);
$driverImpl = $config->newDefaultAnnotationDriver(
    array(
        __DIR__ . '/../src/PEAR2Web/Entities'
    )
);
$config->setMetadataDriverImpl($driverImpl);
$config->setProxyDir(__DIR__ . '/../data/Proxies');
$config->setProxyNamespace('PEAR2Web\Proxies');

$connectionOptions = array(
    'driver' => 'pdo_sqlite',
    'path'   => __DIR__ . '/../data/database.sqlite'
);

$em = \Doctrine\ORM\EntityManager::create($connectionOptions, $config);

$helperSet = new \Symfony\Components\Console\Helper\HelperSet(
    array(
        'db' => new \Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper(
            $em->getConnection()
        ),
        'em' => new \Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper(
            $em
        )
    )
);
