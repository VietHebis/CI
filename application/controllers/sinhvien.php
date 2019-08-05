<?php 
class sinhvien extends CI_Controller

{
	public function __construct()
{
	parent::__construct();
	$this->load->library('session');
}
	public function index()
	{
		$this->load->model("sinhvien_model");
		$data['sinhvien1'] = $this->sinhvien_model->listSinhvien();
		$this->load->view("sinhvien/list",$data);
	}
	public function insert()
	{	
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->library('form_validation');
		if($this->input->post("ok"))
		{
			$this->form_validation->set_rules("txtname","Tên Sinh Viên","required");
			$this->form_validation->set_rules('txtemail',"Email","required|valid_email");
			$this->form_validation->set_rules('txtadd',"Địa Chỉ","required");
			$this->form_validation->set_rules('txtnum',"Số Điện Thoại","required|numeric|max_length[11]|min_length[10]");

			$this->form_validation->set_message("required","%s không được bỏ trống");
			$this->form_validation->set_message("valid_email","%s Sai định dạng");
			$this->form_validation->set_message("numeric","%s phải là số");
			$this->form_validation->set_message("max_length","%s vượt quá giới hạn %d ký tự");
			$this->form_validation->set_message("min_length","%s không được dưới %d ký tự");
			$this->form_validation->set_error_delimiters('<span class="error">', '</span>');
			if($this->form_validation->run())
			{
			 $data = array('name' =>$this->input->post("txtname") ,
			 				'email' =>$this->input->post("txtemail") ,
			 				'address' =>$this->input->post("txtadd") ,
			 				'phone' =>$this->input->post("txtnum") ,
			  );
			$this->load->model("sinhvien_model");
			$this->sinhvien_model->insert($data);
			redirect('sinhvien');
			}
		}
		$this->load->view("sinhvien/insert");
	}

	public function delete()
	{	
		$this->load->helper('url');
		$id = $this->uri->segment(3);
		$this->load->model("sinhvien_model");
		$data['xoa'] = $this->sinhvien_model->delete($id);
		$this->session->set_flashdata('flash_mess','Delete Success !'.$id.$xoa['name']);
		redirect('sinhvien');exit;
	}
	public function update()
	{
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->library('form_validation');
		$id = $this->uri->segment(3);
		$this->load->model("sinhvien_model");
		$data['sinhvien'] = $this->sinhvien_model->getsinhvien($id);
		if ($this->input->post("ok"))
		{
			$this->form_validation->set_rules("txtname","Tên Sinh Viên","required");
			$this->form_validation->set_rules('txtemail',"Email","required|valid_email");
			$this->form_validation->set_rules('txtadd',"Địa Chỉ","required");
			$this->form_validation->set_rules('txtnum',"Số Điện Thoại","required|numeric|max_length[11]|min_length[10]");

			$this->form_validation->set_message("required","%s không được bỏ trống");
			$this->form_validation->set_message("valid_email","%s Sai định dạng");
			$this->form_validation->set_message("numeric","%s phải là số");
			$this->form_validation->set_message("max_length","%s vượt quá giới hạn %d ký tự");
			$this->form_validation->set_message("min_length","%s không được dưới %d ký tự");
			$this->form_validation->set_error_delimiters('<span class="error">', '</span>');
			if($this->form_validation->run())
			{
			 $dataupdate = array('name' =>$this->input->post("txtname") ,
			 				'email' =>$this->input->post("txtemail") ,
			 				'address' =>$this->input->post("txtadd") ,
			 				'phone' =>$this->input->post("txtnum") ,
			  );
			 $this->sinhvien_model->update($id,$dataupdate);
			 redirect('sinhvien');
			}
		}
		$this->load->view("sinhvien/update",$data);
	}
}



 ?>
