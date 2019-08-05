<?php 
/**
* 
*/
class sinhvien_model extends CI_Model
{
	protected $table = "user";
	public function listSinhvien()
	{
		$this->load->database();
		RETURN $this->db->get($this->table)->result_array();
	}
	public function insert($data)
	{
		$this->load->database();
		$this->db->insert($this->table,$data);
	}
	public function delete($id)
	{
		$this->load->database();
		$this->db->where("id",$id);
		$this->db->delete($this->table);
	}
	public function getsinhvien($id)
	{
		$this->load->database();
		$this->db->where("id",$id);
		RETURN $this->db->get($this->table)->row_array();
	}
	public function update($id,$data)
	{
		$this->load->database();
		$this->db->where("id",$id);
		$this->db->update($this->table,$data);
	}

}
?>