<?php

// This class will have methods common to every route

// So far, it just establishes the DB connection
class Controller {

	protected $db;

	function __construct() {
		$f3=Base::instance();

		// Connect to the database
		$db=new DB\SQL(
            $f3->get('db'),
            $f3->get('db_user'),
            $f3->get('db_password')
        );
		
		$this->db=$db;
	}
	function beforeroute($f3, $params) {
		if (!empty($f3->get('SESSION.email'))) {
			$db = $this->db;
	 		$user_map=new DB\SQL\Mapper($db,'users');
	 		$user_map->load(['email=?', $f3->get('SESSION.email')]);
      if (!$user_map->dry() and $user_map->is_active) 
            $f3->set('current_user_map', $user_map);
            $f3->set('logged_in', TRUE);
			$f3->set('is_admin', $user_map->is_admin);
		}
	}
};