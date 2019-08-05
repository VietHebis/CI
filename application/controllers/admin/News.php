<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 22/06/18
 * Time: 9:43 SA
 */
defined('BASEPATH') OR exit('No direct script access allowed');
class News extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('news_model');
    }
    /*
     * Hiển thị danh sach sản phẩm
     */
    function index()
    {
        //Load lib phân trang
        $this->load->library('pagination');
        $total_rows = $this->news_model->get_total();
        $this->data['total_rows'] = $total_rows;
        $config = array();
        $config['total_rows'] = $total_rows; //tổng tất cả sản phẩm trên website
        $config['base_url'] = admin_url('news/index'); //Vị trí trang cần phân trang
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
        $list = $this->news_model->get_list($input);
        $this->data['list'] = $list;


        // In câu thông báo
        $message = $this->session->flashdata('message');
        $this->data['message'] = $message;

        //Load View
        $this->data['temp'] = 'admin/news/index';
        $this->load->view('admin/home',$this->data);
    }
    /*
     * Thêm mới news vào db
     */

    function add()
    {

        //Validation

        $this->load->library('form_validation');
        $this->load->helper(array('url','form'));
        if ($this->input->post())
        {
            $this->form_validation->set_rules('title','Tên bài viết','required');
            $this->form_validation->set_rules('content','Nội dung bài viết','required');


            if ($this->form_validation->run())
            {
                $title = $this->input->post('title');
                $meta_desc = $this->input->post('meta_desc');
                $meta_key = $this->input->post('meta_key');
                $content = $this->input->post('content');

                // Lấy tên file ảnh minh họa
                $this->load->library('upload_library');
                $upload_path = './upload/news';
                $upload_data = $this->upload_library->upload($upload_path,'image');
                $image_link = '';
                if (isset($upload_data))
                {
                    $image_link = $upload_data['file_name'];
                }


                $data = array(
                    'title'      => $title,
                    'image_link' => $image_link,
                    'meta_desc'  => $meta_desc,
                    'meta_key'   => $meta_key,
                    'content'    => $content,
                    'created'    => now(),
                );




                if ($this->news_model->create($data)){
                    //Tạo nd thông báo
                    $this->session->set_flashdata('message','Thêm thành công');
                }
                else{
                    $this->session->set_flashdata('message','Thêm không thành công');
                }
                // Chuyển đén trang news
                redirect(admin_url('news'));
            }

        }

        //Load View
        $this->data['temp'] = 'admin/news/add';
        $this->load->view('admin/home',$this->data);
    }

    function edit()
    {
        $id = $this->uri->segment('4');
        $id = intval($id);
        $info_news = $this->news_model->get_info($id);
        if (!$info_news)
        {
            $this->session->set_flashdata('message', 'Sản phẩm không tồn tại !');
            redirect(admin_url('news'));
        }
        $this->data['info_news'] = $info_news ;

        $this->load->library('form_validation');
        $this->load->helper(array('url','form'));
        if ($this->input->post())
        {
            $this->form_validation->set_rules('title','Tiêu đề','required');
            $this->form_validation->set_rules('content','Nội dung','required');



            if ($this->form_validation->run())
            {
                $title = $this->input->post('title');
                $content = $this->input->post('content');


                // Lấy tên file ảnh minh họa
                $this->load->library('upload_library');
                $upload_path = './upload/news';
                $upload_data = $this->upload_library->upload($upload_path,'image');
                $image_link = '';
                if (isset($upload_data))
                {
                    $image_link = $upload_data['file_name'];
                }


                $data = array(
                    'title'      => $title,
                    'content'    => $content,
                    'meta_desc'  => $this->input->post('meta_desc'),
                    'meta_key'   => $this->input->post('meta_key'),
                );

                if (!empty($image_link))
                {
                    $data['image_link'] = $image_link;
                }

                if ($this->news_model->update($id,$data)){
                    //Tạo nd thông báo
                    $this->session->set_flashdata('message','Cập nhật thành công');
                }
                else{
                    $this->session->set_flashdata('message','Cập nhật thất bại');
                }
                // Chuyển đén trang adnmin
                redirect(admin_url('news'));
            }

        }
        //Load View
        $this->data['temp'] = 'admin/news/edit';
        $this->load->view('admin/home',$this->data);


    }

    function delete()
    {
        $id = $this->uri->rsegment(3);
        $info = $this->news_model->get_info($id);
        if (!$info)
        {
            $this->session->set_flashdata('message','Không tồn tại bài viết !');
            redirect(admin_url('news'));
        }
        $image_link = './upload/news/'.$info->image_link;
      
        if($this->news_model->delete($id))
        {
            // Xóa ảnh sản phẩm
            if (file_exists($image_link))
            {
                unlink($image_link);
            }

            $this->session->set_flashdata('message','Xóa thành công '.$info->name);
            redirect(admin_url('news'));
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
        $info = $this->news_model->get_info($id);
        if (!$info)
        {
            $this->session->set_flashdata('message','Không tồn tại sản phẩm !');
            redirect(admin_url('news'));
        }
        $image_link = './upload/news/'.$info->image_link;

        if($this->news_model->delete($id))
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
