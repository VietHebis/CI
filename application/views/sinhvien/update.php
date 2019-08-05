<!DOCTYPE html>
<html>
<head>
	<title>Update sinh vien</title>
	<meta charset="utf-8">
	<style type="text/css">
		label {
			float: left;
			width: 120px;
		}
		.error{
			color:red;
		}
	</style>
</head>
<body>
<form action="" method="post">
	<label>Tên Sinh Viên</label>
	<input type="text" name="txtname" value="<?php echo $sinhvien['name'];?>">
	
	<br/>
	<label>Email</label>
	<input type="text" name="txtemail" value="<?php echo $sinhvien['email'];?>">
	
	<br/>
	<label>Địa Chỉ</label>
	<input type="text" name="txtadd" value="<?php echo $sinhvien['address'];?>">
	
	<br/>
	<label>Số Điện Thoại</label>
	<input type="text" name="txtnum" value="<?php echo $sinhvien['phone'];?>">
	
	<br/>
	<label>&nbsp;</label>
	<input type="submit" name="ok" value="Sửa">
	
</form>
</body>
</html>