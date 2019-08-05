<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {font-family: Arial, Helvetica, sans-serif;}
        * {box-sizing: border-box;}

        input[type=text], select, textarea {
            width: 50%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            margin-top: 16px;
            margin-bottom: 16px;
            resize: vertical;
        }

        input[type=submit] {
            background-color: white ;
            color: #313A42;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type=submit]:hover {
            background-color: #45a049;
        }

        .container {
            border-radius: 5px;
            background-color: #f2f2f2;
            padding-top: 20px;
        }
    </style>
</head>
<body>


<br>
<br>

<div class="container">

    <form name="contact_form" id="contact_form" action="" method="post" enctype="multipart/form-data">

        <label for="email">Email</label>
        <textarea id="email" name="email" placeholder="Email Address" style="height:200px"></textarea>
        <div id="email_error" class="error"><?php echo form_error('email')?></div>

        <label for="attachment">Attachment</label>
        <input type="file" class="form-control-file" id="att" name="att[]" multiple>
        <div id="attachment_error" class="error"><?php echo form_error('attachment') ?></div>

        <label for="subject">Subject</label>
        <textarea id="subject" name="subject" placeholder="Write something.." style="height:200px"></textarea>
        <div id="subject_error" class="error"><?php echo form_error('subject')?></div>

        <input type="submit" value="Sentmail" name='submit' />

    </form>

</div>

</body>
</html>
