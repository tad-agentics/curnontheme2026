<?php
$userid = get_current_user_id();

$firt_name = get_user_meta($userid, 'shipping_first_name', true);
$last_name = get_user_meta($userid, 'shipping_last_name', true);
$address_1 = get_user_meta($userid, 'shipping_address_1', true);
$city = get_user_meta($userid, 'shipping_city', true);
$state = get_user_meta($userid, 'shipping_state', true);
$shipping_phone = get_user_meta($userid, 'shipping_phone', true);
?>
<div class="acc-main">
    <h1 class="t-title-second mb-16">
        <?php _e('Địa chỉ giao hàng', 'monamedia') ?>
    </h1>
</div>

<div class="acc-form form-doimatkhau">
    <form action="" class="is-loading-group" id="mona_update_shipping">
        <?php wp_nonce_field('mona_ajax_nonce', 'mona_nonce'); ?>
        <div class="f-list row">
            <div class="f-item col">
                <div class="re-label"><?php _e('Họ người nhận', 'monamedia') ?></div>
                <input class="re-input" name="shipping_last_name" type="text" value="<?php echo esc_attr($last_name); ?>">
            </div>
            <div class="f-item col">
                <div class="re-label"><?php _e('Tên người nhận', 'monamedia') ?></div>
                <input class="re-input" name="shipping_first_name" type="text" value="<?php echo esc_attr($firt_name); ?>">
            </div>
            <div class="f-item col">
                <div class="re-label"><?php _e('Số điện thoại', 'monamedia') ?></div>
                <input class="re-input" name="shipping_phone" type="text" value="<?php echo esc_attr($shipping_phone); ?>">
            </div>
            <div class="f-item col">
                <div class="re-label"><?php _e('Tỉnh', 'monamedia') ?></div>
                <input class="re-input" name="shipping_state" type="text" value="<?php echo esc_attr($state); ?>">
            </div>
            <div class="f-item col">
                <div class="re-label"><?php _e('Quận/Huyện', 'monamedia') ?></div>
                <input class="re-input" name="shipping_city" type="text" value="<?php echo esc_attr($city); ?>">
            </div>
            <div class="f-item col">
                <div class="re-label"><?php _e('Địa chỉ', 'monamedia') ?></div>
                <input class="re-input" name="shipping_address_1" type="text" value="<?php echo esc_attr($address_1); ?>">
            </div>
        </div>
        <button class="btn second m-top" type="submit">
            <span class="inner">
                <?php _e('Xác nhận', 'monamedia') ?>
            </span>
        </button>
    </form>
</div>