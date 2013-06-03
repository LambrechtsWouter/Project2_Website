<?php

namespace project2\Repository;

class Routes extends \Knp\Repository {

	public function getTableName() {
		return 'Routes';
	}

	public function findAll() {
		return $this->db->fetchAll('SELECT * FROM `Routes`');
	}
    public function insertlog($name,$Location){
                                 
      return $this->db->insert('Routes',array(
                'Name' => $name,
                'Duration' => '30',
                'Location' => $Location
      ));
    }     
}