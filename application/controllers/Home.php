<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller {

	public function index()
	{
	    //Load slide
        $this->load->model('slide_model');
        $input = array();
        $slide = $this->slide_model->get_list($input);
		$this->data['slide'] = $slide;

		//Load  sản phẩm
        $this->load->model('sanpham/product_model');
        $input = array();
        $input['limit'] = array(3,0);
        $product_list = $this->product_model->get_list($input);
        $this->data['product_list'] = $product_list;

        //Load sp nhiều người mua
        $input['order'] = array('view','desc');
        $product_buyed = $this->product_model->get_list($input);
        $this->data['product_buyed'] = $product_buyed;

        // In câu thông báo
        $message = $this->session->flashdata('message');
        $this->data['message'] = $message;

        //Load view
        $this->data['temp'] ='site/home/index';
		$this->load->view('site/layout', $this->data);
	}

}

/* End of file Home.php */
/* Location: ./application/controllers/Home.php */