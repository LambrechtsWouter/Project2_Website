<?php

/**
 * BOOTSTRAP
 * ===============
 */

	// Requires
	require_once __DIR__ . '/ikdoeict/routing/router.php';
    require_once './ikdoeict/rest/response.php';

    // include Plonk & PlonkWebsite
    require_once './library/config.php';
    require_once './library/plonk/plonk.php';
    require_once './library/plonk/database/database.php';

   //always get headers

  	
		// Create a router and a response
	$router = new Ikdoeict\Routing\Router();
    $response = new Ikdoeict\Rest\Response();

	// Before middleware
	$router->before('OPTIONS|GET|POST|PUT', '.*', function() {
		header('Access-Control-Allow-Origin: *');
	});


	// Override the 404
	$router->set404(function() {
		header('HTTP/1.1 404 Not Found');
		echo 'Uh oh - route not found!';
	});

	

/**
 * ROUTING
 * ===============
 */


	// Index
	$router->get('', function() {
		echo 'Welcome to my website!<br />';
	});

	$router->get('/MyRoute/\d+', function($id) {
		 // get DB instance
        $db = PlonkDB::getDB(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        $data  = $db->retrieve('SELECT * FROM myRoute where user = ' . $id);
		$response = new Ikdoeict\Rest\Response();
		$response->setContent($data);
	    $response->finish(); 
	});	
	$router->get('/Routes', function() {
        // get DB instance
        $db = PlonkDB::getDB(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        $data  = $db->retrieve('SELECT * FROM routes');
		$response = new Ikdoeict\Rest\Response();
		$response->setContent($data);
	    $response->finish(); 
	  
	});
	$router->get('/provincie/\d+', function($id) {
		 // get DB instance
        $db = PlonkDB::getDB(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        $data  = $db->retrieve('SELECT * FROM routes where provincie = ' . $id);
		$response = new Ikdoeict\Rest\Response();
		$response->setContent($data);
	    $response->finish(); 
	});	
	$router->get('/gsm/.*', function($gsm) {
        $db = PlonkDB::getDB(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        $data = $db->retrieve('SELECT * FROM routes where gsmCode= ' . "'" . $gsm . "'");
        $response = new Ikdoeict\Rest\Response();
		$response->setContent($data);
		 $response->finish(); 
	});
	
	$router->get('/Routes/\d+', function($id) {
        $db = PlonkDB::getDB(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        $data  = $db->retrieve('SELECT * FROM routes where idRoutes =' . $id);
        $response = new Ikdoeict\Rest\Response();
		$response->setContent($data);
	    $response->finish(); 
	});
	$router->get('/Location', function() {
        // get DB instance
        $db = PlonkDB::getDB(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        $data  = $db->retrieve('SELECT * FROM location');
        $response = new Ikdoeict\Rest\Response();
		$response->setContent($data);
	    $response->finish(); 
	});
	$router->get('/Location/\d+', function($id) {
        $db = PlonkDB::getDB(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        $data  = $db->retrieve('SELECT * FROM location where Routes_idRoutes =' . $id);
        $response = new Ikdoeict\Rest\Response();
		$response->setContent($data);
	    $response->finish(); 
	});

    $router->get('/Location/\d+/\d+', function($id,$position) {
        $db = PlonkDB::getDB(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        $data  = $db->retrieve('SELECT * FROM  `location` WHERE  `Routes_idRoutes` = ' . $id . ' and `position` = '. $position );
        $response = new Ikdoeict\Rest\Response();		 
		$response->setContent($data);
	    $response->finish(); 
    });

   	$router->get('/users/.*', function($id) {
        $db = PlonkDB::getDB(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        $data = $db->retrieve('SELECT * FROM `users` WHERE Email = ' . "'" .$id ."'");
        $response = new Ikdoeict\Rest\Response();
		$response->setContent($data);
	    $response->finish(); 
	});
	$router->post('/Location', function() {
        $options = $_POST;
        $db = PlonkDB::getDB(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        $item = $db->insert('location', $options);
        $response = new Ikdoeict\Rest\Response();
		$response->setContent($data);
	    $response->finish(); 
	});
	$router->post('/users/NewUser', function() {
	     $options = $_POST;
        $db = PlonkDB::getDB(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        $item = $db->insert('users', $options);
        $data['user'] = $item;
        echo json_encode($data);
	});
	$router->post('/MyRoute', function() {
	        $options = $_POST;
			$db = PlonkDB::getDB(DB_HOST, DB_USER, DB_PASS, DB_NAME);
			$data = $db->retrieve('SELECT * FROM `myroute` WHERE Routes = ' . $options['Routes'] . ' and user  = ' . $options['user']);
			if(!data){
				$data = $db->insert('myroute', $options);
			}   
	        echo json_encode($data);
	 });
	
	$router->post('/Routes', function() {
	        $options = $_POST;
			$db = PlonkDB::getDB(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	        $data = $db->insert('routes', $options);
	        echo json_encode($data);
	 });
	 
	 $router->post('/Routes/info', function() {
	 		$options = $_POST;
			$db = PlonkDB::getDB(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	        $data = $db->retrieve('UPDATE `routes` SET `Duration` = ' . $options['Duration'] . ',`arrived_text` = ' . "'" . $options['arrived_text'] . "'" . ' WHERE idRoutes = ' .$options['id'] );
	        echo json_encode($data);
	 });

/**
 * RUN FORREST RUN!
 * ===============
 */

	$router->run(function() {
		//echo '<br /><br /><em>(we are done here)</em>';
	});
