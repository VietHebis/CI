<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Demolang extends CI_Controller {
public function __construct()
{
	parent::__construct();
	//Do your magic here
}
	public function index()
	{
		$this->lang->load('vi','vietnamese');
		$this->load->view('demolang');
	}

}

/* End of file demolang.php */
/* Location: ./application/controllers/demolang.php */
 ?>