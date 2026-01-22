<?php

/**
 * Order details
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/order/order-details.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.8.0
 */

defined('ABSPATH') || exit;

$order = wc_get_order($order_id); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited

if (!$order) {
    return;
}

$order_items           = $order->get_items(apply_filters('woocommerce_purchase_order_item_types', 'line_item'));
$show_purchase_note    = $order->has_status(apply_filters('woocommerce_purchase_note_order_statuses', array('completed', 'processing')));
$show_customer_details = is_user_logged_in() && $order->get_user_id() === get_current_user_id();
$downloads             = $order->get_downloadable_items();
$show_downloads        = $order->has_downloadable_item() && $order->is_download_permitted();

if ($show_downloads) {
    wc_get_template(
        'order/order-downloads.php',
        array(
            'downloads'  => $downloads,
            'show_title' => true,
        )
    );
}
?>
<div class="mcart-block">

    <section class="woocommerce-order-details">

        <?php
        do_action('woocommerce_order_details_before_order_table', $order);
        ?>

        <div class="mcart-details-tt">
            Your Order
        </div>
        <!-- <h2 class="woocommerce-order-details__title"><?php esc_html_e('Order details', 'woocommerce'); ?></h2> -->

        <div class="mcart-block-box">

            <?php
            $order_items = $order->get_items();
            foreach ($order_items as $item_id => $item) {
                $product = $item->get_product();
                $product_name = $product->get_name();
                $product_price = $product->get_price();
                $product_quantity = $item->get_quantity();
            ?>

                <div class="mcart-block-line">
                    <span class="name">
                        <?php echo $product_name . ' x ' . $product_quantity; ?>
                    </span>
                    <span class="val">
                        <?php echo wc_price($product_price);  ?>
                    </span>
                </div>

            <?php
            }
            ?>

        </div>
        <div class="mcart-block-box bold">
            <div class="mcart-block-line">
                <span class="name">
                    Sub Total
                </span>
                <span class="val">
                    <?php
                    $sub_total = $order->get_subtotal();
                    echo wc_price($sub_total); ?>
                </span>
            </div>
        </div>

        <!-- coupon -->
        <?php
        $coupons = $order->get_items('coupon');
        if (!empty($coupons)) {
            foreach ($coupons as $item_id => $item) {
                // $coupon_name = $item->get_name();
                $coupon_amount = $item->get_discount();
        ?>
                <div class="mcart-block-box bold">
                    <div class="mcart-block-line">
                        <span class="name">
                            Discounts
                        </span>
                        <span class="val">
                            <?php
                            echo '-' . wc_price($coupon_amount);
                            ?>
                        </span>
                    </div>
                </div>
        <?php
            }
        }
        ?>

        <div class="mcart-block-box bold">
            <div class="mcart-block-line">
                <span class="name">
                    Shipping
                </span>
                <span class="val">
                    <?php
                    $shipping_total = $order->get_shipping_total();
                    echo wc_price($shipping_total); ?>
                </span>
            </div>
        </div>

        <div class="mcart-block-box bold">
            <div class="mcart-block-line">
                <span class="name">
                    Total
                </span>
                <span class="val blue">
                    <?php echo $order->get_formatted_order_total(); ?>
                </span>
            </div>
        </div>

        <?php do_action('woocommerce_order_details_after_order_table', $order); ?>

    </section>


    <?php
    /**
     * Action hook fired after the order details.
     *
     * @since 4.4.0
     * @param WC_Order $order Order data.
     */
    do_action('woocommerce_after_order_details', $order);

    if ($show_customer_details) {
        wc_get_template('order/order-details-customer.php', array('order' => $order));
    }
    ?>
</div>