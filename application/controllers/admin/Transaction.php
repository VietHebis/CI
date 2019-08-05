<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 22/06/18
 * Time: 9:43 SA
 */
defined('BASEPATH') OR exit('No direct script access allowed');
use Box\Spout\Reader\ReaderFactory;
use Box\Spout\Writer\WriterFactory;
use Box\Spout\Writer\Style\StyleBuilder;
use Box\Spout\Writer\Style\Color;
use Box\Spout\Writer\Style\Border;
use Box\Spout\Writer\Style\BorderBuilder;
use Box\Spout\Common\Type;

class Transaction extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('transaction_model');
        $this->load->model('door_loging_model');
        $this->load->model('admin_sentmail_model');
    }

    /*
     * Hiển thị danh sach sản phẩm
     */
    function index()
    {
        //Load lib phân trang
        $this->load->library('pagination');
        $total_rows = $this->transaction_model->get_total();
        $this->data['total_rows'] = $total_rows;
        $config = array();
        $config['total_rows'] = $total_rows; //tổng tất cả sản phẩm trên website
        $config['base_url'] = admin_url('transaction/index'); //Vị trí trang cần phân trang
        $config['per_page'] = 5; //Số lượng sp cần hiển thị trên 1 trang
        $config['uri_segment'] = 4; //Phân đoạn hiển thị ra số trang trên url
        $config['next_link'] = 'Trang kế';
        $config['prev_link'] = 'Trang trước';
        //Khỏi tạo các cấu hình phân trang
        $this->pagination->initialize($config);

        $segment = $this->uri->segment(4);
        $segment = intval($segment);

        $input = array();
        $input['limit'] = array($config['per_page'], $segment);

        //Kiểm tra xem có lọc hay không
        $id = $this->input->get('id');
        $status = $this->input->get('status');
        $payment = $this->input->get('payment');
        $created = $this->input->get('created');
        $created_to = $this->input->get('created_to');
        $id = intval($id);
        $input['where'] = array();


        if ($id > 0) {
            $input['where']['id'] = $id;
        }

        if ($status)
        {
            $input['where'] = array('status' => $status);
        }

        if (!empty($payment))
        {
            $input['where'] = array('payment' => $payment);
        }
        if (!empty($payment) && $status >= 0)
        {
            $input['where'] = array('payment' => $payment,
                                     'status' => $status);
        }
        if ($created && $created_to)
        {
            $input['where'] = array('created >=' => $created, 'created <=' => $created_to);
        }
       if (!empty($payment) && $status >= 0 && $created && $created_to)
        {
            $input['where'] = array('created >=' => $created, 'created <=' => $created_to,
                                       'payment' => $payment, 'status' => $status);
        }


        //Lấy danh sách sản phẩm
        $list = $this->transaction_model->get_list($input);

        $this->data['list'] = $list;

        // In câu thông báo
        $message = $this->session->flashdata('message');
        $this->data['message'] = $message;

        //Load View
        $this->data['temp'] = 'admin/transaction/index';
        $this->load->view('admin/home', $this->data);
    }

    function delete()
    {
        $id = $this->uri->rsegment(3);
        $info = $this->transaction_model->get_info($id);
        if (!$info)
        {
            $this->session->set_flashdata('message','Không tồn tại giao dịch !');
            redirect(admin_url('transaction'));
        }

        if($this->transaction_model->delete($id))
        {

            $this->session->set_flashdata('message','Xóa thành công '.$info->name);
            redirect(admin_url('transaction'));
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
        $info = $this->transaction_model->get_info($id);
        if (!$info)
        {
            $this->session->set_flashdata('message','Không tồn tại !');
            redirect(admin_url('transaction'));
        }

        $this->transaction_model->delete($id);

    }

    function report()
    {

        $re = [];
        $data = array();
        if ($this->input->post()) {

            //echo $_FILES['file_ex']['tmp_name'];die;
            //dump($_FILES);die;

            $this->load->library('upload_library');
            $upload_path = './upload/report';
            $upload_data = $this->upload_library->upload($upload_path, 'file_ex');
            if (!empty($upload_data)) {
                require_once FCPATH . 'assets/spout-2.7.3/src/Spout/Autoloader/autoload.php';
                $filePath = $_FILES['file_ex']['tmp_name'];
                //dump($filePath);exit();
                $reader = ReaderFactory::create(Type::XLSX); // for XLSX files
//$reader = ReaderFactory::create(Type::CSV); // for CSV files
//$reader = ReaderFactory::create(Type::ODS); // for ODS files
                $reader->setShouldFormatDates(true);
                $reader->open($filePath);

                $ignore_id = 0;
                foreach ($reader->getSheetIterator() as $sheet) {
                    foreach ($sheet->getRowIterator() as $v => $row) {
                        if($ignore_id ++ < 3){
                            continue;
                        }
                            //$re[]=$row;
                        $date = date('Y-m-d',strtotime($row[4]));
                           $data = array(
                                'name' => $row['2'],
                                'room' => $row['3'],
                                'date' => $date,
                               'cmnd' => $row['1'],
                               'in' => $row['6'],
                               'out' => $row['7']
                            );
                          $this->door_loging_model->create($data);
                       // echo'<pre>'.($row[3]).','.$row[4].'</pre>';
                        //dump($row[4]);
                    }
                }
                $reader->close();
            }
            else{
                $this->session->set_flashdata('message','Vui lòng chọn file !');
            }
            $this->session->set_flashdata('message','Xong !');
        }

        $message = $this->session->flashdata('message');
        $this->data['message'] = $message;
        //$this->data['re'] = $re;
        $this->data['temp'] = 'admin/transaction/upload';
        $this->load->view('admin/home', $this->data);
    }

    /*
     * Gui mail admin
     */
    function admin_sentmail(){
        $this->load->helper(array('form', 'url'));
        $subject = $this->input->post('subject');
        $email = $this->input->post("email");
        $arr_email = explode("\n",$email);
        if ($this->input->post()) {
            $file = $_FILES['att'];
            $count = count($file['name']);
            $i = 0;
            if ($count>0):
            while ($i<= $count-1):
                $email_sent = $arr_email[$i];
                $file_name = $file['name'][$i];
                $attachment = $file['tmp_name'][$i];
                if (!$this->_send_mail( $email_sent, $attachment, $subject, $file_name)) {
                    echo $this->email->print_debugger();
                };
                $i++;
                echo 'Done';
            endwhile;
            else: return false;
            endif;
        }
        $this->data['temp'] = 'admin/transaction/admin_sentmail';
        $this->load->view('admin/home',$this->data);
    }

    /*
     * Private Sent Mail
     */

    private function _send_mail($email = '',$attachment = '',$subject = '',$file_name = '')
    {
        $this->load->library('email');
        $config = array(

            'protocol' => 'smtp',
            'smtp_host' => 'smtp.gmail.com',
            'smtp_port' => 587,
            'smtp_crypto' => 'tls',
            'smtp_user' => 'viet.tranquoc@digitel.com.vn',
            'smtp_pass' => '0906570205',
            'charset' => 'utf-8',
            'mailtype' => 'text',
            'newline' => "\r\n",);
        $this->email->initialize($config);
        $this->email->from('viet.tranquoc@digitel.com.vn', 'Support');
        $this->email->to($email);
        $this->email->reply_to('viet.tranquoc@digitel.com.vn','Viet Tran');
        $this->email->attach($attachment,'attachment', $file_name);
        $this->email->subject('Support');
        $this->email->message($subject);
        $this->email->send();

    }



    function test()
    {
$this->load->library('Excel');
$data = [
    ['Nguyễn Khánh Linh', 'Nữ', '500k'],
    ['Ngọc Trinh', 'Nữ', '700k'],
    ['Tùng Sơn', 'Không xác định', 'Miễn phí'],
    ['Kenny Sang', 'Không xác định', 'Miễn phí']
];
//Khởi tạo đối tượng
$excel = new PHPExcel();
//Chọn trang cần ghi (là số từ 0->n)
$excel->setActiveSheetIndex(0);
//Tạo tiêu đề cho trang. (có thể không cần)
$excel->getActiveSheet()->setTitle('demo ghi dữ liệu');

//Xét chiều rộng cho từng, nếu muốn set height thì dùng setRowHeight()
$excel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
$excel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
$excel->getActiveSheet()->getColumnDimension('C')->setWidth(30);

//Xét in đậm cho khoảng cột
$excel->getActiveSheet()->getStyle('A1:C1')->getFont()->setBold(true);
//Tạo tiêu đề cho từng cột
//Vị trí có dạng như sau:
/**
 * |A1|B1|C1|..|n1|
 * |A2|B2|C2|..|n1|
 * |..|..|..|..|..|
 * |An|Bn|Cn|..|nn|
 */
$excel->getActiveSheet()->setCellValue('A1', 'Tên');
$excel->getActiveSheet()->setCellValue('B1', 'Giới Tính');
$excel->getActiveSheet()->setCellValue('C1', 'Đơn giá(/shoot)');
// thực hiện thêm dữ liệu vào từng ô bằng vòng lặp
// dòng bắt đầu = 2
$numRow = 2;
foreach ($data as $row) {
    $excel->getActiveSheet()->setCellValue('A' . $numRow, $row[0]);
    $excel->getActiveSheet()->setCellValue('B' . $numRow, $row[1]);
    $excel->getActiveSheet()->setCellValue('C' . $numRow, $row[2]);
    $numRow++;
}
// Khởi tạo đối tượng PHPExcel_IOFactory để thực hiện ghi file
// ở đây mình lưu file dưới dạng excel2007
PHPExcel_IOFactory::createWriter($excel, 'Excel2007')->save('data.xlsx');

header('Content-type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename="data.xls"');
PHPExcel_IOFactory::createWriter($excel, 'Excel2007')->save('php://output');

    }
    function export()
    {
        require_once FCPATH . 'assets/spout-2.7.3/src/Spout/Autoloader/autoload.php';
        $headerRow = array('Id1','id2','id3','id4','name','mail','phone','price','place','id5','id6','id7','id8');
        $sql = "SELECT * FROM `transaction` WHERE user_name = 'Viet Tran'";
        $data = $this->db->query($sql)->result();
        //$data = $this->transaction_model->get_list($input['where'] = array('user_name' => 'Viet Tran'));
        if($data){
            foreach ($data as &$d){
                $d = get_object_vars($d);
               // $d = get_defined_vars($d);
            }

        }
        $writer = WriterFactory::create(Type::XLSX);
        $border = (new BorderBuilder())
            ->setBorderBottom(Color::GREEN, Border::WIDTH_THIN, Border::STYLE_DASHED)
            ->setBorderLeft(Color::GREEN, Border::WIDTH_THIN, Border::STYLE_DASHED)
            ->setBorderRight(Color::GREEN, Border::WIDTH_THIN, Border::STYLE_DASHED)
            ->setBorderTop(Color::GREEN, Border::WIDTH_THIN, Border::STYLE_DASHED)
            ->build();
        $style = (new StyleBuilder())
            ->setBorder($border)
            ->setFontBold()
            ->setFontSize(15)
            ->setFontColor(Color::BLUE)
            ->setShouldWrapText()
            ->setBackgroundColor(Color::GREEN)
            ->build();
        $filePath = FCPATH.'/assets/excel/test01.xlsx';
        $writer->setTempFolder('/Applications/XAMPP/htdocs/code/CI/tmp');
        $writer->openToFile($filePath);
        $writer->addRow($headerRow);
        $writer->addRowsWithStyle($data,$style); // add multiple rows at a time
        $writer->close();


        $file = FCPATH.'/assets/excel/test01.xlsx';
        if (file_exists($file)) {
            $path = date('Ymd') . '.xlsx';
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="'.$path.'"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            readfile($file);
            exit;
        }

//        $filename = date(Yhi);
//        header("Content-Type: application/vnd.ms-excel");
//        header("Content-Disposition: attachment; filename=$filename.xlsx");

//        $path = date('Ymd') . '.xlsx';
//        header('Content-Type: application/vnd.ms-excel'); //mime type
//        header('Content-Disposition: attachment;filename="' . $path . '"'); //tell browser what's the file name
//        header("Pragma: no-cache");
//        header("Expires: 0");

//        header('Cache-Control: max-age=0'); //no cache
//if you want to save it as .XLSX Excel 2007 format
//        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
//force user to download the Excel file without writing it to server's HD

//        header('location: ' . base_url());
    }
}