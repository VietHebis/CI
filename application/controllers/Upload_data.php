<?php
 defined('BASEPATH') OR exit('No direct script access allowed');
 
 class Upload_data extends CI_Controller {
 
 public function __construct()
 {
 	parent::__construct();
 	$this->load->helper(array('form', 'url'));
 }
 	public function index()
 	{
 		$this->load->view('upload/upload_form', array('error' => '' ));
 	}
 	public function do_upload()
 	{
 		$config['upload_path'] 		= FCPATH.'/assets/dataupload';
 		$config['allowed_types'] 	= 'gif|jpg|png';
 		$config['max_size']  		= '1000';
 		$config['max_width']  		= '1920';
 		$config['max_height']  		= '1200';
 		

 		$this->load->library('upload', $config);
 		
 		if ( ! $this->upload->do_upload('userfile')){
 			$error = array('error' => $this->upload->display_errors());
 			$this->load->view('upload/upload_form', $error);
 		}
 		else{
 			$data = array('upload_data' => $this->upload->data());
 			$this->load->view('upload/upload_success', $data);
 			$this->load->library('image_lib');
 			$img_info = $this->upload->data();
 			$config['image_library'] = 'gd2';
                    $config['source_image'] = FCPATH.'/assets/dataupload/'.$img_info['file_name'];
                    $config['create_thumb'] = TRUE;
                    $config['maintain_ratio'] = TRUE;
                    $config['width']     = 400;
                    $config['height']   = 300;
                    $this->image_lib->initialize($config);
                    $this->image_lib->resize();
                    $this->image_lib->clear();
                    unset($config);

                    $config['source_image'] = FCPATH.'/assets/dataupload/'.$img_info['file_name'];
                    $config['create_thumb'] = FALSE;
					$config['wm_text'] = 'Copyright 2018 - hebis.vn';
					$config['wm_type'] = 'text';
					$config['wm_font_path'] = './system/fonts/texb.ttf';
					$config['wm_font_size'] = '16';
					$config['wm_font_color'] = 'ffff00';
					$config['wm_vrt_alignment'] = 'bottom';
					$config['wm_hor_alignment'] = 'center';
					$config['wm_padding'] = '0';

$this->image_lib->initialize($config);

$this->image_lib->watermark();

 		}
 	}
 
 }
 
 /* End of file Upload.php */
 /* Location: ./application/controllers/Upload.php */ ?>