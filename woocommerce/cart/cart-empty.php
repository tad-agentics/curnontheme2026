<?php

/**
 * Empty cart page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart-empty.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.0.1
 */

defined('ABSPATH') || exit;

/*
 * @hooked wc_empty_cart_message - 10
 */

do_action('woocommerce_cart_is_empty');
if (wc_get_page_id('shop') > 0) : ?>
    <div class="container">
        <div class="empty-product">
            <a class="image-empty-product" href="<?php echo get_permalink(MONA_WC_PRODUCTS); ?>">
                <img src="<?php echo esc_url(get_site_url()); ?>/template/assets/images/empty-cart-curnon.png" alt="this is a image of empty product">
            </a>
            <p class="text">
                <?php _e('Hiện tại, sản phẩm bạn tìm kiếm hiện đang cập nhật. Vui lòng quay lại sau hoặc liên hệ với chúng tôi.', 'monamedia'); ?>
            </p>
            <?php if (is_cart()) : ?>
                <a class="btn btn-pri" href="<?php echo get_permalink(MONA_WC_PRODUCTS); ?>">
                    <span class="text"> <?php _e('TIẾP TỤC MUA SẮM', 'monamedia') ?></span>
                </a>
            <?php endif; ?>
        </div>
    </div>

    <!-- <div class="fts">
    <a class="btn noic cart-chechout" href="<?php echo site_url('product/') ?>">
        <span class="txt">
            <?php _e('Go to shopping', 'monamedia'); ?>
        </span>
    </a>
</div> -->

<?php endif; ?>