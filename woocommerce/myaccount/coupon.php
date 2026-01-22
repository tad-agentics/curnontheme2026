<?php
$user_id = get_current_user_id(); // Lấy ID của người dùng hiện tại

if (!empty($user_id)) {
    $mona_account  = new Account();
    $mona_account->check_coupon($user_id);
    $user_coupon_codes = get_user_meta($user_id, 'coupon_codes', true);

    if (!empty($user_coupon_codes) && is_array($user_coupon_codes)) {
?>
        <div class="acc-main">
            <h1 class="t-title-second mb-16"><?php _e('Mã giảm giá', 'monamedia') ?></h1>
            <div class="ggs">
                <?php
                foreach ($user_coupon_codes as $coupon_id) {
                    $coupon = new WC_Coupon($coupon_id);
                    $expiry_date = $coupon->get_date_expires();
                    $coupon_code = $coupon->get_code();
                    $minimum_amount = get_post_meta($coupon_id, 'minimum_amount', true);

                    $current_time = strtotime(date('Y-m-d')); // Chuyển đổi ngày tháng hiện tại thành timestamp

                    // Chuyển đổi ngày hết hạn của mã giảm giá thành timestamp
                    $expiry_time = strtotime($expiry_date);




                ?>
                    <div class="ggs-item timeDown <?php echo $current_time > $expiry_time ? 'disable' : '' ?>" data-time="<?php echo $expiry_date ?>">
                        <div class="ggs-wrap">
                            <div class="left">
                                <p class="ggs-name"><?php echo $coupon_code ?></p>
                                <p class="ggs-des"><?php echo  __('Hóa đơn trên ', 'monamedia') . $minimum_amount ?></p>
                                <div class="ggs-time">
                                    <p class="title"><?php _e('Hết hạn sau: ', 'monamedia') ?></p>
                                    <div class="ggs-time-text timeDownHtml"> <?php echo $expiry_date ?></div>
                                </div>
                            </div>
                            <div class="right  ">
                                <p class="ggs-tag copy-text"><?php echo   $coupon_code ?></p>
                                <div class="ggs-btn-gr">
                                    <button class="ggs-btn second mona-copy-text" data-text="<?php echo   $coupon_code ?>">
                                        <?php _e('Sao chép', 'monamedia') ?>
                                    </button>
                                    <a class="ggs-btn" href="<?php echo site_url('/danh-sach-san-pham') ?>">
                                        <?php _e('Sử dụng', 'monamedia') ?>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                <?php }
                ?>
            </div>
        </div>
    <?php } else { ?>
        <div class="cart-emp-wrapper ">
            <div class="cart-emp">
                <div class="cart-emp-img">
                    <img src="<?php echo MONA_HOME_URL ?>/template/assets/images/empty-coupon.png" alt="">
                </div>
                <p class="cart-emp-text"> <?php _e('Chưa có mã giảm giá', 'monamedia') ?> </p>
            </div>
            <a href="<?php echo home_url("/") ?>" class="btn second">
                <span class="inner">
                    <span class="text"> <?php _e('Quay lại trang chủ', 'monamedia') ?> </span>
                </span>
            </a>
        </div>
<?php   }
} ?>