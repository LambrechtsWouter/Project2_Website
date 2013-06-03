<?php

namespace project2\Provider\Controller;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Silex\ControllerCollection;

class RegisterController implements ControllerProviderInterface {


    public function connect(Application $app) {
            $controllers = $app['controllers_factory'];
            $controllers->get('/', array($this, 'Home'));
            $controllers->post('/', array($this, 'inloggen'));
            return $controllers;

    }
    public function inloggen(Application $app) {
    	if(count($_POST['email']) > 0 && count($_POST['password']) > 0 ){
    		$user = $app['Users']->findUserByEmail($_POST['email']);
    		if(!$user){
    			$app['Users']->insertlog($_POST['email'],$_POST['password']);
				$app['session']->set('email',$_POST['email']); 
            	$app['session']->start();
				return $app->redirect('../routes');
			}else{
				return $app['twig']->render('register/home.twig');
			}
    	}
    }

    public function Home(Application $app) {
            return $app['twig']->render('register/home.twig');
    }





}