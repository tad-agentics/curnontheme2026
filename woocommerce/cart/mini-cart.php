<?php

/**
 * Mini-cart
 *
 * Contains the markup for the mini-cart, used by the cart widget.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/mini-cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 5.2.0
 */

defined('ABSPATH') || exit;
$accessory_by_item_cart = [];
// do_action('woocommerce_before_mini_cart');

?>
<?php if (!WC()->cart->is_empty()) : ?>
    <div class="cmini-list is-loading-group-2">

        <?php
        do_action('woocommerce_before_mini_cart_contents');

        foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
            $_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
            if ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key)) {
                $product_permalink = apply_filters('woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink($cart_item) : '', $cart_item, $cart_item_key);
                $variation_id = $cart_item['variation_id'];
                $variation_text = wc_get_formatted_variation(wc_get_product_variation_attributes($variation_id), true);
        ?>

                <div class="cmini-item">
                    <div class="cmini-img">
                        <div class="box">
                            <a href="<?php echo $product_permalink; ?>">
                                <?php echo apply_filters('woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key); ?>
                            </a>
                        </div>
                    </div>
                    <div class="cmini-desc">
                        <div class="cmini-desc-top">
                            <!-- category of product  -->
                            <?php $taxonomy = 'product_cat';
                            $primary_cat_id = get_post_meta($_product->id, '_yoast_wpseo_primary_' . $taxonomy, true);
                            if ($primary_cat_id) {
                                $primary_cat = get_term($primary_cat_id, $taxonomy);
                                if (isset($primary_cat->name)) ?>
                                <p class="cmini-name fw-6">
                                    <?php echo $primary_cat->name; ?>
                                </p>
                            <?php }  ?>

                            <p class="cmini-text t12 c-grey fw-5">
                                <?php echo apply_filters('woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key); ?>
                            </p>
                            <p class="cmini-text t12 c-grey fw-5">
                                <?php echo $variation_text; ?>
                            </p>
                            <?php  if ($cart_item['mona_data']['select_gift'] === 'on') { ?>
                            <div class="content-gift-product">
                                <?php if (!empty($cart_item['mona_data']['select_content'])) {
                                    echo '<p class="cmini-text t12 c-grey fw-5"><strong>Nội dung gói quà:</strong> ' . esc_html($cart_item['mona_data']['select_content']) . '<strong> - Miễn phí</strong></p>';
                                } else {
                                    echo '<p class="cmini-text t12 c-grey fw-5"><strong>Thiệp không nội dung, gói quà và thắt nơ<strong> - Miễn phí</strong></p></p>';
                                } ?>
                            </div>
                        <?php }?>

                        </div>
                        <div class="cmini-desc-bot">
                            <div class="cmini-quan fw-6">
                                <?php echo $cart_item['quantity']; ?>
                            </div>

                            <div class="cmini-price">
                                <?php echo WC()->cart->get_product_price($_product); ?>
                            </div>
                        </div>
                    </div>
                </div>

        <?php
            }
        }
        do_action('woocommerce_mini_cart_contents');
        ?>

    </div>
<?php
// do_action('woocommerce_after_mini_cart'); 
else :
    get_template_part('woocommerce/cart/cart-empty');
endif;
?>