<?php

Class Admin extends Controller {
    function show_edit($f3, $params) {
        $db = $this->db;
        $car=new DB\SQL\Mapper($db,'car');
        $car->load(['id=?', $params['id']]);
        $f3->set('item', $car);
        $f3->set('template', 'edit.htm');

        if (!$f3->get('is_admin')) {
            $f3->reroute('/');
        }
        
        echo Template::instance()->render('page.htm');
    }

    /*function is_admin() {
        if ($_SESSION['is_admin'] == TRUE) {
            return true;
        }
        return false;
    }*/

    function do_edit($f3, $params) {
    
    
        // Connect to DB
        // Read in object
        $db = $this->db;
        $car = new DB\SQL\Mapper($db,'car');
        $id = $params['id'];
        $car->load(['id=?', $params['id']]);
    
        // Update values in object
        $fieldnames = $car->fields();
        foreach ($fieldnames as $fieldname) {
            $saved_data = $f3->get("POST.$fieldname");
            if (isset($saved_data)) {
                $car->$fieldname = $saved_data;
            }
        }
        //save object to DB
        $car->save();
        //if we made a new record, get the new ID
        if ($id == 'new') {
            $id = $car->id;
        }
        //return to the editor
        $f3->reroute("edit/$id");
    }
}