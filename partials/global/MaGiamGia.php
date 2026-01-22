<?php
// Lấy tất cả các mã giảm giá
$coupons = get_posts(
    array(
        'post_type' => 'shop_coupon',
        'post_status' => 'publish',
        'numberposts' => -1,
    )
);

if ( $coupons ) {
    $discounts = new WC_Discounts( WC()->cart );
?>
<div class="pcart-tag">
    <div class="swiper pcartTagSwiper">
        <div class="swiper-wrapper">
            <?php
            foreach ($coupons as $coupon_post) {
                $coupon      = new WC_Coupon($coupon_post->ID);
                $coupon_code = $coupon->get_code();
                $description = $coupon->get_description();
                // $expiry_date = $coupon->get_date_expires();

                $results     = $discounts->is_coupon_valid( $coupon );
                $classes     = 'normal';

                if ( WC()->cart->has_discount( $coupon_code ) ) {
                    $classes = 'disabled';
                }

                if ( is_wp_error( $results ) ) {
                    $classes = 'disabled';
                }
            ?>
            <div class="swiper-slide coupon-item <?php echo $classes ?>">
                <div class="pcart-tag-item">
                    <div class="pcart-tag-box">
                        <div class="pcart-tag-top">
                            <div class="pcart-tag-flex">
                                <span class="code"><?php echo $coupon_code ?></span>
                                <span class="text"><?php echo $description; ?></span>
                            </div>
                            <?php if ( is_wp_error( $results ) ) {  ?>
                            <div class="pcart-tag-flex">
                                <?php echo sprintf( '<sub>%1$s</sub>', $results->get_error_message() ); ?>
                            </div>
                            <?php } ?>
                        </div>
                        <div class="pcart-tag-bot">
                            <div class="pcart-tag-flex">
                                <span class="txt"><?php echo $coupon_code ?></span>
                                <?php if ( ! WC()->cart->has_discount( $coupon_code ) && ! is_wp_error( $results ) ) { ?>
                                <span class="link apply-coupon-button-2" data-coupon="<?php echo $coupon_code ?>">
                                    <?php _e('Sử dụng','monamedia') ?>
                                </span>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
</div>
<?php
} else {
    echo 'Không có mã giảm giá nào.';
}
?>