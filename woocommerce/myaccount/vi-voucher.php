<?php
// Lấy tất cả các mã giảm giá
$coupons = get_posts(
    array(
        'post_type' => 'shop_coupon',
        'post_status' => 'publish',
        'numberposts' => -1,
    )
);

if ($coupons) {
?>
    <div class="acc-vou">
        <div class="acc-vou-list">

            <?php
            foreach ($coupons as $coupon_post) {
                $coupon = new WC_Coupon($coupon_post->ID);
                $coupon_code = $coupon->get_code();
                $description = $coupon->get_description();
                $expiry_date = $coupon->get_date_expires();

            ?>

                <div class="pcart-tag-item">
                    <div class="pcart-tag-box">
                        <div class="pcart-tag-top">
                            <div class="pcart-tag-flex">
                                <span class="code">
                                    <?php echo $coupon_code ?></span><span class="text"><?php echo $description; ?></span>
                            </div>
                        </div>
                        <div class="pcart-tag-bot">
                            <div class="pcart-tag-flex">
                                <span class="txt">
                                    <?php echo $coupon_code ?></span>
                                <a href="<?php echo site_url('thanh-toan/'); ?>" class="link" data-coupon="<?php echo $coupon_code ?>">
                                    <?php _e('Sử dụng', 'monamedia'); ?>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

            <?php } ?>

        </div>
    </div>
<?php
} else {
    echo 'Hiện tại mã giảm đang được cập nhật vui lòng quay lại sau.';
}
?>