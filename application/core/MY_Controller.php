<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

public function __construct()
		{
			parent::__construct();
			//Do your magic here
			$controller = $this->uri->segment(1);
			switch ($controller) {
				case 'admin':{
					$this->load->helper('admin');
                    $admin_id_login = $this->session->userdata('admin_id_login');
                    $this->data['admin_id'] = $admin_id_login;
                    $this->load->model('admin_model');
                    $info = $this->admin_model->get_info($admin_id_login);
                    $this->data['info'] = $info;
					$this->_check_login();
					break;
				}
				
				default:{
				    //$this->load->model('catalog_model');
                    $this->load->model('catalog_model_2');
                    $input = array();
                    $input['where'] = array('parent_id' => 0);
				    $catalog_list = $this->catalog_model_2->get_list($input);
				    foreach ($catalog_list as $row){
				        $input['where'] = array('parent_id' => $row->id);
				        $subs = $this->catalog_model_2->get_list($input);
				        $row->subs = $subs;
                    }
                    $this->data['catalog_list'] = $catalog_list;

                    //Load tin
                    $this->load->model('news_model');
                    $input = array();
                    $input['limit'] = array(5,0);
                    $news_list = $this->news_model->get_list($input);
                    $this->data['news_list'] = $news_list;

                    //Kiểm tra xem đăng nhập thành công hay không
                    $user_id_login = $this->session->userdata('user_id_login');
                    $this->data['user_id_login'] = $user_id_login;
                    if ($user_id_login){
                        $this->load->model('user_model');
                        $info = $this->user_model->get_info($user_id_login);
                        $this->data['info'] = $info;
                    }
                    //load cart
                    $this->load->library('cart');
                    $this->data['total_items'] = $this->cart->total_items();
				}
			}
		}

private function _check_login()
{
	$controller = $this->uri->segment('2');
    $controller = strtolower($controller);
    $admin_id_login = $this->session->userdata('admin_id_login');
//    var_dump($login); exit;
    // Nếu chưa đăng nhập mà truy cập vào 1 controller khác
    if(!$admin_id_login && $controller != 'login')
    {
        redirect(admin_url('login'));
    }
    //Đã đăng nhập sẽ chuyển đến admin
    if ($admin_id_login && $controller == 'login')
    {
        redirect(admin_url('home'));
    }
}
}

/* End of file MY_Controller.php */
/* Location: ./application/core/MY_Controller.php */