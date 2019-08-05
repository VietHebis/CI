<?php
$user=array(
    "name" => "username",
    "size" => "25",
);
$pass=array(
    "name" => "pass",
    "size" => "25",
);
$email=array(
    "name" => "email",
    "size" => "25",
);
$gender1=array(
    "name" => "gender",
    "value" => "m",
    "checked" => TRUE,
);
$gender2=array(
    "name" => "gender",
    "value" => "f",
);
$opt=array(
    "1" => "Viet Nam",
    "2" => "Cambodia",
    "3" => "Malaysia",
);
$note=array(
    "name" => "note",
    "cols" => "40",
    "rows" => "5",
);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>freetuts.net</title>
<style type="text/css">
    .error{
        color: red;
    }
</style>
</head>
   
<body>
 <?php
    echo form_open(base_url()."form/index");
    echo form_fieldset("Member Register"); 
    echo form_label("Fullname: ").form_input($user)."<br />";
    echo form_label("Password: ").form_password($pass)."<br />";
    echo form_label("Email: ").form_input($email)."<br />";
    echo form_label("Gender: ").form_radio($gender1)."Male".form_radio($gender2)."Female<br />";
    echo form_label("Country: ").form_dropdown("Country: ", $opt, 1)."<br />";
    echo form_label("Note: ").form_textarea($note)."<br />";
    echo form_label(" ").form_submit("ok",  "Register");
    echo form_fieldset_close();
    echo form_close();
 ?>
</body>
</html>