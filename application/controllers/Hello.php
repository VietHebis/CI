<?php
if (!defined('BASEPATH'))
exit('Không được truy cập');
/**
* 
*/
class Hello extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->library('db');
	}
	public function index($id= 0, $message = '')
	{
		echo 'Hebi.vn '.$message.' and ID = '.$id;
	}
	
}
?>