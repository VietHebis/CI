  <!DOCTYPE html>
<html>
<head>
	<title>Insert sinh vien</title>
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
	<input type="text" name="txtname" value="<?php echo set_value("txtname");?>">
	<?php echo form_error('txtname'); ?>
	<br/>
	<label>Email</label>
	<input type="text" name="txtemail" value="<?php echo set_value("txtemail");?>">
	<?php echo form_error('txtemail'); ?>
	<br/>
	<label>Địa Chỉ</label>
	<input type="text" name="txtadd" value="<?php echo set_value("txtadd");?>">
	<?php echo form_error('txtadd'); ?>
	<br/>
	<label>Số Điện Thoại</label>
	<input type="text" name="txtnum" value="<?php echo set_value("txtnum");?>">
	<?php echo form_error("txtnum"); ?>
	<br/>
	<label>&nbsp;</label>
	<input type="submit" name="ok" value="Them">
	
</form>
</body>
</html>