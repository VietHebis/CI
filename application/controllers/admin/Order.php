<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 22/06/18
 * Time: 9:43 SA
 */
defined('BASEPATH') OR exit('No direct script access allowed');
class Order extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('order_model');
    }

    /*
     * Hiển thị danh sach sản phẩm
     */
    function index()
    {
        //Load lib phân trang
        $this->load->library('pagination');
        $total_rows = $this->order_model->get_total();
        $this->data['total_rows'] = $total_rows;
        $config = array();
        $config['total_rows'] = $total_rows; //tổng tất cả sản phẩm trên website
        $config['base_url'] = admin_url('order/index'); //Vị trí trang cần phân trang
        $config['per_page'] = 5; //Số lượng sp cần hiển thị trên 1 trang
        $config['uri_segment'] = 4; //Phân đoạn hiển thị ra số trang trên url
        $config['next_link'] = 'Trang kế';
        $config['prev_link'] = 'Trang trước';
        //Khỏi tạo các cấu hình phân trang
        $this->pagination->initialize($config);

        $segment = $this->uri->segment(4);
        $segment = intval($segment);

        $input = array();
        $input['limit'] = array($config['per_page'], $segment);

        //Kiểm tra xem có lọc hay không
        $id = $this->input->get('id');
        $id = intval($id);
        $input['where'] = array();
        if ($id > 0) {
            $input['where']['id'] = $id;
        }

        $name = $this->input->get('name');
        if ($name) {
            $input['like'] = array('name', $name);
        }

        $catalog_id = $this->input->get('catalog');
        $catalog_id = intval($catalog_id);
        if ($catalog_id > 0) {
            $input['where']['catalog_id'] = $catalog_id;
        }


        //Lấy danh sách sản phẩm
        $list = $this->order_model->get_list($input);
        $this->data['list'] = $list;

        //Lấy danh mục tất cả sp
        $this->load->model('catalog_model');
        $input = array();
        $input['where'] = array('parent_id' => 0);
        $catalogs = $this->catalog_model->get_list($input);
        foreach ($catalogs as $row) {
            $input['where'] = array('parent_id' => $row->id);
            $sub = $this->catalog_model->get_list($input);
            $row->sub = $sub;
        }
        $this->data['catalogs'] = $catalogs;

        // In câu thông báo
        $message = $this->session->flashdata('message');
        $this->data['message'] = $message;

        //Load View
        $this->data['temp'] = 'admin/order/index';
        $this->load->view('admin/home', $this->data);
    }
}