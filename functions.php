<?php

/**
 * The template for displaying index.
 *
 * @package Monamedia
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * define acf
 */
if (get_current_user_id() == 1) {
    define('ACF_LITE', false);
} else {
    define('ACF_LITE', true);
}

/**
 * define theme page
 */
define('MONA_HOME_URL', get_site_url());
define('MONA_HOME_DIR_URL', get_template_directory_uri());
define('MONA_PAGE_HOME', get_option('page_on_front', true));
define('MONA_PAGE_BLOG', get_option('page_for_posts', true));

define('MONA_PAGE_LOGIN', url_to_postid(get_the_permalink(53)));
define('MONA_PAGE_REGISTER', url_to_postid(get_the_permalink(55)));
define('MONA_PAGE_FORGOT', url_to_postid(get_the_permalink(57)));
define('MONA_PAGE_ABOUT', url_to_postid(get_the_permalink(86)));
define('MONA_URL', get_site_url() . '/template/assets/images/default-mona.png');

// Woocommerce
define('MONA_WC_PRODUCTS', get_option('woocommerce_shop_page_id'));
define('MONA_WC_CART', get_option('woocommerce_cart_page_id'));
define('MONA_WC_CHECKOUT', get_option('woocommerce_checkout_page_id'));
define('MONA_WC_MYACCOUNT', get_option('woocommerce_myaccount_page_id'));
define('MONA_WC_THANKYOU', get_option('woocommerce_thanks_page_id'));

require_once(get_template_directory() . '/__autoload.php');

function filter_woocommerce_cart_totals_coupon_html( $coupon_html, $coupon, $discount_amount_html ) {
    // Change text
    $coupon_html = $discount_amount_html . ' <a href="' . esc_url( 
        add_query_arg( 'remove_coupon', rawurlencode( $coupon->get_code() ),  wc_get_checkout_url() ) ) . '" class="woocommerce-remove-coupon" data-coupon="' . esc_attr( $coupon->get_code() ) . '">' . __( '[Xoá]', 'woocommerce' ) . '</a>';
    return $coupon_html;
}
add_filter( 'woocommerce_cart_totals_coupon_html', 'filter_woocommerce_cart_totals_coupon_html', 10, 3 );