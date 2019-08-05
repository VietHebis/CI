<?php
class Product extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        //load model san pham
        $this->load->model('sanpham/product_model');
    }

    //Lay danh sach danh muc
    function catalog()
    {
        //lay id san pham
        $id = $this->uri->segment('3');
        $id = intval($id);
        //lay thong tin danh muc
        $catalog = $this->catalog_model->get_info($id);
        if (!$catalog) {
            redirect();
        }
        $this->data['catalog'] = $catalog;
        $input = array();
        //Kiem tra danh muc cha
        if ($catalog->parent_id == 0) {
            $input_catalog = array();
            $input_catalog['where'] = array('parent_id' => $id);
            $catalog_subs = $this->catalog_model->get_list($input_catalog);
            $this->data['catalog_subs'] = $catalog_subs;
            if (isset($catalog_subs)) // Nếu danh mục hiện tại có danh mục con
            {
                $catalog_subs_id = array();
                foreach ($catalog_subs as $subs) {
                    $catalog_subs_id[] = $subs->id;
                }
                // Lấy tất cả sản phẩm
                $this->db->where_in('catalog_id', $catalog_subs_id);
            } else {
                $input['where'] = array('catalog_id' => $id);
            }
        } else {
            $input['where'] = array('catalog_id' => $id);
        }


        //Load lib phân trang
        $this->load->library('pagination');
        $total_rows = $this->product_model->get_total($input);
        $this->data['total_rows'] = $total_rows;
        $config = array();
        $config['total_rows'] = $total_rows; //tổng tất cả sản phẩm trên website
        $config['base_url'] = base_url('product/catalog/' . $id); //Vị trí trang cần phân trang
        $config['per_page'] = 6; //Số lượng sp cần hiển thị trên 1 trang
        $config['uri_segment'] = 4; //Phân đoạn hiển thị ra số trang trên url
        $config['next_link'] = 'Trang kế';
        $config['prev_link'] = 'Trang trước';
        //Khỏi tạo các cấu hình phân trang
        $this->pagination->initialize($config);

        $segment = $this->uri->segment(4);
        $segment = intval($segment);

        $input['limit'] = array($config['per_page'], $segment);

        if (isset($catalog_subs_id)) {
            $this->db->where_in('catalog_id', $catalog_subs_id);
        }

        //lay san pham thuoc danh muc
        $product = $this->product_model->get_list($input);
        $this->data['product'] = $product;

        //load view
        $this->data['temp'] = 'site/product/product';
        $this->load->view('site/layout', $this->data);
    }

    //Xem chi tiet san pham
    function view_product()
    {
        //lay id san pham
        $id = $this->uri->segment(3);
        $product = $this->product_model->get_info($id);
        if (!$product) {
            redirect();
        }
        $this->data['product'] = $product;

        //rate
       $product->raty = ($product->rate_count > 0) ? ($product->rate_total/$product->rate_count) : 0;
       $this->data['product'] = $product;

        //image_list
        $image_list = @json_decode($product->image_list);
        $this->data['image_list'] = $image_list;


        // tăng lượt view
        $data = array();
        $view = $product->view + 1;
        $data['view'] = $view;
        $this->product_model->update($product->id, $data);

        //lay danh muc san pham
        $catalog = $this->catalog_model->get_info($product->catalog_id);
        $this->data['catalog'] = $catalog;

        //load view
        $this->data['temp'] = 'site/product/view_product';
        $this->load->view('site/layout', $this->data);
    }

    function search()
    {
        $key = $this->input->get('key-search');
        $input = array();
        $input['like'] = array('name', $key);
        //Load lib phân trang
        $this->load->library('pagination');
        $total_rows = $this->product_model->get_total($input);
        $this->data['total_rows'] = $total_rows;
        $config = array();
        if (count($_GET) > 0) $config['suffix'] = '?' . http_build_query($_GET, '', "&");
        $config['total_rows'] = $total_rows; //tổng tất cả sản phẩm trên website
        $config['base_url'] = base_url('product/search');//site_url('product/search?key-search='.$key.'&but='); //Vị trí trang cần phân trang
        $config['per_page'] = 1; //Số lượng sp cần hiển thị trên 1 trang
        $config['uri_segment'] = 3; //Phân đoạn hiển thị ra số trang trên url
        $config['next_link'] = 'Trang kế';
        $config['prev_link'] = 'Trang trước';
        //Khỏi tạo các cấu hình phân trang
        $this->pagination->initialize($config);

        $segment = $this->uri->segment(3);
        $segment = intval($segment);


        $input['limit'] = array($config['per_page'], $segment);


        $product = $this->product_model->get_list($input);
        $this->data['product'] = $product;
        $this->data['key'] = trim($key);

        //load view
        $this->data['temp'] = 'site/product/search_product';
        $this->load->view('site/layout', $this->data);
    }

    //autocomplete
    function autocomplete()
    {

        //Lấy dữ liệu từ autocomplete
        $key = $this->input->get('term');


        $input = array();
        $input['like'] = array('name', $key);
        $input['limit'] = array(3,0);
        $product = $this->product_model->get_list($input);

            //Xử lý autocomplete
            $result = array();
            foreach ($product as $row) {
                $items = array();
                $items['id'] = $row->id;
                $items['label'] = $row->name;
                $items['value'] = $row->name;
                $result[] = $items;
            }
            //du lieu tra ve duoi dang json
            die(json_encode($result));



    }

    //Tìm theo giá sản phẩm
    function search_price()
    {
        $price_from = $this->input->get('price_from');
        $price_to = $this->input->get('price_to');
        $this->data['price_from'] = $price_from;
        $this->data['price_to'] = $price_to;
        $input= array();
        $input['where'] = array('price >=' => $price_from, 'price <=' => $price_to);
        //Load lib phân trang
        $this->load->library('pagination');
        $total_rows = $this->product_model->get_total($input);
        $this->data['total_rows'] = $total_rows;
        $config = array();
        $config['reuse_query_string'] = TRUE;
        $config['suffix'] = '?' . http_build_query($_GET, '', "&");
        $config['total_rows'] = $total_rows; //tổng tất cả sản phẩm trên website
        $config['base_url'] = base_url('product/search_price');//site_url('product/search?key-search='.$key.'&but='); //Vị trí trang cần phân trang
        $config['per_page'] = 2; //Số lượng sp cần hiển thị trên 1 trang
        $config['uri_segment'] = 3; //Phân đoạn hiển thị ra số trang trên url
        $config['next_link'] = 'Trang kế';
        $config['prev_link'] = 'Trang trước';
//        print_r($config);die;
        //Khỏi tạo các cấu hình phân trang
        $this->pagination->initialize($config);

        $segment = $this->uri->segment(3);
        $segment = intval($segment);

        $input['limit'] = array($config['per_page'], $segment);
        $product = $this->product_model->get_list($input);
        $this->data['product'] = $product;


        //load view
        $this->data['temp'] = 'site/product/search_price';
        $this->load->view('site/layout', $this->data);
    }

    function raty()
    {
        $id = $this->input->post('id');
        $id = (!is_numeric($id)) ? 0 : $id;
        $info = $this->product_model->get_info($id);
        if (!$info)
        {
            exit();
        }

        //Kiem tra xem da binh chon hay chưa
        $raty = $this->session->userdata('session_raty');
        $raty = (!is_array($raty)) ? array() : $raty;
        $result = array();
        //Neu ton tai id san pham nay trong session danh gia
        if (isset($raty[$id]))
        {
            $result['msg'] = 'Bạn chỉ được đánh giá 1 lần cho sản phẩm';
            $output = @json_encode($result);
            echo $output;
            exit();
        }
        // Cập nhật trạng thái bình chọn
        $raty[$id] = true;
        $this->session->set_userdata('session_raty', $raty);

        $score = $this->input->post('score');
        $data = array();
        $data['rate_total'] = $info->rate_total + $score; // Tổng điểm
        $data['rate_count'] = $info->rate_count + 1 ;   // Tổng đánh giá

        // Cập nhật lại sp
        $this->product_model->update($id,$data);

        // Khai báo dữ liệu trả về

        $result['complete'] = true;
        $result['msg'] = 'Thanks for Reviews';
        $output = @json_encode($result); // Trả về json
        echo $output;
        exit();
    }

    function test_preg()
    {
        $day = '12/12/2018';
        $preg = '/^(0[1-9]|[12][0-9]|3[01])(\/)(0[1-9]|1[012])(\/)(19|20\d\d)%/';
        if(preg_match($preg,$day))
        {
            echo 'OK';
        }
    }

}
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 24/07/18
 * Time: 9:16 SA
 */