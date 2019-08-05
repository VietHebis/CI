<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 21/06/18
 * Time: 1:39 CH
 */
defined('BASEPATH') OR exit('No direct script access allowed');
class Catalog extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('catalog_model');
    }
// Lấy danh sách danh mục sản phẩm
    function index()
    {
        $input = array();
        $list = $this->catalog_model->get_list($input);
        $data['list'] = $list;

//Lấy tổng số
        $total = $this->catalog_model->get_total();
        $data['total'] = $total;

//lấy message

        $message = $this->session->flashdata('message');
        $data['message'] = $message ;

//Load view
        $data['temp'] = 'admin/catalog/index';
        $this->load->view('admin/home',$data);
    }

    function add()
    {
        $this->load->library('form_validation');
        $this->load->helper(array('url','form'));
        if ($this->input->post())
        {
            $this->form_validation->set_rules('name','tên sản phẩm','required');


            if ($this->form_validation->run())
            {
                $name = $this->input->post('name');
                $parent_id = $this->input->post('parent_id');
                $sort_order = $this->input->post('sort_order');
                $data = array(
                    'name' => $name,
                    'parent_id' => $parent_id,
                    'sort_order' => intval($sort_order)
                );
                if ($this->catalog_model->create($data)){
                    //Tạo nd thông báo
                    $this->session->set_flashdata('message','Thêm thành công');
                }
                else{
                    $this->session->set_flashdata('message','Thêm không thành công');
                }
                // Chuyển đén trang adnmin
                redirect(admin_url('catalog'));
            }

        }
        //lấy danh mục cha
        $input = array();
        $input['where'] = array('parent_id' => 0);
        $list = $this->catalog_model->get_list($input);
        $this->data['list'] = $list;


        $this->data['temp'] = 'admin/catalog/add';
        $this->load->view('admin/home', $this->data);

    }

    function edit()
    {
        // lấy id quản trị viên
        $id= $this->uri->rsegment('3');
        // ép kiểu dữ liệu
        $id = intval($id);
        // lấy thông tin quản trị viên
        $info = $this->catalog_model->get_info($id);
        if(!$info)
        {
            $this->session->set_flashdata('message','Sản phẩm không tồn tại');
            redirect(admin_url('catalog'));
        }
        else {
            $this->data['info'] = $info;
            $this->load->library('form_validation');
            $this->load->helper(array('url', 'form'));
            if ($this->input->post()) {
                $this->form_validation->set_rules('name', 'tên sản phẩm', 'required');


                if ($this->form_validation->run()) {
                    $name = $this->input->post('name');
                    $parent_id = $this->input->post('parent_id');
                    $sort_order = $this->input->post('sort_order');
                    $data = array(
                        'name' => $name,
                        'parent_id' => $parent_id,
                        'sort_order' => intval($sort_order)
                    );
                    if ($this->catalog_model->update($id, $data)) {
                        //Tạo nd thông báo
                        $this->session->set_flashdata('message', 'Thêm thành công');
                    } else {
                        $this->session->set_flashdata('message', 'Thêm không thành công');
                    }
                    // Chuyển đén trang adnmin
                    redirect(admin_url('catalog'));
                }

            }
            //lấy danh mục cha
            $input = array();
            $input['where'] = array('parent_id' => 0);
            $list = $this->catalog_model->get_list($input);
            $this->data['list'] = $list;


            $this->data['temp'] = 'admin/catalog/edit';
            $this->load->view('admin/home', $this->data);

        }

    }
    public function delete()
    {
        $id = $this->uri->rsegment(3);
        $id = intval($id);
        $info = $this->catalog_model->get_info($id);
        if (!$info)
        {
            $this->session->set_flashdata('message','Sản phẩm không tồn tại!');
            redirect(admin_url('catalog'));
        }
        //Kiểm tra xem trong danh mục có sản phẩm hay không
        $this->load->model('sanpham/product_model');
        $check = $this->product_model->get_info_rule(array('catalog_id' => $id),'id');
        if ($check)
        {
            $this->session->set_flashdata('message','Tồn tại sản phẩm, hãy xóa sản phẩm trước !');
            redirect(admin_url('catalog'));
        }

        // Thực hiện xóa
        if ($this->catalog_model->delete($id))
        {
            $this->session->set_flashdata('message','Xóa thành công');
        }
        else
        {
            $this->session->set_flashdata('message','Xóa thất bại');
        }
        redirect(admin_url('catalog'));
    }

    function dell_all()
    {
        $ids = $this->input->post('ids');
        foreach ($ids as $id) {
            $this->_dell($id);
        }
    }

    private function _dell($id)
    {
        $info = $this->catalog_model->get_info($id);
        if (!$info)
        {
            $this->session->set_flashdata('message','Sản phẩm không tồn tại!');
            redirect(admin_url('catalog'));
        }
        //Kiểm tra xem trong danh mục có sản phẩm hay không
        $this->load->model('sanpham/product_model');
        $check = $this->product_model->get_info_rule(array('catalog_id' => $id),'id');
        if ($check)
        {
            $this->session->set_flashdata('message','Tồn tại sản phẩm, hãy xóa sản phẩm trước !');
            redirect(admin_url('catalog'));
        }
        // Thực hiện xóa
        if ($this->catalog_model->delete($id))
        {
            $this->session->set_flashdata('message','Xóa thành công');
        }
        else
        {
            $this->session->set_flashdata('message','Xóa thất bại');
        }
        redirect(admin_url('catalog'));
    }
}