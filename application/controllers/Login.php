<?php
/**
* 
*/
class Login extends CI_Controller
{
	function __construct()
	{
		parent:: __construct();
	}

	public function load_form()
	{
		$data = array(
			'title' =>'Đây là trang login',
			'message' => 'Nhập thông tin'
		 );
		$this->load->view('login_view',$data);
		$this->load->database();
	}

	public function test()
	{
		$this->data['testdata'] = array(1,2);
		$this->load->view('login_view', $this->data);
	}
}
?>