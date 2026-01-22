<?php

/**
 * Orders
 *
 * Shows orders on the account page.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/orders.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.8.0
 */

defined('ABSPATH') || exit;

do_action('woocommerce_before_account_orders', $has_orders); ?>

<div class="acc-bill">
    <div class="acc-bill-list">

        <?php
        // Lấy ID của người dùng hiện tại
        $user_id = get_current_user_id();

        // Lấy danh sách đơn đặt hàng của người dùng
        $orders = wc_get_orders(array(
            'customer' => $user_id,
        ));

        if ($orders) {
            foreach ($orders as $order) {
                $order_id = $order->get_id();
                $order_date = $order->get_date_created()->format('m/Y');
                $order_total = wc_price($order->get_total());
                $order_status = $order->get_status();
                $order_items = $order->get_items();

        ?>

                <div class="acc-bill-item">
                    <div class="acc-bill-top">
                        <span class="text f-title fw-6"><?php echo esc_html($order_date); ?></span>
                        <span class="text f-title fw-6"><?php echo $order_total; ?></span>
                    </div>
                    <div class="acc-bill-desc">
                        <div class="acc-bill-box">
                            <div class="acc-info">
                                <div class="acc-info-left">
                                    <p class="text">
                                        <?php _e('Đơn hàng: ', 'monamedia') ?>
                                        <span class="fw-6 code">
                                            #<?php echo $order_id; ?>
                                        </span>

                                        <?php if ($order_status == 'processing') { ?>
                                            <span class="status cbh">
                                                <?php _e('Đang chuẩn bị hàng', 'monamedia'); ?>
                                            </span>
                                        <?php } elseif ($order_status == 'completed') { ?>
                                            <span class="status dg">
                                                <?php _e('Hoàn thành', 'monamedia'); ?>
                                            </span>
                                        <?php } else { ?>
                                            <span class="status dh">
                                                <?php _e('Đã hủy', 'monamedia'); ?>
                                            </span>
                                        <?php } ?>

                                    </p>
                                </div>
                                <div class="acc-info-right">
                                    <span class="text fw-5"><?php echo esc_html($order->get_date_created()->format('h:i A, d/m/Y')); ?></span>
                                </div>
                            </div>

                            <?php
                            // Duyệt qua từng sản phẩm trong đơn đặt hàng
                            foreach ($order_items as $item_id => $item) {
                                $product = $item->get_product();
                                $product_name = $product->get_name();
                                $quantity = $item->get_quantity();
                                $subtotal = wc_price($item->get_total());
                                $product_id = $product->get_id();

                            ?>
                                <div class="pcart-item">
                                    <div class="pcart-img">
                                        <a class="box" href="<?php echo esc_url(get_permalink($product->get_id())); ?>">
                                            <?php echo wp_get_attachment_image($product->get_image_id(), 'full'); ?>
                                        </a>
                                    </div>
                                    <div class="pcart-desc">
                                        <div class="pcart-desc-top">
                                            <div class="pcart-name">

                                                <?php echo esc_html($product_name); ?>

                                                <!-- category of product  -->
                                                <?php $taxonomy = 'product_cat';
                                                $primary_cat_id = get_post_meta($product_id, '_yoast_wpseo_primary_' . $taxonomy, true);

                                                if ($primary_cat_id) {
                                                    $primary_cat = get_term($primary_cat_id, $taxonomy);
                                                    $primary_cat_link = get_term_link($primary_cat, $taxonomy);
                                                    if (isset($primary_cat->name)) ?>
                                                    <a href="<?php echo $primary_cat_link; ?>" class="attr">
                                                        <?php
                                                        echo $primary_cat->name;
                                                        ?>
                                                    </a>
                                                <?php }  ?>

                                            </div>
                                        </div>
                                        <div class="pcart-desc-bot">
                                            <div class="pcart-item-quan">
                                                <span class="text fw-6">x<?php echo esc_html($quantity); ?></span>
                                            </div>
                                            <div class="pcart-item-price">
                                                <span class="current"><?php echo $subtotal; ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>

        <?php
            }
        } else {
            // Hiển thị thông báo nếu không có đơn đặt hàng
            echo '<p>' . __('Không có đơn đặt hàng nào.', 'text-domain') . '</p>';
        }
        ?>
    </div>
</div>

<?php do_action('woocommerce_after_account_orders', $has_orders); ?>