<?php 
/**
* 
*/
class Demo extends CI_Controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->helper('url');
	}
	function index()
	{
		$data = array
		('user' =>"Kaitos" ,
		 'email'=>"viethebis@gmail.com" ,
		 'web'=>"conheos.com",	 
		);
		$this->session->set_userdata($data);
		$this->session->set_flashdata('flash_open', 'Khởi tạo session thành công');
		redirect(base_url('demo/index2'));
	}
	public function index2()
	{
		echo $this->session->flashdata('flash_open');
		$user=$this->session->userdata("user");
        $level=$this->session->userdata("web");
        $email=$this->session->userdata("email");
        echo "Username: $user, Email: $email, Web: $level";
        $data=$this->session->all_userdata();
        echo "<pre>";
        print_r($data);
        echo "</pre>";
	}
	 public function index3()
	{
		$this->session->sess_destroy();
		echo "Destroy complete!";
	}
}

 ?>