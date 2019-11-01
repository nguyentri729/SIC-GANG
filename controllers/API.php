<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class API extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model('M_RestAPI', 'm_api');
    }
    public function SIC($type = '')
    {

        // if ($this->m_api->check_login() == false){
        //     $this->m_api->msg = [
        //         'status' => false,
        //         'msg' => 'Vui long dang nhap'
        //     ];
        //     $this->m_api->return_msg();
        //     exit();
        // }
        

        if ($this->input->get('method') != ''){
            //check login success


            $method = $this->input->get('method');
            switch($method){
                case 'insert':  

                    //them thanh vien

                    

                    break;
                case 'delete':
                    break;
                case 'update':
                    break;
                case 'get':
                    switch ($type) {
                        case 'student_info':
                            //set field 
                            if ($this->input->get('StudentID') == ''){
                                
                                $this->m_api->msg = [
                                    'status' => false,
                                    'msg' => 'Thieu truong student id'
                                ];
                                $this->m_api->return_msg();
                                exit;
                            }
                            $StudentID = $this->input->get('StudentID'); 
                            
                            $this->m_api->msg = [
                                'status' => true,
                                'data' => $this->sic->student_info($StudentID)
                            ];
                            break;
                        
                        default:
                           
                            break;
                    }
                    
                    
                    break;
                default:
                    $this->m_api->msg = [
                        'status' => false,
                        'msg' => 'Co loi xay ra'
                    ];
            }
        }else{
            
        }
        $this->m_api->return_msg();
    }
    public function login(){
        $this->load->model('M_RestAPI', 'm_api');
        
        if ($this->input->get('username') == '' || $this->input->get('password') == ''){
            $this->m_api->msg = [
                'status' => false,
                'msg' => 'Yeu cau ten dang nhap hoac mat khau'
            ];
        }else{
            $usr = $this->input->get('username');
            $pwd = $this->input->get('password');
            $StudentID = $this->sic->login($usr, $pwd);
            if ($StudentID != false){
                //tao access token
                if ($this->m_api->generate_access_token($StudentID)){
                    $this->m_api->msg = [
                        'status' => true,
                        'data' => $this->m_api->data_access_token
                    ];
                }else{
                    $this->m_api->msg = [
                        'status' => false,
                        'msg' => 'Khong the xac minh dang nhap'
                    ];
                   
                }
            }else{
                $this->m_api->msg = [
                    'status' => false,
                    'msg' => 'Sai ten dang nhap hoac mat khau'
                ];
            }

        }

        $this->m_api->return_msg();
        //var_dump();
    }

}

/* End of file Controllername.php */
