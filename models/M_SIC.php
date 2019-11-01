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
   function student_info($StudentID){

        $this->db->select('*');
        $this->db->from('tb_students');
       // $this->db->join('tb_accesshistories', 'tb_accesshistories.StudentID = tb_students.StudentID', 'left');
        $this->db->join('tb_studentimgs', 'tb_studentimgs.StudentID = tb_students.StudentID', 'left');
        $this->db->where('tb_students.StudentID', $StudentID);
        $query = $this->db->get();
        #get class
        if ($query->num_rows() > 0){
            $info = $query->result_array()[0];
           // return $info;
            #get class name and tb_faculties
            $class_id = $info['ClassID'];
            $this->db->select('tb_faculties.Name_faculties, tb_classes.Name_classes');
            $this->db->from('tb_faculties');
            $this->db->join('tb_classes', 'tb_faculties.FacultyID = tb_classes.FacultyID');
            $this->db->where('tb_classes.ClassID', $class_id);
            $class = $this->db->get()->result_array()[0];
            $info['Name_faculties'] = $class['Name_faculties'];
            $info['Name_classes'] = $class['Name_classes'];
            return $info;
        }else{
            return [
                'msg' => 'Khong the get student ID'
            ];
        }
 
   }

}

/* End of file M_SIC.php */
