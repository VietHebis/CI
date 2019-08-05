<style>
    thead {color:green;}
    tbody {color:blue;}
    tfoot {color:red;}
    tfoot a {color: green;}

    table, th, td {
        border: 1px solid black;
        padding: 5px;
        margin: 2px;
    }
</style>

<div class="box-center"><!-- The box-center product-->
    <div class="tittle-box-center">
        <?php if ($total_items > 0):?>
        <h2>Thông tin giỏ hàng: Có <?php echo $total_items?> sản phẩm</h2>
    </div>
    <div class="box-content-center product"><!-- The box-content-center -->
        <form action="<?php echo base_url('cart/update')?>" method="post">
        <table>
            <thead>
            <tr>
                <th>Sản phẩm</th>
                <th>Số lượng</th>
                <th>Giá bán</th>
                <th>Tổng số</th>
                <th>Xóa</th>
            </tr>
            </thead>
            <tbody>
            <?php $total_amount = '';?>
            <?php foreach ($cart as $row):?>
            <?php $total_amount += $row['subtotal'];?>
            <tr>
                <td><?php echo $row['name']?></td>
                <td><input name="qty_<?php echo $row['id'];?>" value="<?php echo $row['qty']?>" size="5"></td>
                <td><?php echo number_format($row['price'])?></td>
                <td><?php echo number_format($row['subtotal'])?></td>
                <td><a href="<?php echo base_url('cart/del/'.$row['id'])?>">Xóa</a></td>
            </tr>
            <?php endforeach;?>
            </tbody>
            <tfoot>
            <tr>
                <td>Tổng số tiền thanh toán:</td>
                <td colspan="3" align="center"><?php echo number_format($total_amount);?></td>
                <td><a href="<?php echo base_url('cart/del')?>">Xóa hết</a></td>
            </tr>
            <tr>
                <td colspan="2"><button type="submit">Cập nhật</button></td>
                <td colspan="3"><a class="button" href="<?php echo base_url('order/check_out')?>">Thanh toán</a> </td>
            </tr>
            </tfoot>
        </table>
        </form>
        <?php else:?>
        <?php echo '<h3>Chưa có sản phẩm trong giỏ hàng</h3>';?>
        <?php endif;?>
    </div>
</div>

