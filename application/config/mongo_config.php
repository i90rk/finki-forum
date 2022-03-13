<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// $config['mongo_server'] = 'localhost';
// $config['mongo_dbname'] = 'finki_forum';
// $config['mongo_username'] = '';
// $config['mongo_password'] = '';

$config['mongo_server'] = getenv('MONGO_SERVER');
$config['mongo_dbname'] = getenv('MONGO_DBNAME');
$config['mongo_username'] = getenv('MONGO_USERNAME');
$config['mongo_password'] = getenv('MONGO_PASSWORD');

/* End of file mongo.php */