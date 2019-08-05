<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 25/06/18
 * Time: 2:15 CH
 */
$this->load->view('admin/slide/head',$this->data);?>
<div class="line"></div>
<form class="form" id="form" action="" method="post" enctype="multipart/form-data">
    <fieldset>
        <div class="widget">
            <div class="title">
                <img src="<?php echo public_url('admin')?>/images/icons/dark/add.png" class="titleIcon">
                <h6>Thêm mới Slide</h6>
            </div>

            <ul class="tabs">
                <li><a href="#tab1">Thông tin chung</a></li>

            </ul>

            <div class="tab_container">
                <div id="tab1" class="tab_content pd0">
                    <div class="formRow">
                        <label class="formLeft" for="param_name">Tên:<span class="req">*</span></label>
                        <div class="formRight">
                            <span class="oneTwo"><input name="name" id="param_name" _autocheck="true" type="text"></span>
                            <span name="name_autocheck" class="autocheck"></span>
                            <div name="name_error" class="clear error"><?php echo form_error('name');?></div>
                        </div>
                        <div class="clear"></div>
                    </div>

                    <div class="formRow">
                        <label class="formLeft">Hình ảnh:<span class="req">*</span></label>
                        <div class="formRight">
                            <div class="left"><input type="file" id="image" name="image"></div>
                            <div name="image_error" class="clear error"></div>
                        </div>
                        <div class="clear"></div>
                    </div>

                    <div class="formRow">
                        <label class="formLeft">Thứ tự:<span class="req">*</span></label>
                        <div class="formRight">
                            <div class="left"><input type="text" id="sort_order" name="sort_order"></div>
                            <div name="image_error" class="clear error"></div>
                        </div>
                        <div class="clear"></div>
                    </div>

                    <div class="formRow">
                        <label class="formLeft">image_name</label>
                        <div class="formRight">
                            <div class="left"><input type="text" id="image_name" name="image_name"></div>
                            <div name="image_error" class="clear error"></div>
                        </div>
                        <div class="clear"></div>
                    </div>

                    <div class="formRow">
                        <label class="formLeft">Link</label>
                        <div class="formRight">
                            <div class="left"><input type="text" id="link" name="link"></div>
                            <div name="image_error" class="clear error"></div>
                        </div>
                        <div class="clear"></div>
                    </div>

                </div>


            </div><!-- End tab_container-->

            <div class="formSubmit">
                <input type="submit" value="Thêm mới" class="redB">
                <input type="reset" value="Hủy bỏ" class="basic">
            </div>
            <div class="clear"></div>
        </div>
    </fieldset>
</form>
