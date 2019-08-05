<?php
    /**
     * Created by PhpStorm.
     * User: Admin
     * Date: 28/06/18
     * Time: 3:24 CH
     */

    Class Upload extends MY_Controller
    {
        function index()
        {
            if($this->input->post('submit'))
            {
                $this->load->library('upload_library');
                $upload_path = './upload/user';
                $data = $this->upload_library->upload($upload_path, 'image');
                pre($data);
            }
           $this->data['temp'] = 'admin/upload/index';
           $this->load->view('admin/home',$this->data);
        }

        function upload_file()
        {
            if($this->input->post('submit'))
            {
                $this->load->library('upload_library');
                $upload_path = './upload/user';
                $data = $this->upload_library->upload_multiple($upload_path, 'image_list');
                pre($data);
            }
            $this->data['temp'] = 'admin/upload/upload_file';
            $this->load->view('admin/home',$this->data);
        }
    }