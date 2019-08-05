<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends MY_Controller {
public function __construct()
{
	parent::__construct();
	$this->load->model('admin_model');
}
public function index()
    {
	$input = array();
	$list = $this->admin_model->get_list($input);
	$this->data['list'] = $list;

	$total = $this->admin_model->get_total();
	$this->data['total'] = $total;
//Lấy nội dung của biến message
    $message = $this->session->flashdata('message');
    $this->data['message'] = $message;

	$this->data['temp'] = 'admin/admin/index';
	$this->load->view('admin/home', $this->data);

    }
    function  check_username()
    {
        $username = $this->input->post('username');
        $where = array('username' => $username);
        if($this->admin_model->check_exists($where))
        {
            $this->form_validation->set_message(__FUNCTION__,'Username is exist');
          return false;
      }
        return true;
    }
	public function add()
	{
	    $this->load->library('form_validation');
	    $this->load->helper(array('url','form'));
	    if ($this->input->post())
        {
            $this->form_validation->set_rules('name','Họ tên','required|min_length[8]');
            $this->form_validation->set_rules('username','Username','required|callback_check_username');
            $this->form_validation->set_rules('password','Password','required|min_length[8]');
            $this->form_validation->set_rules('repassword','RePassword','matches[password]');

            if ($this->form_validation->run())
            {
                $name = $this->input->post('name');
                $username = $this->input->post('username');
                $password = $this->input->post('password');
                $data = array(
                    'name' => $name,
                    'username' => $username,
                    'password' => md5($password)
                );
                if ($this->admin_model->create($data)){
                    //Tạo nd thông báo
                    $this->session->set_flashdata('message','Thêm thành công');
                }
                else{
                    $this->session->set_flashdata('message','Thêm không thành công');
                }
                // Chuyển đén trang adnmin
                redirect(admin_url('admin'));
            }

        }
        $this->data['temp'] = 'admin/admin/add';
        $this->load->view('admin/home', $this->data);

	}


	public function edit()
	{
	    // lấy id quản trị viên
		$id= $this->uri->rsegment('3');
		// ép kiểu dữ liệu
		$id = intval($id);
		// lấy thông tin quản trị viên
		$info = $this->admin_model->get_info($id);
		if(!$info)
        {
            $this->session->set_flashdata('message','Quản trị viên không tồn tại');
            redirect(admin_url('admin'));
        }
        else
        {
            //pre($info);
            $this->load->library('form_validation');
            $this->load->helper(array('url','form'));
            $this->data['info'] = $info;
            if ($this->input->post())
            {
                $this->form_validation->set_rules('name','Họ tên','required|min_length[8]');

                $password = $this->input->password;
                if ($password)
                {
                    $this->form_validation->set_rules('password','Password','required|min_length[8]');
                    $this->form_validation->set_rules('repassword','RePassword','matches[password]');
                }
                if($this->form_validation->run())
                {
                    $name = $this->input->post('name');
                    $data = array(
                        'name' => $name,
                    );
                    if ($password)
                    {
                        $data['password'] = $password;
                    }
                    if ($this->admin_model->update($id,$data)){
                        //Tạo nd thông báo
                        $this->session->set_flashdata('message','Cập nhật thành công');
                    }
                    else{
                        $this->session->set_flashdata('message','Cập nhật không thành công');
                    }
                    redirect(admin_url('admin'));
                }
            }
            $this->data['temp'] = 'admin/admin/edit';
            $this->load->view('admin/home', $this->data);
        }
	}
	public function delete()
	{
		$id = $this->uri->rsegment(3);
		$id = intval($id);
		$info = $this->admin_model->get_info($id);
		if (!$info)
        {
            $this->session->set_flashdata('message','Không tồn tại Quản Trị Viên này !');
            redirect(admin_url('admin'));
        }
		if ($this->admin_model->delete($id))
        {
            $this->session->set_flashdata('message','Xóa thành công');
        }
		else
        {
            $this->session->set_flashdata('message','Xóa thất bại');
        }
        redirect(admin_url('admin'));
	}

	function logout()
    {
        if ($this->session->userdata('admin_id_login'))
        {
            $this->session->unset_userdata('admin_id_login');
        }
        redirect(admin_url('login'));
    }
	public function info()
	{
		$id = 1;
		$info = $this->admin_model->get_info($id,'username, password');
		dump($info);
	}
	public function get_list()
	{
		$input = array();
		//$input['where'] = array('username' , 'asc' );
		//$input['order'] = array('username' , 'asc' );
		//$input['limit'] = array('username' , 'asc' );
		$input['like'] = array('name' , 'mod' );
		$list = $this->admin_model->get_list($input);
		dump($list);
	}

}

/* End of file Admin.php */
/* Location: ./application/controllers/admin/Admin.php */