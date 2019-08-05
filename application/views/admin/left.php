<div id="leftSide" style="padding-top:30px;">

		    <!-- Account panel -->

<div class="sideProfile">
	<a href="#" title="" class="profileFace"><img width="40" src="<?php echo public_url(); ?>/admin/images/user.png" /></a>
	<span>Xin chào: <strong>admin!</strong></span>
    <?php if (isset($info)):?>
	<span><?php echo $info->name?></span>
    <?php endif;?>
	<div class="clear"></div>
</div>
<div class="sidebarSep"></div>
		    <!-- Left navigation -->

<ul id="menu" class="nav">
    <li class="home">

			<a href="<?php echo admin_url('')?>" class="active" id="current">
				<span>Bảng điều khiển</span>
				<strong></strong>
			</a>

    </li>
    <li class="tran">

			<a href="admin/tran.html" class=" exp" >
				<span>Quản lý bán hàng</span>
				<strong>2</strong>
			</a>

							<ul class="sub">
                                <li >
							<a href="<?php echo admin_url('transaction')?>">
								Giao dịch
                            </a>
                                </li>
                                <li >
							<a href="<?php echo admin_url('order')?>">
								Đơn hàng sản phẩm
                            </a>
						       </li>
                                <li>
                                    <a href="<?php echo admin_url('transaction/report')?>">
                                        Report
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo admin_url('transaction/admin_sentmail') ?>">
                                        Sent Mail
                                    </a>
                                </li>
                            </ul>

    </li>
			<li class="product">

			<a href="<?php echo admin_url('catalog')?>" class=" exp" >
				<span>Sản phẩm</span>
				<strong>3</strong>
			</a>

							<ul class="sub">
                                <li >
							<a href="<?php echo admin_url('product')?>">
								Sản phẩm
                            </a>
                                </li>

                                <li >
							<a href="<?php echo admin_url('catalog')?>">
								Danh mục
                            </a>
                                </li>

                                <li >
							<a href="admin/comment.html">
								Phản hồi
                            </a>
                                </li>
                            </ul>

            </li>
			<li class="account">

			<a href="admin/account.html" class=" exp" >
				<span>Tài khoản</span>
				<strong>3</strong>
			</a>

							<ul class="sub">
                                <li >
							<a href="<?php echo admin_url('admin')?>">
								Ban quản trị
                            </a>
                                </li>

                                <li >
							<a href="admin/admin_group.html">
								Nhóm quản trị
                            </a>
                                </li>
                                <li >
							<a href="admin/user.html">
								Thành viên
                            </a>
                                </li>

                            </ul>


            </li>
			<li class="support">

			<a href="admin/support.html" class=" exp" >
				<span>Hỗ trợ và liên hệ</span>
				<strong>2</strong>
			</a>

							<ul class="sub">
                                <li >
							<a href="admin/support.html">
								Hỗ trợ
                            </a>
                                </li>
                                <li >
							<a href="admin/contact.html">
								Liên hệ
                            </a>
                                </li>

                            </ul>


            </li>
			<li class="content">

			<a href="admin/content.html" class=" exp" >
				<span>Nội dung</span>
				<strong>4</strong>
			</a>

							<ul class="sub">
              <li >
							<a href="<?php echo admin_url('slide')?>">
								Slide
              </a>

              </li>
              <li >
							  <a href="<?php echo admin_url('news')?>">
								  Tin tức
                </a>

              </li>
            <li >
							<a href="admin/info.html">
								Trang thông tin
              </a>

           </li>
            <li >
							<a href="admin/video.html">
								Video
              </a>

            </li>
            </ul>


            </li>

</ul>
		<div class="clear"></div>
	</div>
