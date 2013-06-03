<?php

namespace project2\Repository;

class Users extends \Knp\Repository {

	public function getTableName() {
		return 'users';
	}

	public function findAll() {
		return $this->db->fetchAll('SELECT * FROM `users`');
	}
    
	public function findUserByEmail($email){
		return $this->db->fetchAssoc('SELECT * FROM `users` where Email = ' . "'" .$email . "'");
	}
	public function insertlog($Email,$password){
                                 
      return $this->db->insert('users',array(
                'Email' => $Email,
                'password' => $password,
      ));
    }   
}