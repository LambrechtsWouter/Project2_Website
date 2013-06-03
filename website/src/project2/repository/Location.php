<?php

namespace project2\Repository;

class Location extends \Knp\Repository {

	public function getTableName() {
		return 'Location';
	}

	public function findAll() {
		return $this->db->fetchAll('SELECT * FROM `Location`');
	}
    public function insertlog($array){
    	$teller = 0;
      foreach ($array as $arr) {
      	$teller++;                          
	    $this->db->insert('location',array(
	                'lat' => $arr['lat'],
	                'lng' => $arr['lng'],
	                'position' => $teller,
	                'Routes_idRoutes' => 1
	      ));
	    }
	}  
}