<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends MY_Controller {

	public function index()
	{
	    $this->load->library('form_validation');
	    $this->load->helper('form');
	    if ($this->input->post())
	    {
	        $this->form_validation->set_rules('login','login','callback_check_login');
	        if ($this->form_validation->run())
            {
                $admin = $this->_get_admin_info();
                $this->session->set_userdata('admin_id_login',$admin->id);
                redirect(admin_url('home'));
            }
        }
		$this->load->view('admin/login/index');

	}

	public function check_login()
    {
      $admin = $this->_get_admin_info();
        if ($admin)
        {
            return true;
        }
        $this->form_validation->set_message(__FUNCTION__,'Đăng nhập thất bại ! Kiểm tra lại thông tin đăng nhập');
        return false;
    }

    private function _get_admin_info()
    {
        $this->load->model('admin_model');
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $password = md5($password);
        $where = array('username' => $username, 'password' => $password);
        $admin = $this->admin_model->get_info_rule($where);
        return $admin;
    }

    function test()
    {
        $a = array('Bé','Việt','ABC','ACB');
        foreach ($a as $c)
        {
            $a[] = $c;
        }
        pre($a);
    }

}

/* End of file Login.php */
/* Location: ./application/controllers/admin/Login.php */