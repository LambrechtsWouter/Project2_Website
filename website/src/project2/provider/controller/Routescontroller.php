<?php

namespace project2\Provider\Controller;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Silex\ControllerCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\Request;
class RoutesController implements ControllerProviderInterface {


    public function connect(Application $app) {
            $controllers = $app['controllers_factory'];
			$controllers->get('/', array($this, 'Home'))
						->before(array($this, 'checkLogin'));
            $controllers->get('/newRoute', array($this, 'Route'))
						->before(array($this, 'checkLogin'));
            $controllers->post('/save', array($this, 'save'));
            return $controllers;

    }
	public function checkLogin(Request $request,Application $app){
		if (!$app['session']->get('email')) {
				return $app->redirect('../home');
		}
	}
    public function save(Application $app) {
    		var_dump($_POST);
			//$app['Routes']->insertlog($_POST['name'],$_POST['location']);
			//$app['Location']->insertlog($_POST['points']);
    		//return $app['twig']->render('home/home.twig');
    }
	public function Home(Application $app) {
            return $app['twig']->render('Routes/home.twig');
    }
    public function Route(Application $app) {
            return $app['twig']->render('Routes/newroute.twig');
    }

 



}