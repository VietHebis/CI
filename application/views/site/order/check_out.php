<style>
    @import url('https://fonts.googleapis.com/css?family=Yantramanav:100,300');

    /* ------------- */
    /* GLOBAL STYLES */
    /* ------------- */

    * {
        box-sizing: border-box;
    }



    ul {
        list-style: none;
        padding: 0;
    }

    .brand {
        text-align: center;
        font-weight: 300;
        text-transform: uppercase;
        letter-spacing: 0.1em;
    }

    .brand span {
        color: #ffffff;
    }

    .wrapper {
        box-shadow: 0 0 20px 0 rgba(57, 82, 163, 0.7);
    }

    .wrapper > * {
        padding: 1em;
    }

    /* ------------------- */
    /* COMPANY INFORMATION */
    /* ------------------- */

    .company-info {
        background: #C3C9DD;
        border-top-left-radius: 4px;
        border-top-right-radius: 4px;
    }

    .company-info h3,
    .company-info ul {
        text-align: center;
        margin: 0 0 1rem 0;
    }

    /* ------- */
    /* CONTACT */
    /* ------- */

    .contact {
        background: #dcdfea;
        border-bottom-left-radius: 4px;
        border-bottom-right-radius: 4px;
    }

    /* ---- */
    /* FORM */
    /* ---- */

    .contact form {
        display: grid;
        grid-template-columns: 1fr 1fr;
        grid-gap: 20px;
    }

    .contact form label {
        display: block;
    }

    .contact form p {
        margin: 0;
    }

    .contact form .full {
        grid-column: 1 / 3;
    }

    .contact form button,
    .contact form input,
    .contact form textarea {
        width: 100%;
        padding: 1em;
        border: solid 1px #627EDC;
        border-radius: 4px;
    }

    .contact form textarea {
        resize: none;
    }

    .contact form button {
        background: #627EDC;
        border: 0;
        color: #e4e4e4;
        text-transform: uppercase;
        font-size: 14px;
        font-weight: bold;
    }

    .contact form button:hover,
    .contact form button:focus {
        background: #3952a3;
        color: #ffffff;
        outline: 0;
        transition: background-color 2s ease-out;
    }

    /* ------------- */
    /* MEDIA QUERIES */
    /* ------------- */

    @media only screen and (min-width: 700px) {
        .wrapper {
            display: grid;
            grid-template-columns: 1fr 2fr;
        }

        .wrapper > * {
            padding: 2em;
        }

        .company-info {
            border-radius: 4px 0 0 4px;
        }

        .contact {
            border-radius: 0 4px 4px 0;
        }

        .company-info h3,
        .company-info ul,
        .brand {
            text-align: left;
        }
    }
</style>
<div class="container">

    <br>
    <br>
    <div class="wrapper">

        <!-- COMPANY INFORMATION -->
        <div class="company-info">
            <h3>Thông tin thành viên</h3>

            <ul>
                <li><i class="fa fa-road"></i> 44 Main Street</li>
                <li><i class="fa fa-phone"></i> (555) 555-5555</li>
                <li><i class="fa fa-envelope"></i> test@phoenix.com</li>
            </ul>
        </div>
        <!-- End .company-info -->

        <!-- CONTACT FORM -->
        <div class="contact">
            <h3>Thông tin thành viên</h3>
            <br>
            <br>
            <form id="contact-form" action="" method="post">

                <p class="full">
                    <label>Tổng số tiền cần thanh toán</label>
                    <input style="color: red" type="text" name="total_amount" id="total_amount" value="<?php echo isset($total_amount) ? number_format($total_amount).' đ' : ''?>" disabled >
                </p>

                <p class="full">
                    <label>E-mail</label>
                    <input type="text" name="email" id="email" value="<?php echo isset($user->email)? $user->email : ''?>" >
                <div id="email_error" class="error"><?php echo form_error('email')?></div>
                </p>

                <p class="full">
                    <label>Name</label>
                    <input type="text" name="name" id="name"  value="<?php echo isset($user->name)? $user->name : ''?>">
                <div id="name_error" class="error"><?php echo form_error('name')?></div>
                </p>


                <p class="full">
                    <label>Phone Number</label>
                    <input type="text" name="phone" id="phone" value="<?php echo isset($user->phone)? $user->phone : ''?>">
                <div id="phone_error" class="error"><?php echo form_error('phone')?></div>
                </p>

                <p class="full">
                    <label>Địa chỉ</label>
                    <input type="text" name="address" id="address" value="<?php echo isset($user->address)? $user->address : ''?>">
                <div id="address_error" class="error"><?php echo form_error('address')?></div>
                </p>

                <p class="full">
                    <label>Ghi chú</label>
                    <input type="text" name="message" id="message" value="">
                <div id="address_error" class="error"></div>
                </p>

                <p class="full">
                    <label>Thanh toán qua:</label>
                    <select name="payment" id="payment">
                        <option value="">------- Chọn Cổng Thanh Toán -------</option>
                        <option value="offline">Thanh toán tại nhà</option>
                        <option value="nganluong">Ngân Lượng</option>
                        <option value="baokim">Bảo Kim</option>
                    </select>
                <div id="payment_error" class="error"><?php echo form_error('payment')?></div>
                </p>

                <p class="full">
                    <button type="submit">Thanh toán</button>
                </p>

            </form>
            <!-- End #contact-form -->
        </div>
        <!-- End .contact -->

    </div>
    <!-- End .wrapper -->
</div>
<!-- End .container -->