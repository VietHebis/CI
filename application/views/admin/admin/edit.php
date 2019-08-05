<!--head-->
<?php $this->load->view('admin/admin/head')?>
<div class='line'></div>

<div class="wrapper">
    <div class="widget">
        <div class="title">
            <h6>Chỉnh Sửa Admin</h6>
        </div>
        <form class="form" id="form" action="" method="post" enctype="multipart/form-data">
            <fieldset>
                <div class="formRow">
                    <label class="formLeft" for="param_name">Tên:<span class="req">*</span></label>
                    <div class="formRight">
                        <span class="oneTwo"><input name="name" id="param_name" _autocheck="true" type="text" value="<?php echo $info->name?>"></span>
                        <span name="name_autocheck" class="autocheck"></span>
                        <div name="name_error" class="clear error"><?php echo form_error('name');?> </div>
                    </div>
                    <div class="clear"></div>
                </div>

                <div class="formRow">
                    <label class="formLeft" for="param_username">Username:<span class="req">*</span></label>
                    <div class="formRight">
                        <span class="oneTwo"><input name="username" id="param_username" _autocheck="true" type="text" value="<?php echo $info->username?>" disabled></span>
                        <span name="name_autocheck" class="autocheck"></span>
                        <div name="name_error" class="clear error"> <?php echo form_error('username');?></div>
                    </div>
                    <div class="clear"></div>
                </div>

                <div class="formRow">
                    <label class="formLeft" for="param_password">Password:<span class="req">*</span></label>
                    <div class="formRight">
                        <span class="oneTwo"><input name="password" id="param_password" _autocheck="true" type="password" >
                        <p style="color: red">Để nguyên sẽ không thay đổi mật khâu</p>
                            </span>
                        <span name="name_autocheck" class="autocheck"></span>
                        <div name="name_error" class="clear error"> <?php echo form_error('password');?></div>
                    </div>
                    <div class="clear"></div>
                </div>

                <div class="formRow">
                    <label class="formLeft" for="param_repassword">Re-Password:<span class="req">*</span></label>
                    <div class="formRight">
                        <span class="oneTwo"><input name="repassword" id="param_repassword" _autocheck="true" type="password"></span>
                        <span name="name_autocheck" class="autocheck"></span>
                        <div name="name_error" class="clear error"> <?php echo form_error('repassword');?></div>
                    </div>
                    <div class="clear"></div>
                </div>

                <div class="formSubmit">
                    <input type="submit" value="Cập Nhật" class="redB">
                    <input type="reset" value="Hủy bỏ" class="basic">
                </div>
            </fieldset>
        </form>
    </div>
</div>

