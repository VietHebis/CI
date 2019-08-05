<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 09/08/18
 * Time: 10:40 SA
 */
class order extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('order_model');
    }

    function check_out()
    {

        $dates = "%Y-%m-%d";
        $current_day = mdate($dates);
        //Load validation
        $this->load->library('form_validation');
        $this->load->helper(array('url','form'));
        $this->load->model('transaction_model');
        $this->load->model('order_model');
        // Lấy thông tin giỏ hàng
        $cart = $this->cart->contents();
        $total_items = $this->cart->total();
        if($total_items <= 0){
            redirect();
        }

        //Tổng tiền thanh toán
        $total_amount = 0;
        foreach ($cart as $row){
            $total_amount += $row['subtotal'];
        }
        $this->data['total_amount'] = $total_amount;

    //Nếu thành viên đăng nhập thì lấy thông tin thành viên
        $user_id = 0;
        $user ='';
        if ($this->session->userdata('user_id_login')) {
            $user_id = $this->session->userdata('user_id_login');
            $user = $this->user_model->get_info($user_id);
        }
        $this->data['user'] = $user;

        if ($this->input->post())
        {
            $this->form_validation->set_rules('name','Họ tên','required|min_length[8]');
            $this->form_validation->set_rules('phone','Số điện thoại','numeric|required|min_length[10]');
            $this->form_validation->set_rules('address','Địa chỉ','required|min_length[8]');
            $this->form_validation->set_rules('email','Email nhận hàng','valid_email|required');
            $this->form_validation->set_rules('payment','Cổng thanh toán','required');


            $this->form_validation->set_message("required","%s không được bỏ trống");
            $this->form_validation->set_message("valid_email","%s Sai định dạng");
            $this->form_validation->set_message("numeric","Số điện thoại phải là số");
            $this->form_validation->set_message("max_length","%s vượt quá giới hạn %d ký tự");
            $this->form_validation->set_message("min_length","%s không được dưới %d ký tự");
            $this->form_validation->set_message("matches","Nhập lại không giống với Mật khẩu ");


            if ($this->form_validation->run())
            {
                $payment = $this->input->post('payment');
                $name    = $this->input->post('name');
                $phone   = $this->input->post('phone');
                $address = $this->input->post('address');
                $email   = $this->input->post('email');
                $message = $this->input->post('message');

                $data = array(
                    'status'        => 0, // trạng thái chưa thanh toán
                    'user_id'       => $user_id,
                    'user_name'     => $name,
                    'user_phone'    => $phone,
                    'user_address'  => $address,
                    'user_email'    => $email,
                    'message'       => $message,
                    'amount'        => $total_amount,//Tổng số tiền thnah toán
                    'payment'       => $payment,
                    'created'       => $current_day,
                );

            //Thêm dữ liệu vào bảng transaction

                $this->transaction_model->create($data);
                $transaction_id = $this->db->insert_id();

                // Thêm dữ liệu vào bảng order
               foreach ($cart as $row)
               {
                  $data = array(
                      'transaction_id' => $transaction_id,
                      'product_id'     => $row['id'],
                      'qty'            => $row['qty'],
                      'amount'         => $row['subtotal'],
                      'status'         => 0, // chưa giao hàng cho khách
                  );
                  $this->order_model->create($data);
               }
               // Xóa toàn bộ giỏ hàng
                $this->cart->destroy();
               if ($payment)
               {
                   //Thông báo
                   $this->session->set_flashdata('message', 'Đơn hàng của bạn đã hoàn tất !');
                   redirect(site_url());
               }
               elseif (in_array($payment,array('baokim','nganluong')))
                {
                    $this->load->lib('abc');
                }

            }

        }

        //Load view
        $this->data['temp'] = 'site/order/check_out';
        $this->load->view('site/layout', $this->data);

    }
}