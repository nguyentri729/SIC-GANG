<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class SimpleRestAPI 
{
    protected $ci;
    public $access_token = '';

    public function __construct()
    {
        $this->ci =& get_instance();
    }

    private function generate_access_token(){
        //create  access_token 
        $ci->load->helper('string');    
        $ramdom_token = random_string('alnum', 16);
        return $ramdom_token;
    }
    public function xinchao(){
        echo 'xinchao';
    }

}

/* End of file SimpleRestAPI.php */
