<?php

namespace project2\Provider\Controller;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Silex\ControllerCollection;

class HomeController implements ControllerProviderInterface {


    public function connect(Application $app) {
            $controllers = $app['controllers_factory'];
            $controllers->get('/', array($this, 'Home'));
			$controllers->post('/login', array($this, 'Login'));
			$controllers->get('/logout', array($this, 'logout'));
            return $controllers;

    }

    public function Home(Application $app) {
            return $app['twig']->render('home/home.twig');
    }
	
	public function Login(Application $app){
		  	$user = $app['Users']->findUserByEmail($_POST['username']);
			if(!$user){
				return $app['twig']->render('home/home.twig');
			}else{
				if($user['password'] == $_POST['password']){
					$app['session']->set('email',$_POST['username']); 
            		$app['session']->start();
					return $app['twig']->render('home/home.twig');
				}else{
					return $app['twig']->render('home/home.twig');
				}
			};
	}
	public function logout(Application $app) {
		$app['session']->remove('email');
		return $app['twig']->render('home/home.twig');
	}
	





}