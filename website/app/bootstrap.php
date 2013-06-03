<?php

// Require Composer Autoloader
require_once __DIR__.'/../vendor/autoload.php';

// Create new Silex App
$app = new Silex\Application();

// App Configuration
$app['debug'] = true;

$app->register(new Silex\Provider\TwigServiceProvider(), array(
	'twig.path' => __DIR__ .  DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'views'
));

$app->register(new Silex\Provider\SessionServiceProvider());

$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
	'db.options' => array(
             'dbname'    => 'DB_10006318',
             'user'      => 'U_10006318',
             'password'  => 'w27YPd39',
	     'host'      => 'localhost',
	)
));
$app->register(new Knp\Provider\RepositoryServiceProvider(), array(
	'repository.repositories' => array(
                'Routes'  => 'project2\\Repository\\Routes',
                'Location' => 'project2\\Repository\\Location',
                'Users' => 'project2\\Repository\\Users'
    )
));