<?php
// Start the framework, then load the config files
$f3 = require('../../lib/base.php'); // load the base framework file
$f3->config('../app/config.ini'); // load the configuration file for the application
$f3->config('../app/routes.ini'); // load the file that defines the routes for the application
$f3->run(); // start the application by running the main routing code
