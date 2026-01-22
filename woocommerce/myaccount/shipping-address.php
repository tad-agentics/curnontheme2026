<?php
$userid = get_current_user_id();

$firt_name = get_user_meta($userid, 'shipping_first_name', true);
$email = get_user_meta($userid, 'billing_email', true);
$last_name = get_user_meta($userid, 'shipping_last_name', true);
$address_1 = get_user_meta($userid, 'shipping_address_1', true);
$city = get_user_meta($userid, 'billing_city', true);
$state = get_user_meta($userid, 'billing_state', true);
$address_2 = get_user_meta($userid, 'shipping_address_2', true);

$shipping_phone = get_user_meta($userid, 'shipping_phone', true);
?>

<div class="acc-add acc-add-input-js">
    <form action="" class="is-loading-group" id="mona_update_shipping">
        <div class="acc-add-flex">
            <div class="acc-add-left">
                <p class="text">Email </p>
            </div>
            <div class="acc-add-right">
                <div class="ip-control">
                    <input class="re-input" name="shipping_email" type="text" value="<?php echo $email ?>" disabled>
                </div>
            </div>
        </div>
        <div class="acc-add-flex">
            <div class="acc-add-left">
                <p class="text">Họ và Tên </p>
            </div>
            <div class="acc-add-right">
                <div class="ip-control">
                    <input class="re-input" name="shipping_last_name" type="text" value="<?php echo $last_name ?>"
                        disabled>
                </div>
            </div>
        </div>
        <div class="acc-add-flex">
            <div class="acc-add-left">
                <p class="text">Số điện thoại *</p>
            </div>
            <div class="acc-add-right">
                <div class="ip-control">
                    <input class="re-input" name="shipping_phone" type="text" value="<?php echo $shipping_phone ?>"
                        disabled>
                </div>
            </div>
        </div>
        <div class="acc-add-flex">
            <div class="acc-add-left">
                <p class="text">Địa chỉ nhận hàng *</p>
            </div>
            <div class="acc-add-right">
                <div class="ip-control">
                    <input class="re-input" name="shipping_address_1" type="text" value="<?php echo $address_1 ?>"
                        disabled>
                </div>
                <!-- <div class="ip-control x3">
                    <div class="ip-control">
                        <input class="re-input" name="shipping_state" type="text" value="<?php echo $state ?>" disabled>
                    </div>
                </div>
                <div class="ip-control x3">
                    <input class="re-input" name="shipping_city" type="text" value="<?php echo $city ?>" disabled>
                </div>
                <div class="ip-control x3">
                    <input class="re-input" name="shipping_address_2" type="text" value="<?php echo $address_2 ?>" disabled>
                </div> -->
            </div>
        </div>
        <!-- <button class="btn second m-top" type="submit">
            <span class="inner">
                <?php _e('Xác nhận', 'monamedia') ?>
            </span>
        </button> -->
    </form>
</div>