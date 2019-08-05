<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category extends CI_Controller {
public function __construct()
{
	parent::__construct();
	//Do your magic here
}
	public function add()
	{
		$data['subview'] = 'admin/addcat_view';
		$data['title'] = 'Add Category';
		$data['info'] = array('name' => 'Viet Tran' ,
							  'email'=> 'viettran1301@gmail.com',
							  'phone'=> '01234542111',
							  'website'=>'hebis.vn' );
		$this->load->view('admin/main', $data);
	}

}

/* End of file Category.php */
/* Location: ./application/controllers/Category.php */