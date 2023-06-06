<?php

Class Admin2 extends Controller {
    function show_edit($f3, $params) {
        $db = $this->db;
        $car=new DB\SQL\Mapper($db,'car');
        $car->load(['id=?', $params['id']]);
        $f3->set('item', $car);
        $f3->set('base_name', 'edit');
        echo Template::instance()->render('page.htm');
    }
}