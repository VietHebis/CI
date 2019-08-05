<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 22/06/18
 * Time: 9:43 SA
 */
defined('BASEPATH') OR exit('No direct script access allowed');
class Slide extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('slide_model');
    }
    /*
     * Hiển thị danh sach sản phẩm
     */
    function index()
    {
        //Load lib phân trang
        $this->load->library('pagination');
        $total_rows = $this->slide_model->get_total();
        $this->data['total_rows'] = $total_rows;
        $config = array();
        $config['total_rows'] = $total_rows; //tổng tất cả sản phẩm trên website
        $config['base_url'] = admin_url('slide/index'); //Vị trí trang cần phân trang
        $config['per_page'] = 5; //Số lượng sp cần hiển thị trên 1 trang
        $config['uri_segment'] = 4; //Phân đoạn hiển thị ra số trang trên url
        $config['next_link'] = 'Trang kế';
        $config['prev_link'] = 'Trang trước';
        //Khỏi tạo các cấu hình phân trang
        $this->pagination->initialize($config);

        $segment = $this->uri->segment(4);
        $segment = intval($segment);

        $input = array();
        $input['limit'] = array($config['per_page'],$segment);

        //Kiểm tra xem có lọc hay không
        $id = $this->input->get('id');
        $id = intval($id);
        $input['where'] = array();
        if ($id > 0)
        {
            $input['where']['id'] = $id;
        }

        $title = $this->input->get('title');
        if ($title)
        {
            $input['like'] = array('title', $title);
        }



        //Lấy danh sách sản phẩm
        $list = $this->slide_model->get_list($input);
        $this->data['list'] = $list;


        // In câu thông báo
        $message = $this->session->flashdata('message');
        $this->data['message'] = $message;

        //Load View
        $this->data['temp'] = 'admin/slide/index';
        $this->load->view('admin/home',$this->data);
    }
    /*
     * Thêm mới slide vào db
     */

    function add()
    {

        //Validation

        $this->load->library('form_validation');
        $this->load->helper(array('url','form'));
        if ($this->input->post())
        {
            $this->form_validation->set_rules('name','Tên bài viết','required');
            $this->form_validation->set_rules('sort_order','Thứ tự','required');


            if ($this->form_validation->run())
            {
                $name = $this->input->post('name');
                $sort_order = $this->input->post('sort_order');
                $link = $this->input->post('link');
                $image_name = $this->input->post('image_name');

                // Lấy tên file ảnh minh họa
                $this->load->library('upload_library');
                $upload_path = './upload/slide';
                $upload_data = $this->upload_library->upload($upload_path,'image');
                $image_link = '';
                if (isset($upload_data))
                {
                    $image_link = $upload_data['file_name'];
                }


                $data = array(
                    'name'       => $name,
                    'image_link' => $image_link,
                    'link'       => $link,
                    'image_name' => $image_name,
                    'sort_order' => $sort_order,
                );




                if ($this->slide_model->create($data)){
                    //Tạo nd thông báo
                    $this->session->set_flashdata('message','Thêm thành công');
                }
                else{
                    $this->session->set_flashdata('message','Thêm không thành công');
                }
                // Chuyển đén trang slide
                redirect(admin_url('slide'));
            }

        }

        //Load View
        $this->data['temp'] = 'admin/slide/add';
        $this->load->view('admin/home',$this->data);
    }

    function edit()
    {
        $id = $this->uri->rsegment('3');
        $id = intval($id);
        $info = $this->slide_model->get_info($id);
        if (!$info)
        {
            $this->session->set_flashdata('message', 'Sản phẩm không tồn tại !');
            redirect(admin_url('slide'));
        }
        $this->data['info'] = $info ;

        //Validation

        $this->load->library('form_validation');
        $this->load->helper(array('url','form'));
        if ($this->input->post())
        {
            $this->form_validation->set_rules('name','Tên bài viết','required');
            $this->form_validation->set_rules('sort_order','Thứ tự','required');


            if ($this->form_validation->run())
            {
                $name = $this->input->post('name');
                $sort_order = $this->input->post('sort_order');
                $link = $this->input->post('link');
                $image_name = $this->input->post('image_name');

                // Lấy tên file ảnh minh họa
                $this->load->library('upload_library');
                $upload_path = './upload/slide';
                $upload_data = $this->upload_library->upload($upload_path,'image');
                $image_link = '';
                if (!empty($upload_data))
                {
                    $image_link = $upload_data['file_name'];
                }


                $data = array(
                    'name'       => $name,
                    'image_link' => $image_link,
                    'link'       => $link,
                    'image_name' => $image_name,
                    'sort_order' => $sort_order,
                );


                if (!empty($image_link))
                {
                    $data['image_link'] = $image_link;
                }

                if ($this->slide_model->update($id,$data)){
                    //Tạo nd thông báo
                    $this->session->set_flashdata('message','Cập nhật thành công');
                }
                else{
                    $this->session->set_flashdata('message','Cập nhật thất bại');
                }
                // Chuyển đén trang adnmin
                redirect(admin_url('slide'));
            }

        }
        //Load View
        $this->data['temp'] = 'admin/slide/edit';
        $this->load->view('admin/home',$this->data);


    }

    function delete()
    {
        $id = $this->uri->rsegment(3);
        $info = $this->slide_model->get_info($id);
        if (!$info)
        {
            $this->session->set_flashdata('message','Không tồn tại bài viết !');
            redirect(admin_url('slide'));
        }
        $image_link = './upload/slide/'.$info->image_link;

        if($this->slide_model->delete($id))
        {
            // Xóa ảnh sản phẩm
            if (file_exists($image_link))
            {
                unlink($image_link);
            }

            $this->session->set_flashdata('message','Xóa thành công '.$info->name);
            redirect(admin_url('slide'));
        }

    }

    //Xóa nhiều
    function dell_all()
    {
        $ids = $this->input->post('ids');
        foreach ($ids as $id)
        {
            $this->_del($id);
        }
    }

    private function _del($id)
    {
        $info = $this->slide_model->get_info($id);
        if (!$info)
        {
            $this->session->set_flashdata('message','Không tồn tại sản phẩm !');
            redirect(admin_url('slide'));
        }
        $image_link = './upload/slide/'.$info->image_link;

        if($this->slide_model->delete($id))
        {
            // Xóa ảnh sản phẩm
            if (file_exists($image_link))
            {
                unlink($image_link);
            }

        }
    }


    function test()
    {
        /*
        // a..z là gồm các từ từ a => z
        echo (addcslashes('freetuts.net FREETUTS.NET', 'a..zA..Z'));
        echo '<br>';
        $abc = 'nay nguoi anh yeu hoi';
        $abc = addcslashes($abc,'a');
        echo $abc;
        echo '<br>';
        $co = '&spades;';
        echo '1'.$co;

        $cars=array("Volvo","BMW","Toyota","Honda","Mercedes","Opel");
        pre(array_chunk($cars,4));

        echo '<br>';
        */

        $card=array();
        $sym=array("<b style='color: black'>&spades;</b>","<b style='color: black'>&clubs;</b>","<b style='color: red'>&hearts;</b>","<b style='color: red'>&diams;</b>");
        $num=array("1","2","3","4","5","6","7","8","9","10","J","Q","K");
        foreach ($num as $n) {
            foreach ($sym as $s) {
                $card[] = $n . $s;
            }
        }
        $card_before = $card;
        for ($x = 0; $x <= 10; $x++) {
            $random_keys = array_rand($card, 3);
            echo $card[$random_keys[0]] . '<br>';
            echo $card[$random_keys[1]] . '<br>';
            echo $card[$random_keys[2]] . '<br>';
            foreach ($random_keys as $k) {
                unset($card[$k]);
            }
            echo '<br>';
        }



    }
    function test2()
    {
        $pattern = '/\W/';
        $subject = 'Ahihi đây là đâu !';
        if (preg_match($pattern, $subject, $matches)){
            echo 'Đây là một dãy có ký tự đb';
        }
    }

}
