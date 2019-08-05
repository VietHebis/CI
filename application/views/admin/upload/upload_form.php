<!DOCTYPE html>
<html>
<head>
	<title>Upload Form</title>
</head>
<body>
<?php echo $error; ?>
<?php echo form_open_multipart("upload_data/do_upload"); ?>
<input type="file" name="userfile" size="20" multiple />
<br /><br />
<input type="submit" name="upload" />
</form>
</body>
</html>