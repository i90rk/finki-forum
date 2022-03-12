<?php

class Mongo_db extends Mongo {

    public $db;

    function __construct()
    {   
        // Fetch CodeIgniter instance
        $ci = get_instance();
        // Load Mongo configuration file
        $ci->load->config('mongo_config');

        // Fetch Mongo server and database configuration
        $server = $ci->config->item('mongo_server');
        $username = $ci->config->item('mongo_username');
        $password = $ci->config->item('mongo_password');
        $dbname = $ci->config->item('mongo_dbname');

        // Initialise Mongo - Authentication required
        try{
            // parent::__construct("mongodb://$username:$password@$server/$dbname");
            parent::__construct($server);
            $this->db = $this->$dbname;
        }catch(MongoConnectionException $e){
            //Don't show Mongo Exceptions as they can contain authentication info
            $_error =& load_class('Exceptions', 'core');
            exit($_error->show_error('MongoDB Connection Error', 'A MongoDB error occured while trying to connect to the database!', 'error_db'));           
        }catch(Exception $e){
            $_error =& load_class('Exceptions', 'core');
            exit($_error->show_error('MongoDB Error',$e->getMessage(), 'error_db'));           
        }
    }
}