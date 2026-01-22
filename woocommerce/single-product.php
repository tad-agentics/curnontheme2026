<?php

/**
 * The Template for displaying all single products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     1.6.4
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
get_header('shop');

global $post;
$product_id     = $post->ID;
$product_obj  = wc_get_product($product_id);
$product_type = $product_obj->get_type();

while (have_posts()) :
    the_post();
    do_action('woocommerce_before_single_product');
    if (post_password_required()) {
        echo get_the_password_form(); // WPCS: XSS ok.
        return;
    }
    $percent_sale = get_field('sale_price_product', $product_id);

    $mona_product = new MonaProductClass();
    if ($product_obj->is_type('variable')) {
        $variation_ids = $product_obj->get_children();
        if (count($variation_ids) > 0) {
            $variation_id = reset($variation_ids);
            $_product = new WC_Product_Variation($variation_id);
            if ($product_obj->get_price() == 0) {
                $price_html = '<p class="price-new">' . __('Liên hệ', 'monamedia') . '</p>';
            } else {

                $price_html = $mona_product->price_single_variation_html($product_obj);
                $percent_sale = m_get_percent_sale($_product);
            }
        }
    } else {
        if ($product_obj->get_price() == 0) {
            $price_html = '<p class="price-new">' . __('Liên hệ', 'monamedia') . '</p>';
        } else {
            $price_html = $product_obj->get_price_html();
            $percent_sale = m_get_percent_sale($product_obj);
        }
    }

    if ($product_type == 'variable') {
        $default_attributes = $product_obj->get_default_attributes();
        if (!empty($default_attributes)) {
            $default_attributes_offcial = [];
            foreach ($default_attributes as $key_default_attribute => $default_attribute) {
                $default_attributes_offcial['attribute_' . $key_default_attribute] = $default_attribute;
            }
            $default_variation_id = MonaProductVariations::findVariationId($product_id, $default_attributes_offcial);
        } else {
            $default_variation_id = $product_id;
        }
    }

    $cls = m_get_active_wishlist($product_id);
    if ($cls == "") {
        $cls = "m_add_login";
    }
?>
    <main class="main page-template">
        <div class="pdp">
            <div class="pdp-wrap">
                <div class="container">
                    <div class="pdp-inner">

                        <?php get_template_part('partials/breadcrumb'); ?>

                        <div class="pdp-flex">

                            <!-- gallery  -->
                            <div class="pdp-left" id="monaGalleryProduct">

                                <?php $productId = $product_type == 'variable' ? $default_variation_id : $product_id;
                                echo (new MonaProductClass())->GalleryProduct($productId); ?>

                            </div>

                            <div class="pdp-right">

                                <!-- info product  -->
                                <form id="frmAddProduct">
                                    <?php wp_nonce_field('mona_ajax_nonce', 'mona_nonce'); ?>
                                    <input type="hidden" name="product_id" value="<?php echo absint($product_id); ?>">
                                    <div class="pdp-right-ctn">
                                        <div class="pdp-op">
                                            <p class="fw-5 c-grey">
                                                <!-- category of product  -->
                                                <?php
                                                $taxonomy = 'product_cat';
                                                $primary_cat_id = get_post_meta($product_id, '_yoast_wpseo_primary_' . $taxonomy, true);
                                                if ($primary_cat_id) {
                                                    $primary_cat = get_term($primary_cat_id, $taxonomy);
                                                    if (isset($primary_cat->name)) {
                                                        echo esc_html($primary_cat->name);
                                                    }
                                                }
                                                ?>
                                            </p>
                                            <h1 class="pdp-name f-title fw-7"><?php echo esc_html($product_obj->get_title()); ?></h1>

                                            <div class="pdp-star">
                                                <div class="star">
                                                    <div class="star-list">
                                                        <div class="star-flex star-empty"><img class="icon" src="<?php echo esc_url(get_site_url()); ?>/template/assets/images/Star-fill.svg" alt="" /><img class="icon" src="<?php echo esc_url(get_site_url()); ?>/template/assets/images/Star-fill.svg" alt="" /><img class="icon" src="<?php echo esc_url(get_site_url()); ?>/template/assets/images/Star-fill.svg" alt="" /><img class="icon" src="<?php echo esc_url(get_site_url()); ?>/template/assets/images/Star-fill.svg" alt="" /><img class="icon" src="<?php echo esc_url(get_site_url()); ?>/template/assets/images/Star-fill.svg" alt="" /></div>
                                                        <div class="star-flex star-filter" style="width: 100%;"><img class="icon" src="<?php echo esc_url(get_site_url()); ?>/template/assets/images/Star.svg" alt="" /><img class="icon" src="<?php echo esc_url(get_site_url()); ?>/template/assets/images/Star.svg" alt="" /><img class="icon" src="<?php echo esc_url(get_site_url()); ?>/template/assets/images/Star.svg" alt="" /><img class="icon" src="<?php echo esc_url(get_site_url()); ?>/template/assets/images/Star.svg" alt="" /><img class="icon" src="<?php echo esc_url(get_site_url()); ?>/template/assets/images/Star.svg" alt="" /></div>
                                                    </div>
                                                </div>
                                                <span class="fw-5">
                                                    4.8
                                                </span>
                                                <a class="link-re" href="#sreview">See review</a>
                                            </div>

                                            <div class="pdp-price">
                                                <div class="pdp-price-left" id="monaPriceProduct">

                                                    <?php
                                                    $productId = $product_type == 'variable' ? $default_variation_id : $product_id;
                                                    echo (new MonaProductClass())->PriceProduct($productId);
                                                    ?>

                                                </div>

                                                <?php if ($product_obj->get_stock_status() == 'outofstock') { ?>
                                                    <div class="check-stock">
                                                        <p class="text"><?php _e('Tạm hết hàng!', 'monamedia'); ?></p>
                                                    </div>
                                                <?php } ?>

                                            </div>


                                        </div>

                                        <div class="pdp-op ctr">
                                            <div class="pdp-ch-flex">
                                                <div class="pdp-ch-left" id="monaAttriColor">
                                                    <!-- variation  -->
                                                    <?php if ($product_obj->get_type() == 'variable') { ?>
                                                        <?php echo (new MonaProductVariationsSingle())::setProId(get_the_ID())->Variations_html(); ?>
                                                    <?php } ?>
                                                    <div class="pdp-op-item gq">
                                                        <div class="pdp-op-flex">
                                                            <div class="pdp-op-left">
                                                                <span class="text fw-5">
                                                                    <?php _e('Gói quà:', 'monamedia') ?>
                                                                </span>
                                                            </div>
                                                            <div class="pdp-op-right">
                                                                <div class="pdp-gq pdp-gq-js">
                                                                    <select name="select_gift" class="re-select-main">
                                                                        <option value="">
                                                                            <?php _e('Lựa chọn', 'monamedia') ?>
                                                                        </option>
                                                                        <option value="WY"><span class="text">
                                                                                <?php _e('Thắt nơ + thiệp', 'monamedia') ?><span class="pri"><?php _e(' - Miễn phí', 'monamedia') ?></span></span>
                                                                        </option>
                                                                    </select>
                                                                    <div class="pdp-gq-text">
                                                                        <div class="ip-control">
                                                                            <textarea name="select_content" placeholder="Giới hạn 120 kí tự" type="text" required></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <?php
                                                $mona_relationship_address = get_field('mona_relationship_address', $product_id);
                                                $count = 10;
                                                if (!empty($mona_relationship_address)) {
                                                    $arg_posts = [
                                                        'post_type' => 'mona_dia_chi',
                                                        'post_status' => 'publish',
                                                        'posts_per_page' => $count,
                                                    ];
                                                    $arg_posts['orderby'] = 'post__in';
                                                    $arg_posts['post__in'] = $mona_relationship_address;
                                                }
                                                $loop_posts = new WP_Query($arg_posts);
                                                if ($loop_posts->have_posts()) :
                                                ?>
                                                    <div class="pdp-ch-right">
                                                        <div class="pdp-ch active-parent-js">
                                                            <div class="pdp-ch-top active-add-js">
                                                                <span class="text">
                                                                    <?php _e('Còn hàng', 'monamedia') ?>
                                                                </span>
                                                                <span class="icon"> <i class="fa-regular fa-angle-down"></i>
                                                                </span>
                                                            </div>
                                                            <div class="pdp-ch-ctn">
                                                                <p class="fw-7"><?php _e('CÒN HÀNG TẠI:', 'monamedia') ?></p>
                                                                <div class="pdp-ch-list">

                                                                    <div class="pdp-ch-item">
                                                                        <div class="icon"> <img src="<?php echo esc_url(get_site_url()); ?>/template/assets/images/location.svg" alt="" />
                                                                        </div>
                                                                        <div class="text">
                                                                            <?php while ($loop_posts->have_posts()) :
                                                                                global $post;
                                                                                $loop_posts->the_post();
                                                                                $link = get_field('mona_link_dia_chi', $post->ID);
                                                                            ?>
                                                                                <a class="link" href="<?php echo esc_url($link); ?>">
                                                                                    <?php echo get_the_title($post->ID); ?>
                                                                                </a>
                                                                            <?php endwhile;
                                                                            wp_reset_postdata(); ?>

                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>

                                            </div>
                                        </div>

                                        <div class="pdp-op ctr">
                                            <div class="pdp-op">

                                                <!-- sản phẩm quan tâm  -->
                                                <?php get_template_part('partials/product/ItemRelated'); ?>

                                                <div id="monaButtons">
                                                    <?php $productId = $product_type == 'variable' ? $default_variation_id : $product_id;
                                                    echo (new MonaProductClass())->AddToCartProduct($productId); ?>
                                                </div>

                                                <!-- danh sách ưu đãi pdp-poli -->
                                                <?php get_template_part('partials/global/DanhSachUuDai'); ?>

                                                <div class="pdp-fixed">
                                                    <div class="pdp-fixed-inner">
                                                        <!-- cart mobile  -->
                                                        <button class="btn btn-pri m-buy-now" type="submit">
                                                            <span class="text is-loading-group">
                                                                <?php _e('THANH TOÁN NGAY', 'monamedia') ?>
                                                            </span>
                                                        </button>

                                                        <!-- wishlist mobile  -->
                                                        <?php if (is_user_logged_in()) { ?>
                                                            <div class="pdp-control-wish <?php echo esc_attr($cls); ?>" data-key="<?php echo absint(get_the_ID()); ?>">
                                                                <span class="icon is-loading-group">
                                                                    <img src="<?php echo esc_url(get_site_url()); ?>/template/assets/images/icon-heart.svg" alt="" />

                                                                </span>
                                                            </div>
                                                        <?php } else { ?>
                                                            <a href="<?php echo site_url('dang-nhap/'); ?>" class="pdp-control-wish">
                                                                <span class="icon">
                                                                    <img src="<?php echo esc_url(get_site_url()); ?>/template/assets/images/icon-heart.svg" alt="" />
                                                                </span>
                                                            </a>
                                                        <?php } ?>

                                                    </div>
                                                </div>
                                            </div>

                                            <div class="pdp-info">
                                                <div class="pdp-info-top">
                                                    <span class="text fw-6"><?php _e('THÔNG TIN', 'monamedia') ?></span>
                                                </div>
                                                <div class="pdp-info-desc mona-content">
                                                    <?php the_content(); ?>
                                                </div>
                                            </div>

                                            <!-- thông tin vận chuyển pdp-more tabJS -->
                                            <?php get_template_part('partials/global/InfoShipping'); ?>

                                        </div>

                                    </div>
                                </form>

                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>

        <!-- RunText  -->
        <?php get_template_part('partials/global/RunText');  ?>

        <!-- review khách hàng  -->
        <?php
        $rp_review_pro = get_field('rp_review_pro');
        if ($rp_review_pro) : ?>
            <div class="sre" id="sreview">
                <div class="sre-wrap">
                    <div class="container">
                        <div class="sre-inner">
                            <div class="sre-top">
                                <div class="sre-top-flex">
                                    <div class="sre-top-left">
                                        <h2 class="fw-7 title f-title"><?php _e('REVIEWS CỦA KHÁCH HÀNG', 'monadia') ?></h2>
                                    </div>
                                    <div class="sre-top-right">
                                        <div class="sre-btn">
                                            <div class="swiper-button-next sre-btn-next"><i class="fa-solid fa-arrow-right"></i>
                                            </div>
                                            <div class="swiper-button-prev sre-btn-prev"><i class="fa-solid fa-arrow-left"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="sre-slide">
                                <div class="swiper sreSwiper">
                                    <div class="swiper-wrapper">
                                        <?php foreach ($rp_review_pro as $key => $item) : ?>
                                            <div class="swiper-slide">
                                                <div class="sre-item">
                                                    <div class="sre-box">
                                                        <div class="star">
                                                            <div class="star-list">
                                                                <div class="star-flex star-empty"><img class="icon" src="<?php echo esc_url(get_site_url()); ?>/template/assets/images/Star-fill.svg" alt="" /><img class="icon" src="<?php echo esc_url(get_site_url()); ?>/template/assets/images/Star-fill.svg" alt="" /><img class="icon" src="<?php echo esc_url(get_site_url()); ?>/template/assets/images/Star-fill.svg" alt="" /><img class="icon" src="<?php echo esc_url(get_site_url()); ?>/template/assets/images/Star-fill.svg" alt="" /><img class="icon" src="<?php echo esc_url(get_site_url()); ?>/template/assets/images/Star-fill.svg" alt="" /></div>
                                                                <div class="star-flex star-filter" style="width: <?php echo esc_attr(floatval($item['rating']) * 20); ?>%;"><img class="icon" src="<?php echo esc_url(get_site_url()); ?>/template/assets/images/Star.svg" alt="" /><img class="icon" src="<?php echo esc_url(get_site_url()); ?>/template/assets/images/Star.svg" alt="" /><img class="icon" src="<?php echo esc_url(get_site_url()); ?>/template/assets/images/Star.svg" alt="" /><img class="icon" src="<?php echo esc_url(get_site_url()); ?>/template/assets/images/Star.svg" alt="" /><img class="icon" src="<?php echo esc_url(get_site_url()); ?>/template/assets/images/Star.svg" alt="" /></div>
                                                            </div>
                                                        </div>
                                                        <div class="sre-desc mona-content">
                                                            <?php echo wp_kses_post($item['content']); ?>
                                                        </div>
                                                        <div class="sre-bot">
                                                            <div class="sre-name"><?php echo esc_html($item['fullname']); ?></div>
                                                            <div class="sre-date"><?php echo esc_html($item['date']); ?></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <!-- RECENTLY VIEWED -->
        <?php

        $args = array(
            'posts_per_page' => 10,
            'post_type'      => 'product',
            'post_status'    => 'publish',
            'post__not_in'   => array($product_id), // Loại bỏ sản phẩm hiện tại để tránh lặp lại
        );

        $query = new WP_Query($args);
        if ($query->have_posts()) : ?>

            <div class="spro spro-slide-js">
                <div class="spro-wrap">
                    <div class="spro-top">
                        <div class="container">
                            <div class="spro-top-flex">
                                <div class="spro-top-left">
                                    <div class="spro-title f-title fw-7"><?php _e('NEW PRODUCT', 'monamedia'); ?></div>
                                </div>
                                <div class="spro-top-right">
                                    <div class="spro-btn">
                                        <div class="swiper-button-next spro-btn-next"><i class="fa-solid fa-arrow-right"></i>
                                        </div>
                                        <div class="swiper-button-prev spro-btn-prev"><i class="fa-solid fa-arrow-left"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="spro-slide">
                        <div class="spro-slide-inner">
                            <div class="swiper sproSwiper">
                                <div class="swiper-wrapper">
                                    <?php while ($query->have_posts()) : $query->the_post(); ?>
                                        <div class="swiper-slide">
                                            <div class="pro-item">

                                                <?php get_template_part('partials/product/item');  ?>

                                            </div>
                                        </div>
                                    <?php
                                    endwhile;
                                    wp_reset_postdata();

                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- RECENTLY VIEWED -->
        <?php

        $args = array(
            'posts_per_page' => 10,
            'post_type'      => 'product',
            'post_status'    => 'publish',
            'ignore_sticky_posts'   => 1,
            'meta_key' => 'total_sales',
            'orderby' => 'meta_value_num',
            'order' => 'DESC',
            'post__not_in'   => array($product_id), // Loại bỏ sản phẩm hiện tại để tránh lặp lại
        );

        $query = new WP_Query($args);
        if ($query->have_posts()) : ?>

            <div class="spro spro-slide-js">
                <div class="spro-wrap">
                    <div class="spro-top">
                        <div class="container">
                            <div class="spro-top-flex">
                                <div class="spro-top-left">
                                    <div class="spro-title f-title fw-7"><?php _e('BEST SELLER PRODUCT', 'monamedia'); ?></div>
                                </div>
                                <div class="spro-top-right">
                                    <div class="spro-btn">
                                        <div class="swiper-button-next spro-btn-next"><i class="fa-solid fa-arrow-right"></i>
                                        </div>
                                        <div class="swiper-button-prev spro-btn-prev"><i class="fa-solid fa-arrow-left"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="spro-slide">
                        <div class="spro-slide-inner">
                            <div class="swiper sproSwiper">
                                <div class="swiper-wrapper">
                                    <?php while ($query->have_posts()) : $query->the_post(); ?>
                                        <div class="swiper-slide">
                                            <div class="pro-item">

                                                <?php get_template_part('partials/product/item');  ?>

                                            </div>
                                        </div>
                                    <?php
                                    endwhile;
                                    wp_reset_postdata();

                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- popup-sizeguide -->
        <!-- popup cỡ cổ tay  -->
        <?php get_template_part('partials/global/PopupSizeguide') ?>

    </main>
<?php
    do_action('woocommerce_after_single_product');
endwhile;
get_footer('shop');
