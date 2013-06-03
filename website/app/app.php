<?php

// Bootstrap
require __DIR__ . DIRECTORY_SEPARATOR . 'bootstrap.php';


$app->error(function (\Exception $e, $code) {
	if ($code == 404) {
		return '404 - Not Found! // ' . $e->getMessage();
	} else {
		return 'Shenanigans! Something went horribly wrong // ' . $e->getMessage();
	}
});

$app->get('/', function(Silex\Application $app) {
    return $app->redirect($app['request']->getBaseUrl() . '/home');
});


$app->mount('/home', new project2\Provider\Controller\HomeController);
$app->mount('/routes', new project2\Provider\Controller\RoutesController);
$app->mount('/register', new project2\Provider\Controller\RegisterController);