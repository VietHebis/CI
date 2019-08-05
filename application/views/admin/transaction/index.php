<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 25/06/18
 * Time: 2:15 CH
 */
$this->load->view('admin/transaction/head',$this->data);?>
<div class="line"></div>
<div class="wrapper" id="main_transaction">
    <?php $this->load->view('admin/notify');?>
    <div class="widget">

        <div class="title">
            <span class="titleIcon"><input type="checkbox" id="titleCheck" name="titleCheck"></span>
            <h6>
                Danh sách giao dịch			</h6>
            <div class="num f12">Số lượng: <b><?php echo $total_rows;?></b></div>
        </div>

        <table cellpadding="0" cellspacing="0" width="100%" class="sTable mTable myTable" id="checkAll">

            <thead class="filter"><tr><td colspan="8">
                    <form class="list_filter form" action="<?php echo admin_url('transaction')?>" method="get">
                        <table cellpadding="0" cellspacing="0" width="80%"><tbody>

                            <tr>
                                <td class="label" style="width:60px;"><label for="filter_id">Mã số</label></td>
                                <td class="item"><input name="id" value="<?php echo $this->input->get('id')?>" id="filter_id" type="text" style="width:55px;"></td>

                                <td class="label" style="width:60px;"><label for="filter_id">Hình thức</label></td>
                                <td class="item">
                                <select name="payment">
                                    <option value=""></option>
                                    <option value="nganluong"<?php echo ($this->input->get('payment')) =='nganluong' ? 'selected' : ''?>>Ngân lượng</option>
                                    <option value="baokim"<?php echo ($this->input->get('payment')) =='baokim' ? 'selected' : ''?>>Bảo kim</option>
                                    <option value="offline"<?php echo ($this->input->get('payment')) =='offline' ? 'selected' : ''?>>Tại nhà</option>
                                </select>
                                </td>

                                <td class="label" style="width:60px;"><label for="filter_id">Trạng thái</label></td>
                                <td class="item">
                                    <select name="status">
                                        <option></option>
                                        <option value="0" <?php echo ($this->input->get('status')) =='0' ? 'selected' : ''?>>Đợi xử lý</option>
                                        <option value="1" <?php echo ($this->input->get('status')) =='1' ? 'selected' : ''?>>Thành công</option>
                                        <option value="2" <?php echo ($this->input->get('status')) =='2' ? 'selected' : ''?>>Hủy bỏ</option>
                                    </select>
                                </td>
                            </tr>

                                <tr>
                                <td class="label" style="width:60px;"><label for="filter_created">Từ ngày</label></td>
                                <td class="item"><input name="created" value="<?php echo ($this->input->get('created')) ? $this->input->get('created') : '';?>" id="filter_created " type="text" class="datepicker" size="10"></td>

                                <td class="label" style="width:60px;"><label for="filter_to">Đến ngày</label></td>
                                <td class="item"><input  name="created_to" value="<?php echo ($this->input->get('created_to')) ? $this->input->get('created_to') : '';?>" id="filter_to " type="text" class="datepicker" size="10"></td>

                                <td style="width:150px">
                                    <input type="submit" class="button blueB" value="Lọc">
                                    <input type="reset" class="basic" value="Reset" onclick="window.location.href = '<?php echo admin_url('transaction')?>'; ">
                                </td>
                                   <td>
                                       <input  class="button redB" value="Export" onclick="window.location.href='<?php echo admin_url('transaction/export') ?>'">
                                   </td>
                                </tr>
                            </tbody></table>
                    </form>
                </td></tr></thead>

            <thead>
            <tr>
                <td style="width:21px;"><img src="<?php echo public_url('admin')?>/images/icons/tableArrows.png"></td>
                <td style="width:60px;">Mã số</td>
                <td>Số tiền</td>
                <td>Cổng thanh toán</td>
                <td>Trạng thái</td>
                <td style="width:75px;">Ngày tạo</td>
                <td style="width:120px;">Hành động</td>
            </tr>
            </thead>

            <tfoot class="auto_check_pages">
            <tr>
                <td colspan="8">
                    <div class="list_action itemActions">
                        <a href="#submit" id="submit" class="button blueB" url="<?php echo admin_url('transaction/dell_all')?>">
                            <span style="color:white;">Xóa hết</span>
                        </a>
                    </div>
                    <div class="pagination">
                        <?php echo $this->pagination->create_links();?>
                    </div>
                </td>
            </tr>
            </tfoot>

            <tbody class="list_item">
            <?php foreach ($list as $row) :?>
            <tr class="row_<?php echo $row->id;?>">
                <td><input type="checkbox" name="id[]" value="<?php echo $row->id;?>"></td>

                <td class="textC"><?php echo $row->id;?></td>

               <td><?php echo number_format($row->amount)?></td>
               <td><?php echo $row->payment?></td>
               <td class="status textC">
                   <?php if ($row->status == 0)
                   {
                       echo '<span class="pending">Chưa thanh toán</span>';
                   }
                   elseif ($row->status == 1)
                   {
                       echo '<span class="completed">Đã thanh toán</span>';
                   }
                   else echo 'Thanh toán thất bại';
                       ?>
               </td>

                <td class="textC"><?php echo $row->created?></td>

                <td class="option textC">

                    <a href="<?php echo admin_url('transaction/view/'.$row->id)?>" target="_blank" class="tipS" title="Xem chi tiết giao dịch">
                        <img src="<?php echo public_url('admin')?>/images/icons/color/view.png">
                    </a>

                    <a href="<?php echo admin_url('transaction/delete/'.$row->id)?>" title="Xóa giao dịch" class="tipS verify_action">
                        <img src="<?php echo public_url('admin')?>/images/icons/color/delete.png">
                    </a>
                </td>
            </tr>
            <?php endforeach;?>

            </tbody>

        </table>
    </div>

</div>