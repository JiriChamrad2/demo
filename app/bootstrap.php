<?php

require __DIR__ . '/../vendor/autoload.php';

$configurator = new Nette\Configurator;

$configurator->enableDebugger(__DIR__ . '/../log');

$configurator->setTempDirectory(__DIR__ . '/../temp');

$configurator->createRobotLoader()
    ->addDirectory(__DIR__)
    ->addDirectory(__DIR__ . "/../libs")
    ->register();

$configurator->addConfig(__DIR__ . '/config/config.neon', \Nette\Configurator::AUTO);
$configurator->addConfig(__DIR__ . '/config/config.local.neon', \Nette\Configurator::AUTO);

$container = $configurator->createContainer();

// Dibi connected to the database
\dibi::connect((array)$container->parameters["database"]);

// Obo developer mode
\obo\obo::$developerMode = true;

// setting Obo cache - not used in developer mode
\obo\obo::setCache(new \Cache(__DIR__ . '/../temp/obo'));

// connect Obo to RepositoryLayer
\obo\obo::connectToRepositoryLayer(\dibi::getConnection());

// run Obo, run ...
\obo\obo::run();

return $container;


