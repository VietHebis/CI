<?php
/**
* 
*/
class San_pham extends CI_Controller
{
	
	public function __construct()
	{
		parent ::__construct();
	}
	public function index()
	{
		echo 'day la phuong thuc index';
	}
	public function them()
	{
		$this->load->model('sanpham/m_sanpham','abc');
		$danhsach=$this->abc->getSanPham();
		echo $danhsach;
		echo 'day la phuong thuc them';
	}
	public function xoa($id)
	{
		echo 'day la phuong thuc xoa'. $id;
	}
	public function capnhat($id)
	{
		echo 'day la phuong thuc them'. $id;
	}
	
}
?>