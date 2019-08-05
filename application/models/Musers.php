<?php
// models/Users.php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Musers extends CI_Model 
{
    function __construct() 
    {
      parent::__construct();
    }
 
    public function get_current_page_records($limit, $start) 
    {
        $this->db->limit($limit, $start);
        $query = $this->db->get("crm_acc");
 
        if ($query->num_rows() > 0) 
        {
            foreach ($query->result() as $row) 
            {
                $data[] = $row;
            }
             
            return $data;
        }
 
        return false;
    }
     
    public function get_total() 
    {
        return $this->db->count_all("crm_acc");
    }
}