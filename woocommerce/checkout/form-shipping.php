<?php

/**
 * Checkout shipping information form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-shipping.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 * @global WC_Checkout $checkout
 */

defined('ABSPATH') || exit;
?>
<!-- <h1 class="title fw-6 f-title">THÔNG TIN VẬN CHUYỂN</h1> -->
<div class="woocommerce-shipping-fields pcart-form">
    <?php if (true === WC()->cart->needs_shipping_address()) : ?>


        <div class="shipping_address pcart-form-list">
            <?php do_action('woocommerce_before_checkout_shipping_form', $checkout); ?>

            <div class="woocommerce-shipping-fields__field-wrapper">
                <?php
                // $fields = $checkout->get_checkout_fields('shipping');

                // foreach ($fields as $key => $field) {
                //     woocommerce_form_field($key, $field, $checkout->get_value($key));
                // }
                // do_action('woocommerce_checkout_billing');
                ?>
            </div>

            <?php do_action('woocommerce_after_checkout_shipping_form', $checkout); ?>
        </div>

    <?php endif; ?>
    <!-- Phương thức thanh toán  -->
    <?php do_action('woocommerce_checkout_before_order_review_heading'); ?>
    <div class="pcart-method woocommerce-payment-methods">
        <h2 class="title fw-6 f-title">HÌNH THỨC THANH TOÁN</h2>

        <?php echo woocommerce_checkout_payment(); ?>

    </div>

    <?php do_action('woocommerce_review_order_before_submit'); ?>
    <div class="pcart-form-btn">
        <?php
        $order_button_text = 'Thanh toán';
        $order_button_text = str_replace('wc', '', $order_button_text);
        echo apply_filters(
            'woocommerce_order_button_html',
            '<button type="submit" 
                class="btn btn-pri full second second-green btn-call-checkout' . esc_attr(wc_wp_theme_get_element_class_name('button') ? '' . wc_wp_theme_get_element_class_name('button') : '') . '" 
                name="woocommerce_checkout_place_order" 
                id="place_order" 
                value="' . esc_attr($order_button_text) . '" 
                data-value="' . esc_attr($order_button_text) . '"> <span class="text">' . esc_html($order_button_text) . '</span>
            </button>'
        ); ?>
    </div>
    <?php do_action('woocommerce_review_order_after_submit'); ?>


    <div class="pcart-form-bot">
        <div class="pcart-form-bot-item"> <span class="icon"> <img src="<?php get_site_url(); ?>/template/assets/images/poli3.svg" alt="" /></span><span class="text">BẢO HÀNH trong 10 năm</span>
        </div>
        <div class="pcart-form-bot-item"> <span class="icon"> <img src="<?php get_site_url(); ?>/template/assets/images/poli1.svg" alt="" /></span><span class="text">ĐỔI TRẢ MIỄN PHÍ trong 3
                ngày</span></div>
    </div>
</div>



<!-- thông tin  -->
<!-- <div class="pcart-form-list">
                                        <div class="ip-control">
                                            <input class="ploginInput" placeholder="" type="text"><span class="text-abs">Email * </span>
                                        </div>
                                        <div class="ip-control x2">
                                            <input class="ploginInput" placeholder="" type="text"><span class="text-abs">Họ và tên*</span>
                                        </div>
                                        <div class="ip-control x2">
                                            <input class="ploginInput" placeholder="" type="text"><span class="text-abs">Số điện thoại*</span>
                                        </div>
                                        <div class="ip-control">
                                            <input class="ploginInput" placeholder="" type="text"><span class="text-abs">Địa chỉ *</span>
                                        </div>
                                        <div class="ip-control x3">
                                            <select class="re-select-main">
                                                <option selected="" disabled="" value="AL">Chọn tp/tỉnh</option>
                                                <option value="WY">Hồ Chí Minh</option>
                                                <option value="WY">Ha Noi</option>
                                            </select>
                                        </div>
                                        <div class="ip-control x3">
                                            <select class="re-select-main">
                                                <option selected="" disabled="" value="AL">Chọn quận / huyện</option>
                                                <option value="WY">Hồ Chí Minh</option>
                                                <option value="WY">Ha Noi</option>
                                            </select>
                                        </div>
                                        <div class="ip-control x3">
                                            <select class="re-select-main">
                                                <option selected="" disabled="" value="AL">Chọn phường/xã </option>
                                                <option value="WY">Hồ Chí Minh</option>
                                                <option value="WY">Ha Noi</option>
                                            </select>
                                        </div>
                                        <div class="ip-control gc">
                                            <input placeholder="Ghi chú thêm (Ví dụ: Giao giờ hành chính)" type="text"><span class="icon-abs"><img src="<?php get_site_url(); ?>/template/assets/images/icon-ghichu.svg" alt="" /></span>
                                        </div>
                                    </div> -->