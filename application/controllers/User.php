<?php 
/**
* 
*/
class user extends MY_Controller
{
		public function __construct()
		{
			parent::__construct();
			$this->load->model('user_model');
		}

        function  check_email()
        {
        $email = $this->input->post('email');
        $where = array('email' => $email);
        if($this->user_model->check_exists($where))
        {
            $this->form_validation->set_message(__FUNCTION__,'Email is exist');
            return false;
        }
        return true;

        }

		public function register()
		{
            if ($this->session->userdata('user_id_login')){
                redirect('user');
            }
            $this->load->library('form_validation');
            $this->load->helper(array('url','form'));
            if ($this->input->post())
            {
                $this->form_validation->set_rules('name','Họ tên','required|min_length[8]');
                $this->form_validation->set_rules('email','Email','trim|valid_email|required|callback_check_email');
                $this->form_validation->set_rules('password','Password','trim|required|min_length[8]');
                $this->form_validation->set_rules('re_password','Re_Password','trim|matches[password]');
                $this->form_validation->set_rules('phone','Số điện thoại','numeric|required|min_length[10]');
                $this->form_validation->set_rules('address','Địa chỉ','required|min_length[8]');

                $this->form_validation->set_message("required","%s không được bỏ trống");
                $this->form_validation->set_message("valid_email","%s Sai định dạng");
                $this->form_validation->set_message("numeric","Số điện thoại phải là số");
                $this->form_validation->set_message("max_length","%s vượt quá giới hạn %d ký tự");
                $this->form_validation->set_message("min_length","%s không được dưới %d ký tự");
                $this->form_validation->set_message("matches","Nhập lại không giống với Mật khẩu ");


                if ($this->form_validation->run())
                {
                    $name = $this->input->post('name');
                    $email = $this->input->post('email');
                    $password = $this->input->post('password');
                    $phone = $this->input->post('phone');
                    $address = $this->input->post('address');
                    $data = array(
                        'name'     => $name,
                        'password' => md5($password),
                        'email'    => $email,
                        'phone'    => $phone,
                        'address'  => $address,
                        'created'  => now()
                    );
                    if ($this->user_model->create($data)){
                        $info = $this->_get_users_info();
                        $this->session->set_userdata('user_email',$info->email);
                        //Tạo nd thông báo
                       $this->session->set_flashdata('message','Đăng ký thành công');
                    }
                    else{
                        $this->session->set_flashdata('message','Đăng ký thất bại');
                    }
                    // Chuyển đén trang
                    redirect('user/login');
                }

            }

            //load view
            $this->data['temp'] = 'site/users/register';
            $this->load->view('site/layout', $this->data);
		}

		/*
		 * Kiểm tra đăng nhập
		 */
		function login()
        {
            if ($this->session->userdata('user_id_login')){
                redirect('user');
            }
            $this->load->library('form_validation');
            $this->load->helper(array('url','form'));
            if ($this->input->post())
            {
                $this->form_validation->set_rules('email','Email','required|valid_email');
                $this->form_validation->set_rules('password','Password','trim|required|min_length[8]');
                $this->form_validation->set_rules('login','login','callback_check_login');
                $this->form_validation->set_message("required","%s không được bỏ trống");
                $this->form_validation->set_message("valid_email","%s Sai định dạng");
                $this->form_validation->set_message("min_length","%s không được dưới %d ký tự");

                if ($this->form_validation->run())
                {
                    $user = $this->_get_users_info();
                    //găn session cho user
                    $this->session->set_userdata('user_id_login',$user->id);
                    redirect();
                }
            }
            //load view
            $this->data['temp'] = 'site/users/login';
            $this->load->view('site/layout', $this->data);
        }

     function check_login()
    {
        if ($this->session->userdata('user_id_login')){
            redirect('user');
        }
        $user = $this->_get_users_info();
        if ($user)
        {
            return true;
        }

        $this->form_validation->set_message(__FUNCTION__,'Đăng nhập thất bại ! Kiểm tra lại thông tin đăng nhập');
        return false;
    }
    /*
     * Lấy thông tin thành viên
     */
    function index()
    {
       if (!$this->session->userdata('user_id_login')) {
           redirect();
       }
       $user_id = $this->session->userdata('user_id_login');
       $user = $this->user_model->get_info($user_id);
       $this->data['user'] = $user;

        //load view
        $this->data['temp'] = 'site/users/index';
        $this->load->view('site/layout', $this->data);

    }

    /*
     * Chỉnh sửa thông tin thành viên
     */
    function edit()
    {
        $this->load->library('form_validation');
        $this->load->helper(array('url','form'));
        if (!$this->session->userdata('user_id_login')) {
            redirect('user/login');
        }
        $user_id = $this->session->userdata('user_id_login');
        $user = $this->user_model->get_info($user_id);
        $this->data['user'] = $user;
        if ($this->input->post())
        {
            $this->form_validation->set_rules('name','Họ tên','required|min_length[8]');
            $this->form_validation->set_rules('phone','Số điện thoại','numeric|required|min_length[10]');
            $this->form_validation->set_rules('address','Địa chỉ','required|min_length[8]');

            //Nếu nhập pass thì check
            if ($this->input->password){
                $this->form_validation->set_rules('password','Password','trim|required|min_length[8]');
                $this->form_validation->set_rules('re_password','Re_Password','trim|matches[password]');
            }

            $this->form_validation->set_message("required","%s không được bỏ trống");
            $this->form_validation->set_message("valid_email","%s Sai định dạng");
            $this->form_validation->set_message("numeric","Số điện thoại phải là số");
            $this->form_validation->set_message("max_length","%s vượt quá giới hạn %d ký tự");
            $this->form_validation->set_message("min_length","%s không được dưới %d ký tự");
            $this->form_validation->set_message("matches","Nhập lại không giống với Mật khẩu ");


            if ($this->form_validation->run())
            {
                $name = $this->input->post('name');
                $phone = $this->input->post('phone');
                $address = $this->input->post('address');
                $password = $this->input->post('password');

                $data = array(
                    'name'     => $name,
                    'phone'    => $phone,
                    'address'  => $address,
                );

                //Nếu nhập pass thì check
                if ($password){
                    $data['password'] = md5($password);
                }


                if ($this->user_model->update($user_id,$data)){
                    //Tạo nd thông báo
                    $this->session->set_flashdata('message','Chỉnh sửa thành công');
                }
                else{
                    $this->session->set_flashdata('message','Chỉnh sửa thất bại');
                }
                // Chuyển đén trang
                redirect('user');
            }

        }

        //load view
        $this->data['temp'] = 'site/users/edit';
        $this->load->view('site/layout', $this->data);

    }

    /*
     * Lấy thông tin user
     */
    private function _get_users_info()
    {
        $email = $this->input->post('email');
        $password = $this->input->post('password');
        $password = md5($password);
        $where = array('email' => $email, 'password' => $password);
        $user = $this->user_model->get_info_rule($where);
        return $user;
    }

    function logout()
    {
        if ($this->session->userdata('user_id_login'))
        {
            $this->session->unset_userdata('user_id_login');
            $this->session->unset_userdata('user_email');
        }
        redirect();
    }

    function test()
    {
        $mang = array('Trường', 'Sa', 'Hoàng', 'Sa', 'Là', 'Của', 'Việt', 'Nam');
        foreach ( $mang AS $item ) {
            $item = strtoupper($item);
        }
        echo '<pre>';
        print_r($mang);

        $mang = array('Trường', 'Sa', 'Hoàng', 'Sa', 'Là', 'Của', 'Việt', 'Nam');
        foreach ( $mang AS &$item ) {
            $item = strtoupper($item);
        }
        echo '<pre>';
        print_r($mang);

        $mang = array('Trường', 'Sa', 'Hoàng', 'Sa', 'Là', 'Của', 'Việt', 'Nam');
        foreach ( $mang AS $item ) {
            $mang[] = $item;
        }
        echo '<pre>';
        print_r($mang);

    }
    function contact()
    {
        $this->load->helper('form');
        $this->load->library('form_validation');
        if ($this->input->post())
        {
            $this->form_validation->set_rules('name','Name','required|min_length[8]');
            $this->form_validation->set_rules('email','Email','required|valid_email');
            $this->form_validation->set_rules('subject','Message','required|min_length[10]');

            $this->form_validation->set_message('required','%s is null !');
            $this->form_validation->set_message('valid_email','%s Wrong type email !');
            $this->form_validation->set_message('min_length','%s not enough %d character');

            if($this->form_validation->run())
            {
                $email = $this->input->post('email');
                $name = $this->input->post('name');

                if (!$this->_send_mail($email,$name))
                {
                    echo $this->email->print_debugger();
                }


               echo '<p style="font-size: larger;color: #0e76a8">Mail sent !</p>';


            }
        }
        $this->data['temp'] = 'site/contact';
        $this->load->view('site/layout',$this->data);
    }
    private function _send_mail($email = '',$name = '')
    {

        $config = array(
//            'protocol' =>'sendmail',
            'protocol' => 'smtp',
            'smtp_host' => 'smtp.gmail.com',
            'smtp_port' => 587,
            'smtp_crypto' => 'tls',
            'smtp_user' => 'viet.tranquoc@digitel.com.vn',
            'smtp_pass' => '0906570205',
            'charset' => 'utf-8',
            'mailtype' => 'text',
            'newline' => "\r\n",);

        $this->load->library('email');
        $this->email->initialize($config);
        $this->email->from('viet.tranquoc@digitel.com.vn', 'Support');
        $this->email->to($email);
        $this->email->reply_to('viet.tranquoc@digitel.com.vn','Viet Tran');
        $this->email->subject('Support');
        $this->email->message('Chào '.$name.'! Yêu cầu của bạn đã được chuyển đi.');
        $this->email->send();

    }

    function challenge()
    {
        function test($b)
        {
            static $a = 10;
            $a += $b;
            return $a;
        }
        for ($i = 0; $i<3; ++$i)
        {
            test($i);
            $a[] = $i;
        }

        echo test(1) + count($a) ;
    }

    function remind()
    {
        $user = isset($_SESSION['user']) ? $_SESSION['user'] : '';
        $this->data['user'] = $user;
        $this->load->view('remind/index',$this->data);
    }

}
 ?>