<?php
Class API extends Controller {

    private $api_configs = [
        'comments' => [
            'select' => 'comments.*, email',
            'join' => 'users ON comments.user_id = users.id',
            'order_by' => 'date ASC',
            'contexts' => [
                'car' => 'context_id = ?'
            ],
            'write_protect' => FALSE
        ],
        'car' => ['order_by' => 'name ASC', 'write_protect' => TRUE]
    ];
    private $data = '';
    private $api_name;
    private $config;

    function beforeroute($f3, $params) {
        // Check if the requested API name exists in the config file
        if (!array_key_exists($params['api_name'], $this->api_configs)) {
            // If not, return a 404 error
            $f3->error(404);
        } else {
            // If it exists, call the parent beforeroute method and set the current API name and config
            parent::beforeroute($f3, $params);
            $this->api_name = $params['api_name'];
            $this->config = $this->api_configs[$this->api_name];
        }
    }

    function fetch($f3, $params) {
        // Get the database connection and the current config for the API
        $db = $this->db;
        $c = $this->config;
    
        // Set up the SELECT, FROM, and JOIN clauses for the SQL query
        $select = $c['select'] ?: '*';
        $from = $this->api_name;
        $join = $c['join'] ? 'JOIN ' . $c['join'] : '';
        // Determine the WHERE clause based on whether an ID or context was specified
        if ($params['id']) {
            $selector = $params['id'];
            $where = 'WHERE id = ?';
        } elseif ($params['context']) {
            $selector = $params['context'];
            $context_name = $params['context_name'];
            $where = 'WHERE ' . $c['contexts'][$context_name];
        } else {
            $where = '';
            $selector = null;
        }
        // Set the ORDER BY clause based on the config file
        $order_by = $c['order_by'];
    
        // Execute the SQL query with the specified clauses and selector value
        $this->data = $db->exec("SELECT $select FROM $from $join $where ORDER BY $order_by", $selector);
    }

    function save($f3, $params) {
        // we allow writing if the user is logged in and either
        // the API is unprotected or they are an admin
        if ($f3->get('logged_in') and 
            (!$this->config['write_protect'] or $f3->get('is_admin'))) {
            // THIS IS MOSTLY COPIED FROM Admin.php
            // IT SHOULD PROBABLY BE REFACTORED INTO A UTILITY CLASS
            //connect to DB
            //read in object
            $db = $this->db;
            $obj=new DB\SQL\Mapper($db, $this->api_name);
            $data = json_decode(file_get_contents('php://input'), true);
            $obj->load(['id=?', $data['id']]);            //update values in object
            $fieldnames = $obj->fields();
            foreach ($fieldnames as $fieldname) {
                if (array_key_exists($fieldname, $data)) {
                    $obj->$fieldname = $data[$fieldname];
                }
            }
            //save object to DB
            $obj->save();

            $this->data = $obj->cast();
        }
    }

    function afterroute($f3) {
        // Set the response header to indicate that the response contains JSON data
        header('Content-Type: application/json');
        
        // Encode the data in JSON format and echo it
        echo json_encode($this->data);
    }
}