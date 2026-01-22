<?php

/**
 * Review order table
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/review-order.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 5.2.0
 */

defined('ABSPATH') || exit;
remove_action('woocommerce_checkout_order_review', 'woocommerce_checkout_payment', 20);
?>
<div class="shop_table woocommerce-checkout-review-order-table">

    <h2 class="title fw-6 f-title" id="mona-checkout-qty">
        <?php _e('GIỎ HÀNG ', 'monamedia'); ?> <?php echo '(' . WC()->cart->get_cart_contents_count() . ')'; ?>
    </h2>
    <div class="pcart-list">
        <?php
        do_action('woocommerce_review_order_before_cart_contents');

        foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
            $_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);

            if ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_checkout_cart_item_visible', true, $cart_item, $cart_item_key)) {
                $thumbnail = $_product->get_image(array(100, 100));
                $product_price = $_product->get_price();
                $product_id = $_product->get_id();
        ?>

                <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">

                <div class="pcart-item">

                    <label class="" style="display: none;">
                        <span class="btn-del m-remove-cart-item" data-cart-key="<?php echo $cart_item_key; ?>"></span></label>
                    <div class="pcart-img">
                        <a class="box" href="<?php echo esc_url($link); ?>">
                            <?php echo $thumbnail; ?>
                        </a>
                    </div>
                    <div class="pcart-desc">
                        <div class="pcart-desc-top">
                            <div class="pcart-name">
                                <?php echo wp_kses_post(apply_filters('woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key)) . '&nbsp;'; ?>

                                <!-- category of product  -->
                                <?php $taxonomy = 'product_cat';
                                $primary_cat_id = get_post_meta($_product->id, '_yoast_wpseo_primary_' . $taxonomy, true);
                                if ($primary_cat_id) {
                                    $primary_cat = get_term($primary_cat_id, $taxonomy);
                                    if (isset($primary_cat->name)) ?>
                                    <span class="attr">
                                        <?php echo $primary_cat->name; ?>
                                    </span>
                                <?php }  ?>

                            </div>

                            <div class="pcart-remove icon-item-remove">
                                <?php
                                echo apply_filters(
                                    'woocommerce_cart_item_remove_link',
                                    sprintf(
                                        '<a href="%s" class="del" aria-label="%s" data-product_id="%s" data-product_sku="%s"><span class="icon"><i class="fa-light fa-xmark"></i> </span></a>',
                                        esc_url(wc_get_cart_remove_url($cart_item_key)),
                                        esc_html__('Remove this item', 'woocommerce'),
                                        esc_attr($product_id),
                                        esc_attr($_product->get_sku())
                                    ),
                                    $cart_item_key
                                );
                                ?>
                            </div>
                        </div>

                        <?php if ($cart_item['mona_data']['select_gift'] === 'on') : ?>
                            <div class="content-gift-product">
                                <?php if (!empty($cart_item['mona_data']['select_content'])) {
                                    echo '<p class="cmini-text t12 c-grey fw-5"><strong>Nội dung gói quà:</strong> ' . esc_html($cart_item['mona_data']['select_content']) . '<strong> - Miễn phí</strong></p>';
                                } else {
                                    echo '<p class="cmini-text t12 c-grey fw-5"><strong>Thiệp không nội dung, gói quà và thắt nơ<strong> - Miễn phí</strong></p></p>';
                                } ?>
                            </div>
                        <?php endif; ?>

                        <div class="pcart-desc-bot">
                            <div class="pcart-item-quan">
                                <div class="quantity">
                                    <div class="quantity-count">
                                        <div class="count">
                                            <div class="count-btn count-minus m_price_minus is-loading-group"><i class="fas fa-minus icon"></i>
                                            </div>
                                            <input type="number" value="<?php echo $cart_item['quantity']; ?>" max="100" min="0" class="count-input input-cart-single ip-value" name="quantity" hidden="">
                                            <p class="count-number">
                                                <?php if ($cart_item['quantity'] < 10) {
                                                    echo '0';
                                                } ?><?php echo $cart_item['quantity']; ?>
                                            </p>
                                            <div class="count-btn count-plus m_price_plus is-loading-group"><i class="fas fa-plus icon"></i></div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="pcart-item-price">
                                <?php echo wc_price($product_price); ?>
                            </div>
                        </div>



                    </div>
                </div>
        <?php }
        }
        do_action('woocommerce_review_order_after_cart_contents');
        ?>
    </div>
    <div class="checkout-wrap-pcart">
        <div class="pcart-row">
            <?php get_template_part('partials/product/ItemRelated'); ?>
            <script type="text/javascript">
                $(document).ready(function($) {
                    var pdpDKSwiper = new Swiper(".pdpDKSwiper", {
                        effect: "slide",
                        slidesPerView: 3,
                        spaceBetween: 8,

                        breakpoints: {
                            768: {
                                slidesPerView: 3,
                                spaceBetween: 8,
                            },
                            992: {
                                slidesPerView: 4,
                                spaceBetween: 12,
                            },
                        },
                        navigation: {
                            nextEl: ".pdp-dk-btn-next",
                            prevEl: ".pdp-dk-btn-prev",
                        },
                    });
                });
            </script>
        </div>
        <div class="pcart-row coupon-block is-loading-group">
            <div class="pcart-code">
                <div class="pcart-code-input">
                    <input type="text" name="custom_coupon_code" id="custom-coupon-code" placeholder="Enter discount code">
                    <a class="btn btn-pri" id="apply-coupon-button">
                        <span class="text">
                            <?php _e('ÁP DỤNG', 'monamedia') ?>
                        </span>
                    </a>
                </div>
                <div class="pcart-promo">
                    <div class="pcart-promo-list">
                        <?php foreach (WC()->cart->get_coupons() as $code => $coupon) : ?>
                            <div class="pcart-promo-item">
                                <div class="pcart-promo-left">
                                    <span class="icon"> <img src="<?php echo esc_url(get_site_url()); ?>/template/assets/images/icon-tag.svg" alt="" /></span>
                                    <span class="text"><?php wc_cart_totals_coupon_label($coupon); ?></span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <?php get_template_part('partials/global/MaGiamGia'); ?>
            <script type="text/javascript">
                $(document).ready(function($) {
                    var pcartTagSwiper = new Swiper(".pcartTagSwiper", {
                        effect: "slide",
                        spaceBetween: 12,
                        slidesPerView: 1.3,
                        grabCursor: true,
                        breakpoints: {
                            992: {
                                slidesPerView: 1.85,
                            },
                        },
                    });


                    $('.apply-coupon-button-2').on('click', function() {
                        var couponCode = $(this).data('coupon');
                        apply_coupon(couponCode);
                    });

                    $('#apply-coupon-button').on('click', function() {
                        var couponCode = $('#custom-coupon-code').val();
                        apply_coupon(couponCode);
                    });

                    function apply_coupon(couponCode = '') {
                        let boxLoading = $('.coupon-block');
                        if (!boxLoading.hasClass('processing')) {
                            if (couponCode !== "") {
                                $.ajax({
                                    type: 'POST',
                                    url: mona_ajax_url.ajaxURL,
                                    data: {
                                        action: 'apply_coupon_action',
                                        nonce: mona_ajax_url.nonce,
                                        coupon_code: couponCode,
                                    },
                                    error: function(request) {
                                        boxLoading.removeClass('processing');
                                    },
                                    beforeSend: function(response) {
                                        boxLoading.addClass('processing');
                                    },
                                    success: function(response) {
                                        boxLoading.removeClass('processing');
                                        if (response.success == true) {
                                            jQuery(document.body).trigger('update_checkout')
                                        } else {}
                                    },
                                });
                            }
                        }
                    }
                });
            </script>
        </div>
        <div class="pcart-row">
            <div class="pcart-total">
                <div class="pcart-total-flex">
                    <div class="text"><?php _e('Tạm tính', 'monamedia') ?></div>
                    <div class="fee"> <?php echo wc_cart_totals_subtotal_html(); ?></div>
                </div>
                <?php foreach (WC()->cart->get_coupons() as $code => $coupon) : ?>
                    <div class="pcart-total-flex cart-discount coupon-<?php echo esc_attr(sanitize_title($code)); ?>">
                        <span class="text name">
                            <?php wc_cart_totals_coupon_label($coupon); ?>
                        </span>
                        <span class="price">
                            <?php wc_cart_totals_coupon_html($coupon); ?>
                        </span>
                    </div>
                <?php endforeach; ?>
                <!-- shipping  -->
                <?php if (WC()->cart->needs_shipping() && WC()->cart->show_shipping()) : ?>
                    <?php do_action('woocommerce_review_order_before_shipping'); ?>
                    <div class="pcart-total-flex">
                        <?php echo wc_cart_totals_shipping_html(); ?>
                    </div>
                    <?php do_action('woocommerce_review_order_after_shipping'); ?>
                <?php endif; ?>
                <!-- total  -->
                <div class="pcart-total-flex total">
                    <div class="text"><?php _e('Tổng', 'monamedia') ?></div>
                    <div class="fee"> <?php echo wc_cart_totals_order_total_html(); ?></div>
                </div>
            </div>
        </div>
    </div>

</div>
<?php do_action('woocommerce_review_order_before_order_total'); ?>
<?php wp_nonce_field('woocommerce-process_checkout', 'woocommerce-process-checkout-nonce'); ?>