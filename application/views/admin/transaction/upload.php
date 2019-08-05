<br>
<br>
<br>
<br>
<form class="form" id="form" action="" method="post" enctype="multipart/form-data">

        <div class="form-group">
            <label for="exampleFormControlFile1">Upload Excel</label>
            <input type="file" class="form-control-file" id="file_ex" name="file_ex">
        </div>
    <br />
    <input type="submit" class="button" value="Upload" name='submit' />

</form>
<br>
<?php $this->load->view('admin/notify');?>
<h1>Dữ liệu đã tải lên:</h1>
<?php if (isset($re)):?>
<div>
    <?php dump($re); ?>
</div>
<?php endif;?>