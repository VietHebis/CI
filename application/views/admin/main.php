<!DOCTYPE html>
<html>
<head>
	<title><?php echo $title; ?></title>
	<style>
*{ margin: 0px; padding: 0px;}
body{ width: 780px; margin: 0px auto;}
#top{ background: blue; margin-top:10px; color:white; height: 100px; line-height: 100px; font-weight: bold; text-align: center;}
#footer{ background: black; color:white; height: 30px; line-height: 30px; font-weight: bold; text-align: center;}
#content{ padding: 5px;}
</style>
</head>
<body>
	<div id="top">Welcome to Hebis.vn</div>
	<div id="content"><?php $this->load->view($subview)?></div>
	<div id="footer">2018 &copy; by Hebis.vn</div>

</body>
</html>