<meta charset="utf-8">
<h3>Danh Sách Sinh Viên</h3>
<h5><a href="sinhvien/insert">Thêm Sinh Viên</a></h5>
<?php 
if(isset($sinhvien1) && $sinhvien1 != null);?>
<?php echo $this->session->flashdata('flash_mess'); ?>
<table width='500' border='1'>
 <tr>
 <td> Tên Sinh Viên </td>
 <td> Sửa </td>
 <td> Xóa </td>
 </tr>
 <?php
 foreach ($sinhvien1 as $list ) {
 	?>
 <tr>
 <td><?php echo $list['name']?></td>
 <td><a href="sinhvien/update/<?php echo $list['id'];?>"> Sửa </a> </td>
 <td><a href="sinhvien/delete/<?php echo $list['id'];?>"> Xóa </a> </td>
 </tr>
 <?php } ?>
 </table>

 
