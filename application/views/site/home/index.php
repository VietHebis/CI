<?php $this->load->view('site/slide'); ?>
<div class="box-center"><!-- The box-center product-->
    <?php if (isset($message)):?>
        <p style="color: #00aadc"><?php $this->load->view('admin/notify');?></p>
    <?php endif;?>
             <div class="tittle-box-center">
		        <h2>Sản phẩm mới</h2>
             </div>
    <div class="box-content-center product"><!-- The box-content-center -->
        <?php foreach ($product_list as $row):?>
                  <div class="product_item">

                       <h3>
                         <a href="<?php echo base_url('product/view_product/'.$row->id)?>" title="Sản phẩm">
                         <?php echo $row->name?>
                         </a>
	                   </h3>
                       <div class="product_img">
                             <a href="<?php echo base_url('product/view_product/'.$row->id)?>" title="Sản phẩm">
                                <img src="<?php echo base_url('upload/product/'.$row->image_link);?>" alt="">
                            </a>
                       </div>
                       <p class="price">
                           <?php if ($row->discount > 0 ):?>
                           <?php $price_new = $row->price - $row->discount;?>
                           <?php echo number_format($price_new);?>
                           <span class="price_old"><?php echo number_format($row->price);?></span>
                           <?php else:?>
                           <?php echo number_format($row->price)?>
                           <?php endif;?>
                       </p>
                        <center>
                            <div class='raty' style='margin:10px 0px' id='8' data-score='3.4'></div>
                        </center>
                       <div class="action">
                           <p style="float:left;margin-left:10px">Lượt xem: <b><?php echo $row->view?></b></p>
	                       <a class="button" href="<?php echo  base_url('cart/add/'.$row->id)?>" title="Mua ngay">Mua ngay</a>
	                       <div class="clear"></div>
                       </div>

                   </div>
        <?php endforeach;?>
                  <div class="clear"></div>

    </div><!-- End box-content-center -->
</div>

<!--Sảm phẩm được xem nhiều -->
<div class="box-center"><!-- The box-center product-->
    <div class="tittle-box-center">
        <h2>Sản phẩm được xem nhiều</h2>
    </div>
    <div class="box-content-center product"><!-- The box-content-center -->
        <?php foreach ($product_buyed as $row):?>
            <div class="product_item">

                <h3>
                    <a href="<?php echo base_url('product/view_product/'.$row->id)?>" title="Sản phẩm">
                        <?php echo $row->name?>
                    </a>
                </h3>
                <div class="product_img">
                    <a href="<?php echo base_url('product/view_product/'.$row->id)?>" title="Sản phẩm">
                        <img src="<?php echo base_url('upload/product/'.$row->image_link);?>" alt="">
                    </a>
                </div>
                <p class="price">
                    <?php if ($row->discount > 0 ):?>
                        <?php $price_new = $row->price - $row->discount;?>
                        <?php echo number_format($price_new);?>
                        <span class="price_old"><?php echo number_format($row->price);?></span>
                    <?php else:?>
                        <?php echo number_format($row->price)?>
                    <?php endif;?>
                </p>
                <center>
                    <div class='raty' style='margin:10px 0px' id='8' data-score='3.4'></div>
                </center>
                <div class="action">
                    <p style="float:left;margin-left:10px">Lượt xem: <b><?php echo $row->view?></b></p>
                    <a class="button" href="<?php echo  base_url('cart/add/'.$row->id)?>" title="Mua ngay">Mua ngay</a>
                    <div class="clear"></div>
                </div>

            </div>
        <?php endforeach;?>
        <div class="clear"></div>

    </div><!-- End box-content-center -->
</div>