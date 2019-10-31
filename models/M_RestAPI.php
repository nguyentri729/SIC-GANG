<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_RestAPI extends CI_Model {
    private $header = [];
    private $time_live = 86400;
    public $msg = ['status' => false, 'msg' => 'Có lỗi xảy ra !'];
    public $data_access_token = [];
    function __construct() {
        parent::__construct();
        $this->header = $this->input->request_headers();
    }
    /*
        @Genarate Access Token
    */
    public function generate_access_token($StudentID = ''){
        #create  access_token 
        $this->load->helper('string');    
        $ramdom_token = (random_string('alnum', 30));
        if ($StudentID != ''){
            #check studentID avaiable
            if (!$this->sic->role_exists('restapi', 'access_token', $ramdom_token)){
               $this->data_access_token = [  
                'StudentID' => $StudentID, 
                'access_token' => $ramdom_token, 
                'time_start' => time(),
                'time_end' => time() + $this->time_live
               ];
               return $this->db->insert('restapi', $this->data_access_token);
            }
        }
        return false;
    }
    /*
        @Check login Status
    */
    public function check_login(){
        if(isset($this->header['access_token'])){
            if ($this->sic->role_exists('restapi', 'access_token', $this->header['access_token'])){
                $this->db->where('access_token', $this->header['access_token']);
                //$this->db->where('time', $Value);
                $this->db->update('restapi', [  
                    'time_end' => time() + $this->time_live
                ]);
                return true;
            }else{
                $this->msg = ['status' => false, 'msg' => 'Access toen khong hop le'];
                return false;
            }
        }else{
           $this->msg = ['status' => false, 'msg' => 'Khong co access_token'];
           return false;
        }
    }

    /*
        @return msg 
        @default return json type
    */
    public function return_msg($code = 200){
        http_response_code($code);
        header('Content-Type: application/json');
        echo json_encode($this->msg);
    }
   
    /*
        @return msg 
        @default return json type
    */

    public function return_mess($data){
        http_response_code(200);
        header('Content-Type: application/json');
        echo json_encode($data);
    }
}

/* End of file M_RestAPI.php */
