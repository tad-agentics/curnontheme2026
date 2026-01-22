<?php

/**
 * Thankyou page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/thankyou.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 8.1.0
 *
 * @var WC_Order $order
 */

defined('ABSPATH') || exit;
?>

<div class="woocommerce-order">
    <?php
    if ($order) :

        do_action('woocommerce_before_thankyou', $order->get_id());
    ?>
        <div class="pcart p-success">
            <div class="pcart-wrap">
                <div class="container">
                    <div class="pcart-inner">
                        <div class="pcart-flex">
                            <div class="pcart-left" data-aos="fade-right">
                                <div class="pcart-suc">
                                    <div class="pcart-suc-top"> <span class="icon"> <img src="<?php get_site_url(); ?>/template/assets/images/icon-suc.svg" alt="" /></span>
                                        <h1 class="title f-title fw-7 t-center">
                                            <?php _e('ĐẶT HÀNG THÀNH CÔNG', 'monamedia') ?></h1>
                                        <p class="desc fw-5 t-center">
                                            <?php _e('Thông tin cụ thể về đơn hàng đã được gửi vào email của bạn.', 'monamedia') ?>
                                        </p>
                                        <div class="code fw-5"><?php _e('Mã đơn hàng: ', 'monamedia') ?>
                                            &nbsp;
                                            <span class="fw-6 c-pri"><?php echo ' #' . $order->get_order_number(); ?></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="pcart-info">

                                    <?php
                                    $bacs_accounts = get_option('woocommerce_bacs_accounts');
                                    if (is_array($bacs_accounts)) {
                                        foreach ($bacs_accounts as $key => $value) {
                                    ?>
                                            <div class="info-banking">
                                                <h2 class="fw-7 title"><?php _e('THÔNG TIN CHUYỂN KHOẢN', 'monamedia') ?></h2>
                                                <?php
                                                echo '<p class="text fw-5">' . esc_attr('Chủ tài khoản: ', 'woocommerce') .  esc_attr($value['account_name']) . '</p>';
                                                echo '<p class="text fw-5">' . esc_attr('Tên ngân hàng: ', 'woocommerce')  . esc_attr($value['bank_name']) . '</p>';
                                                echo '<p class="text fw-5">' . esc_attr('Số tài khoản: ', 'woocommerce')  . esc_attr($value['account_number']) . '</p>';
                                                ?>
                                            </div>

                                    <?php
                                        }
                                    } ?>

                                    <h2 class="fw-7 title"><?php _e('THÔNG TIN KHÁCH HÀNG', 'monamedia') ?></h2>
                                    <?php
                                    echo '<p class="text fw-5">' . esc_html($order->get_billing_first_name() . ' ' . $order->get_billing_last_name()) . '</p>';
                                    echo '<p class="text fw-5">' . esc_html($order->get_billing_phone()) . '</p>';
                                    echo '<p class="text fw-5">' . esc_html($order->get_billing_email()) . '</p>';
                                    echo '<p class="text fw-5">' . esc_html($order->get_billing_address_1()) . '</p>';
                                    ?>
                                </div>
                                <div class="pcart-suc-btn">
                                    <a class="btn btn-pri full" href="<?php echo home_url(); ?>">
                                        <span class="text">
                                            <?php _e('Tiếp tục mua sắm', 'monamedia') ?>
                                        </span>
                                        <span class="icon">
                                            <i class="fa-solid fa-arrow-right"></i>
                                        </span>
                                    </a>
                                </div>
                                <div class="pcart-suc-bot">
                                    <a class="link fw-5" href="mailto:cskh@curnonwatch.com"><?php _e('Cần trợ giúp?', 'monamedia') ?></a>
                                    <p class="text fw-5">
                                        <?php _e('Liên hệ', 'monamedia') ?>
                                        <a class="link fw-6 c-blue" href="mailto:cskh@curnonwatch.com"><?php _e('cskh@curnonwatch.com', 'monamedia') ?></a>
                                    </p>
                                </div>
                            </div>
                            <div class="pcart-right" data-aos="fade-left">
                                <div class="pcart-row">
                                    <h2 class="title fw-6 f-title"><?php _e('Sản Phẩm', 'moanmedia') ?>
                                        (<?php echo $order->get_item_count(); ?>)</h2>
                                    <div class="pcart-list">

                                        <?php
                                        $items = $order->get_items();
                                        if ($items) {
                                            foreach ($items as $item) {
                                                $product = $item->get_product();
                                                $product_name = $product->get_name();
                                                $product_id = $product->get_id();
                                                $quantity = $item->get_quantity();
                                                $subtotal = wc_price($item->get_subtotal());
                                                $product_url = get_permalink($product_id);

                                        ?>
                                                <div class="pcart-item">
                                                    <div class="pcart-img">
                                                        <a class="box" href="<?php echo $product_url; ?>">
                                                            <?php
                                                            $attachment_id = $product->get_image_id();
                                                            echo wp_get_attachment_image($attachment_id, 'full');
                                                            ?>
                                                        </a>
                                                    </div>
                                                    <div class="pcart-desc">
                                                        <div class="pcart-desc-top">
                                                            <div class="pcart-name"><?php echo $product_name; ?></div>
                                                            <div class="pcart-remove">
                                                                <span class="icon"><i class="fa-light fa-xmark"></i></span>
                                                            </div>
                                                        </div>

                                                        <!-- Hiển thị giá trị của _select_content_ -->
                                                        <?php if (!empty($select_content)) : ?>
                                                            <div class="content-gift-product">
                                                                <p><strong><?php _e('Nội dung gói quà:', 'text-domain'); ?></strong>
                                                                    <?php echo esc_html($select_content); ?></p>
                                                            </div>
                                                        <?php endif; ?>

                                                        <div class="pcart-desc-bot">
                                                            <div class="pcart-item-quan">
                                                                <div class="quantity">
                                                                    <div class="quantity-count">
                                                                        <div class="count">
                                                                            <div class="count-btn count-minus">
                                                                                <i class="fas fa-minus icon"></i>
                                                                            </div>
                                                                            <input class="count-input" type="text" value="<?php echo $quantity; ?>" max="99" min="0" hidden="" />
                                                                            <p class="count-number" style="display: none;">
                                                                                <?php echo $quantity; ?>
                                                                            </p>
                                                                            <?php echo $quantity; ?>
                                                                            <div class="count-btn count-plus">
                                                                                <i class="fas fa-plus icon"></i>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="pcart-item-price">
                                                                <span class="current"><?php echo $subtotal; ?></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                        <?php
                                            }
                                        } else {
                                            echo 'Không có sản phẩm nào trong đơn đặt hàng.';
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="pcart-row">
                                    <div class="pcart-total">
                                        <div class="pcart-total-flex">
                                            <div class="text"><?php _e('Tạm tính', 'monamedia'); ?></div>
                                            <div class="fee"><?php $order_total = $order->get_subtotal();
                                                                $formatted_total = number_format($order_total, 3, '.', '');
                                                                echo wc_price($formatted_total);
                                                                ?></div>
                                        </div>

                                        <!-- coupon -->
                                        <?php
                                        $coupons = $order->get_items('coupon');
                                        if (!empty($coupons)) {
                                            foreach ($coupons as $item_id => $item) {
                                                // $coupon_name = $item->get_name();
                                                $coupon_amount = $item->get_discount();
                                        ?>
                                                <div class="pcart-total-flex">
                                                    <div class="text"><?php _e('Giảm giá', 'monamedia'); ?></div>
                                                    <div class="fee"> <?php
                                                                        echo '-' . wc_price($coupon_amount);
                                                                        ?></div>
                                                </div>

                                        <?php
                                            }
                                        }
                                        ?>

                                        <div class="pcart-total-flex">
                                            <div class="text"><?php _e('Phí giao hàng', 'monamedia'); ?></span>
                                            </div>
                                            <div class="fee">
                                                <?php
                                                $shipping_fee = $order->get_shipping_total();

                                                if ($shipping_fee == 0) {
                                                    echo 'Miễn phí';
                                                } else {
                                                    echo wc_price($shipping_fee);
                                                }
                                                ?>
                                            </div>
                                        </div>
                                        <div class="pcart-total-flex total">
                                            <div class="text"><?php _e('Tổng', 'monamedia'); ?></div>
                                            <div class="fee"><?php echo $order->get_formatted_order_total(); ?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php else : ?>

        <?php wc_get_template('checkout/order-received.php', array('order' => false)); ?>

    <?php endif; ?>
</div>