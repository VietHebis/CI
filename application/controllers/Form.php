<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Form extends CI_Controller {

public function __construct()
{
	parent::__construct();
	$this->load->helper(array('url','form'));
	$this->load->library('form_validation');
}
	public function index()
	{
		$this->form_validation->set_rules('username', 'Full name', 'required|min_length[5]');
		$this->form_validation->set_rules('pass', 'Password', 'required|min_length[5]');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
		if ($this->form_validation->run() == FALSE) {
		$this->load->view('view_form');
	}
	}

	
}

/* End of file Form.php */
/* Location: ./application/controllers/Form.php */
 ?>