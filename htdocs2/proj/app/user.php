<?php

Class User extends Controller {
    // This is straight SQL, as shown in class (but with improved security)
    function detail_v1($f3, $params) {
        $db = $this->db;
        $f3->set('result',$db->exec('SELECT * FROM car WHERE id=?', $params['id']));
        $f3->set('template', 'detail.htm');
        echo Template::instance()->render('page.htm');
    }

    // This version takes advantage of the F3 ORM (Object Relational Mapping)
    // A little more code, but more powerful

    function detail_v2($f3, $params) {
        // Create a new Mapper object for the 'car' table using the given database object
        $db = $this->db;
        $car = new DB\SQL\Mapper($db, 'car');
        // Load the record from the 'car' table with the given 'id' value
        $car->load(['id=?', $params['id']]);
        $f3->set('template', 'detail.htm');
        $f3->set('item', $car);
         // Get the previous item from the database using the 'getPreviousItem' function
        $previousItem = $this->getPreviousItem($params['id'], $db);
        $f3->set('previousItem', $previousItem);
        $nextItem = $this->getNextItem($params['id'], $db);
        $f3->set('nextItem', $nextItem);
        echo Template::instance()->render('page.htm');
    }

     function getPreviousItem($id, $db) {
        return $db->exec('SELECT * FROM car WHERE name < (SELECT name FROM car WHERE id = ?) ORDER BY name DESC LIMIT 1', $id);
    }
   
    function getNextItem($id, $db) {
        return $db->exec('SELECT * FROM car WHERE name > (SELECT name FROM car WHERE id = ?) ORDER BY name ASC LIMIT 1', $id);
    }
   


    function collection($f3) {
        $db = $this->db;
        $mapper=new DB\SQL\Mapper ($db, 'car');
        $mapper->load([], ['order'=>'name']);
        $f3->set('car_map', $mapper);
        $f3->set('template', 'collection.htm');
        echo Template::instance()->render('page.htm');
        }
        

    function static($f3, $params) {
        if (empty($params['page_name'])) {
            $params['page_name'] = 'home';
        }
        $f3->set('template', $params['page_name'].'.htm');
        echo Template::instance()->render('page.htm');
    }

    // Display login form
	function login($f3) {
        if (!empty($f3->get('SESSION.email'))) { // already logged in!
            $f3->reroute($f3->get('GET.reroute') ?: '/');
        }
		$f3->clear('SESSION');
		$f3->set('COOKIE.sent',TRUE);
		$f3->set('template','login.htm');
        echo Template::instance()->render('page.htm');
	}
    

	// Process login form
	function auth($f3, $params) {
		if (!$f3->get('COOKIE.sent'))
			$f3->set('message','Cookies must be enabled to enter this area');
		else {
            $db = $this->db;
            $user_map=new DB\SQL\Mapper($db,'users');
            $user_map->load(['email=?', $f3->get('POST.email')]);

			if ($user_map->dry() // user doesn't exist
                || !$user_map->is_active // user isn't activated
				|| !password_verify($f3->get('POST.password'),$user_map->password)) // bad password
				$f3->set('message','Invalid user ID or password');
			else {
				$f3->clear('COOKIE.sent');
				$f3->set('SESSION.email',$f3->get('POST.email'));
				$f3->set('SESSION.lastseen',time());
				$f3->reroute($f3->get('GET.reroute') ?: '/');
			}
		}

        // if we get here, we failed
        // display the form again with a message
		$this->login($f3);
	}

	// Terminate session
	function logout($f3) {
		$f3->clear('SESSION');
		$f3->reroute($f3->get('GET.reroute') ?: '/');
	}
}