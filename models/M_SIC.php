<?php
// Cac han xu ly co ban 
defined('BASEPATH') OR exit('No direct script access allowed');

class M_SIC extends CI_Model {
 

   function role_exists($table,$field,$value)
   {
       $this->db->where($field,$value);
       $query = $this->db->get($table);
       if (!empty($query->result_array())){
           return 1;
       }
       else{
           return 0;
       }
   }
   function login($user, $pwd){
     
      $pass = sha1($pwd);
      $this->db->where('User', $user);
      $this->db->where('Password', $pass);
      $query = $this->db->get('tb_accounts');
    
      if ($query->num_rows() > 0){
          $this->load->model('M_RestAPI', 'm_api');
          return $query->result_array()[0]['StudentID'];
      }else{
          return false;
      }
      
   }

}

/* End of file M_SIC.php */
