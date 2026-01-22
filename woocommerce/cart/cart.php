<?php

/**
 * Cart Page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.4.0
 */

defined('ABSPATH') || exit;

do_action('woocommerce_before_cart'); ?>

<form class="woocommerce-cart-form" action="<?php echo esc_url(wc_get_cart_url()); ?>" method="post">
    <div class="banner">
        <div class="container">
            <div class="banner-inner">
                <div class="banner-dc"> <img src="<?php echo esc_url(get_site_url()); ?>/template/assets/images/pattern.png" alt="" />
                </div>
                <?php get_template_part('partials/breadcrumb'); ?>

                <p class="tt" data-aos="fade-right" data-aos-delay="500">
                    <?php echo the_title(); ?>
                </p>
            </div>
        </div>
    </div>

    <?php do_action('woocommerce_before_cart_table'); ?>
    <div class="c woocommerce-cart-form__contents">

        <section class="ck ss-pd">
            <div class="container">
                <div class="ck-flex row">
                    <div class="ck-left col col-8">
                        <div class="inner">
                            <table>
                                <thead>
                                    <tr>
                                        <th>PRODUCT</th>
                                        <th>PRICE</th>
                                        <th>QUANTITY</th>
                                        <th>TOTAL</th>
                                        <th> </th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php do_action('woocommerce_before_cart_contents'); ?>

                                    <?php
                                    if (!empty(WC()->cart->get_cart())) {
                                        $percent_sale = "";
                                        foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
                                            $_product   = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
                                            $product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);
                                            $product = wc_get_product($product_id);
                                            $percent_sale = get_field('sale_price_product', $product_id);

                                            // var_dump($cart_item['mona_data']);
                                            if (!empty($cart_item['mona_data']['role']) && $cart_item['mona_data']['role'] == 'root') {

                                                if ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_cart_item_visible', true, $cart_item, $cart_item_key)) {
                                                    $product_permalink = apply_filters('woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink($product_id) : '', $cart_item, $cart_item_key);
                                    ?>

                                                    <tr class="c-item woocommerce-cart-form__cart-item <?php echo esc_attr(apply_filters('woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key)); ?>">

                                                        <td data-label="PRODUCT">
                                                            <div class="ck-item">
                                                                <div class="img">
                                                                    <?php echo apply_filters('woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key); ?>
                                                                </div>
                                                                <span class="txt">
                                                                    <?php echo apply_filters('woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key); ?>
                                                                </span>
                                                            </div>
                                                        </td>

                                                        <td data-label="PRICE">
                                                            <?php
                                                            echo apply_filters('woocommerce_cart_item_price', WC()->cart->get_product_price($_product), $cart_item, $cart_item_key); // PHPCS: XSS ok. 
                                                            ?>
                                                        </td>

                                                        <td data-label="QUANTITY">
                                                            <?php
                                                            if ($_product->is_sold_individually()) {
                                                                $product_quantity = sprintf('1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key);
                                                            } else {
                                                                $product_quantity = woocommerce_quantity_input(
                                                                    array(
                                                                        'input_name'   => "cart[{$cart_item_key}][qty]",
                                                                        'input_value'  => $cart_item['quantity'],
                                                                        'max_value'    => '99999',
                                                                        'min_value'    => '0',
                                                                        'product_name' => $_product->get_name(),
                                                                    ),
                                                                    $_product,
                                                                    false
                                                                );
                                                            }
                                                            echo apply_filters('woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item);
                                                            ?>
                                                        </td>

                                                        <td data-label="TOTAL">
                                                            <?php echo apply_filters('woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal($_product, $cart_item['quantity']), $cart_item, $cart_item_key);   ?>
                                                        </td>

                                                        <td>
                                                            <?php
                                                            echo apply_filters(
                                                                'woocommerce_cart_item_remove_link',
                                                                sprintf(
                                                                    '<a href="%s" class="del" aria-label="%s" data-product_id="%s" data-product_sku="%s"><i class="fa-solid fa-xmark"> </i></a>',
                                                                    esc_url(wc_get_cart_remove_url($cart_item_key)),
                                                                    esc_html__('Remove this item', 'woocommerce'),
                                                                    esc_attr($product_id),
                                                                    esc_attr($_product->get_sku())
                                                                ),
                                                                $cart_item_key
                                                            );
                                                            ?>
                                                        </td>
                                                    </tr>

                                                <?php
                                                } else { ?>

                                                    <tr class="c-item woocommerce-cart-form__cart-item <?php echo esc_attr(apply_filters('woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key)); ?>">

                                                        <td data-label="PRODUCT">
                                                            <div class="ck-item">
                                                                <div class="img">
                                                                    <?php echo apply_filters('woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key); ?>
                                                                </div>
                                                                <span class="txt">
                                                                    <?php echo apply_filters('woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key); ?>
                                                                </span>
                                                            </div>
                                                        </td>

                                                        <td data-label="PRICE">
                                                            <?php
                                                            echo apply_filters('woocommerce_cart_item_price', WC()->cart->get_product_price($_product), $cart_item, $cart_item_key); // PHPCS: XSS ok. 
                                                            ?>
                                                        </td>

                                                        <td data-label="QUANTITY">
                                                            <?php
                                                            if ($_product->is_sold_individually()) {
                                                                $product_quantity = sprintf('1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key);
                                                            } else {
                                                                $product_quantity = woocommerce_quantity_input(
                                                                    array(
                                                                        'input_name'   => "cart[{$cart_item_key}][qty]",
                                                                        'input_value'  => $cart_item['quantity'],
                                                                        'max_value'    => '99999',
                                                                        'min_value'    => '0',
                                                                        'product_name' => $_product->get_name(),
                                                                    ),
                                                                    $_product,
                                                                    false
                                                                );
                                                            }
                                                            echo apply_filters('woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item);
                                                            ?>
                                                        </td>

                                                        <td data-label="TOTAL">
                                                            <?php echo apply_filters('woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal($_product, $cart_item['quantity']), $cart_item, $cart_item_key);   ?>
                                                        </td>

                                                        <td>
                                                            <?php
                                                            echo apply_filters(
                                                                'woocommerce_cart_item_remove_link',
                                                                sprintf(
                                                                    '<a href="%s" class="del" aria-label="%s" data-product_id="%s" data-product_sku="%s"><i class="fa-solid fa-xmark"> </i></a>',
                                                                    esc_url(wc_get_cart_remove_url($cart_item_key)),
                                                                    esc_html__('Remove this item', 'woocommerce'),
                                                                    esc_attr($product_id),
                                                                    esc_attr($_product->get_sku())
                                                                ),
                                                                $cart_item_key
                                                            );
                                                            ?>
                                                        </td>
                                                    </tr>

                                                <?php }
                                            } else { ?>

                                                <tr class="c-item woocommerce-cart-form__cart-item <?php echo esc_attr(apply_filters('woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key)); ?>">

                                                    <td data-label="PRODUCT">
                                                        <div class="ck-item">
                                                            <div class="img">
                                                                <?php echo apply_filters('woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key); ?>
                                                            </div>
                                                            <span class="txt">
                                                                <?php echo apply_filters('woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key); ?>
                                                            </span>
                                                        </div>
                                                    </td>

                                                    <td data-label="PRICE">
                                                        <?php
                                                        echo apply_filters('woocommerce_cart_item_price', WC()->cart->get_product_price($_product), $cart_item, $cart_item_key); // PHPCS: XSS ok. 
                                                        ?>
                                                    </td>

                                                    <td data-label="QUANTITY">
                                                        <?php
                                                        if ($_product->is_sold_individually()) {
                                                            $product_quantity = sprintf('1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key);
                                                        } else {
                                                            $product_quantity = woocommerce_quantity_input(
                                                                array(
                                                                    'input_name'   => "cart[{$cart_item_key}][qty]",
                                                                    'input_value'  => $cart_item['quantity'],
                                                                    'max_value'    => '99999',
                                                                    'min_value'    => '0',
                                                                    'product_name' => $_product->get_name(),
                                                                ),
                                                                $_product,
                                                                false
                                                            );
                                                        }
                                                        echo apply_filters('woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item);
                                                        ?>
                                                    </td>

                                                    <td data-label="TOTAL">
                                                        <?php echo apply_filters('woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal($_product, $cart_item['quantity']), $cart_item, $cart_item_key);   ?>
                                                    </td>

                                                    <td>
                                                        <?php
                                                        echo apply_filters(
                                                            'woocommerce_cart_item_remove_link',
                                                            sprintf(
                                                                '<a href="%s" class="del" aria-label="%s" data-product_id="%s" data-product_sku="%s"><i class="fa-solid fa-xmark"> </i></a>',
                                                                esc_url(wc_get_cart_remove_url($cart_item_key)),
                                                                esc_html__('Remove this item', 'woocommerce'),
                                                                esc_attr($product_id),
                                                                esc_attr($_product->get_sku())
                                                            ),
                                                            $cart_item_key
                                                        );
                                                        ?>
                                                    </td>
                                                </tr>

                                    <?php }
                                        }
                                        do_action('woocommerce_cart_contents');
                                    } else {
                                        get_template_part('woocommerce/cart/cart-empty');
                                    }
                                    ?>

                                </tbody>
                            </table>
                        </div>
                    </div>



                    <div class="ck-right col col-4">
                        <div class="inner">
                            <?php do_action('woocommerce_before_cart_totals'); ?>
                            <div class="mcart-block">
                                <div class="mcart-details-tt">Cart Total</div>
                                <div class="mcart-block-box">
                                    <div class="mcart-block-line">
                                        <span class="name" style="font-weight: 700;">
                                            Subtotal
                                        </span>
                                        <span class="val">
                                            <?php echo wc_price(WC()->cart->cart_contents_total); ?>
                                        </span>
                                    </div>

                                    <!-- coupon -->
                                    <?php foreach (WC()->cart->get_coupons() as $code => $coupon) : ?>

                                        <div class="mcart-block-line cart-discount coupon-<?php echo esc_attr(sanitize_title($code)); ?>">
                                            <!-- <span class="c-white"><?php wc_cart_totals_coupon_label($coupon); ?></span> -->
                                            <span class="name">
                                                Discounts [<?php wc_cart_totals_coupon_label($coupon); ?>]
                                            </span>
                                            <span class="val">
                                                <?php wc_cart_totals_coupon_html($coupon); ?>
                                            </span>
                                        </div>

                                    <?php endforeach; ?>


                                    <!-- shipping  -->
                                    <?php if (WC()->cart->needs_shipping() && WC()->cart->show_shipping()) : ?>

                                        <?php do_action('woocommerce_review_order_before_shipping'); ?>

                                        <div class="mcart-block-box bold">
                                            <div class="mcart-block-line">
                                                <?php echo wc_cart_totals_shipping_html(); ?>
                                            </div>
                                        </div>


                                        <?php do_action('woocommerce_review_order_after_shipping'); ?>

                                    <?php endif; ?>

                                    <!-- <div class="mcart-block-line"> <span class="name">Taxes </span><span class="val">$26.00</span></div> -->
                                </div>
                                <a class="btn noic" href="<?php echo site_url('checkout/'); ?>">
                                    <span class="txt">
                                        Checkout
                                    </span>
                                </a>
                            </div>
                            <?php do_action('woocommerce_after_cart_totals'); ?>

                            <?php if (wc_coupons_enabled()) { ?>
                                <div class="coupon">

                                    <input type="text" name="coupon_code" class="f-control re-input" id="coupon_code" value="" placeholder="<?php esc_attr_e('Coupon code', 'woocommerce'); ?>" placeholder="Code" />
                                    <button type="submit" class="app c-side-gg-btn" name="apply_coupon" value="<?php esc_attr_e('Apply coupon', 'woocommerce'); ?>">
                                        <?php esc_attr_e('Apply', 'woocommerce'); ?>
                                    </button>
                                    <?php do_action('woocommerce_cart_coupon'); ?>

                                </div>
                            <?php } ?>

                            <a class="btn second" href="<?php echo site_url('product/'); ?>"><span class="txt">
                                    Countinue Shoping
                                </span>
                            </a>

                            <button type="submit" style="display: none;" class="button<?php echo esc_attr(wc_wp_theme_get_element_class_name('button') ? ' ' . wc_wp_theme_get_element_class_name('button') : ''); ?>" name="update_cart" value="<?php esc_attr_e('Update cart', 'woocommerce'); ?>"><?php esc_html_e('Update cart', 'woocommerce'); ?></button>
                            <?php do_action('woocommerce_cart_actions'); ?>

                            <?php wp_nonce_field('woocommerce-cart', 'woocommerce-cart-nonce'); ?>

                            <a class="btn noic mona-submit-cart">
                                <span class="txt">
                                    <?php _e('Update Cart', 'monamedia'); ?>
                                </span>
                            </a>


                        </div>
                    </div>

                    <div class="cartod-right" style="display: none;">
                        <div class="cartod-dt">
                            <?php do_action('woocommerce_cart_actions'); ?>

                            <?php wp_nonce_field('woocommerce-cart', 'woocommerce-cart-nonce'); ?>

                            <?php do_action('woocommerce_after_cart_contents'); ?>

                            <?php do_action('woocommerce_before_cart_collaterals'); ?>

                            <div class="cart-collaterals">
                                <?php
                                /**
                                 * Cart collaterals hook.
                                 *
                                 * @hooked woocommerce_cross_sell_display
                                 * @hooked woocommerce_cart_totals - 10
                                 */
                                do_action('woocommerce_cart_collaterals');
                                ?>
                            </div>
                        </div>
                    </div>

                </div>
                <p class="note"><span class="red">* </span>The price is inclusive of VAT and does not include shipping
                    costs. To our mark.</p>
            </div>
        </section>

        <?php do_action('woocommerce_after_cart_table'); ?>

    </div>

    <!-- SubriceForm  -->
    <?php
    get_template_part('partials/global/SubcribeForm');
    ?>

</form>

<?php do_action('woocommerce_before_cart_collaterals'); ?>

<?php do_action('woocommerce_after_cart'); ?>