<?php
Class Cart extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('sanpham/product_model');
    }
    function add()
    {
        //lấy id sản phẩm
        $id = $this->uri->segment(3);
        $product = $this->product_model->get_info($id);
        if (!$product)
        {
            redirect();
        }

        // Tong so san pham
        $qty = 1;
        $price = $product->price;
        if ($product->discount > 0)
        {
            $price = $product->price - $product->discount;
        }

        //Thong tin them vao gio hang
        $data = array();
        $data['qty'] = $qty;
        $data['price'] = $price;
        $data['id'] = $id;
        $data['name'] = url_title($product->name);
        $data['image_link'] = $product->image_link;
        $this->cart->insert($data);

        //Chuyen den trang gio hang
        redirect(base_url('cart'));
    }
    function index()
    {
        //lấy tổng số sản phẩm
        $total_items = $this->cart->total_items();
        $this->data['total_items'] = $total_items;
        //Lấy thông tin giỏ hàng
        $cart = $this->cart->contents();
        $this->data['cart'] = $cart;

        //Load view
        $this->data['temp'] = 'site/cart/index';
        $this->load->view('site/layout',$this->data);
    }
    //Cạp nhan gio hang
    function update()
    {
        $cart = $this->cart->contents();
        //pre($cart);
        foreach ($cart as $key => $row)
        {
            $total_qty = $this->input->post('qty_'.$row['id']);
            $data = array();
            $data['rowid'] = $key;
            $data['qty'] = $total_qty;
            $this->cart->update($data);
        }
        redirect(base_url('cart'));
    }
    //Xoa gio hang
    function del()
    {
        $id = $this->uri->segment(3);
        $id = intval($id);
        // Trường hợp xóa 1 sản phẩm
        if ($id > 0)
        {
            $cart = $this->cart->contents();
            //pre($cart);
            foreach ($cart as $key => $row)
            {
                if ($row['id'] == $id)
                {
                    $data = array();
                    $data['rowid'] = $key;
                    $data['qty'] = 0;
                    $this->cart->update($data);
                }

            }
        }
        else
        {
            $this->cart->destroy();
        }
        redirect(base_url('cart'));
    }
}