<?php

/**
 * The template for displaying header.
 *
 * @package Monamedia
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) & !(IE 8)]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->

<head>
    <!-- Meta -->
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no, width=device-width">
    <?php wp_site_icon(); ?>
    <link rel="pingback" href="<?php echo esc_url(get_bloginfo('pingback_url')); ?>" />
    <?php wp_head(); ?>
</head>
<?php
if (wp_is_mobile()) {
    $body = 'mobile-detect';
} else {
    $body = 'desktop-detect';
} ?>

<body <?php body_class($body); ?>>
    <header class="header">
        <div class="header-wrapper">
            <div class="container">
                <div class="header-wrap">
                    <div class="header-burger">
                        <div class="hamburger" id="hamburger">
                            <img src="<?php echo esc_url(get_site_url()); ?>/template/assets/images/hamburger.svg" alt="" /><span class="icon-close">
                                <img src="<?php echo esc_url(get_site_url()); ?>/template/assets/images/close.png" alt="" /></span>
                        </div>
                    </div>
                    <div class="header-logo">
                        <div class="custom-logo-link" rel="home">
                            <?php echo get_custom_logo() ?>
                        </div>
                    </div>
                    <div class="header-logo-mobile">
                        <a href="<?php echo esc_url(home_url()); ?>" class="custom-logo-link" rel="home">

                            <?php $header_image_mobile_logo = mona_get_option('header_image_mobile_logo');
                            if ($header_image_mobile_logo) { ?>
                                <img src="<?php echo esc_url($header_image_mobile_logo); ?>">
                            <?php } ?>

                        </a>
                    </div>
                    <div class="header-gr">
                        <nav class="header-nav">
                            <div class="menu">
                                <div class="menu-nav">

                                    <!-- Frimary menu -->
                                    <?php
                                    wp_nav_menu(array(
                                        'container' => false,
                                        'container_class' => '',
                                        'menu_class' => 'menu-list',
                                        'theme_location' => 'primary-menu',
                                        'walker' => new Mona_Walker_Nav_Menu_Frimary,
                                    ));
                                    ?>

                                </div>
                            </div>
                        </nav>
                        <div class="header-control">

                            <!-- tìm kiếm  -->
                            <div class="header-btn-search header-action">
                                <div class="header-action-icon"><span class="icon"><img src="<?php echo esc_url(get_site_url()); ?>/template/assets/images/search.svg" alt="" /></span></div>
                            </div>

                            <!-- wishlist  -->
                            <?php if (is_user_logged_in()) { ?>
                                <div class="header-action">
                                    <a class="header-action-icon" href="<?php echo esc_url(site_url('tai-khoan/wish-list/')); ?>">
                                        <span class="icon">
                                            <img src="<?php echo esc_url(get_site_url()); ?>/template/assets/images/heart.svg" alt="" />
                                        </span>
                                    </a>
                                </div>
                            <?php } else {  ?>
                                <div class="header-action">
                                    <a class="header-action-icon" href="<?php echo esc_url(site_url('dang-nhap/')); ?>">
                                        <span class="icon">
                                            <img src="<?php echo esc_url(get_site_url()); ?>/template/assets/images/heart.svg" alt="" />
                                        </span>
                                    </a>
                                </div>
                            <?php }  ?>

                            <!-- login  -->
                            <?php if (!is_user_logged_in()) { ?>

                                <div class="header-action">
                                    <button class="header-action-icon popup-open" data-popup="popup-login">
                                        <span class="icon">
                                            <img src="<?php echo esc_url(get_site_url()); ?>/template/assets/images/user.svg" alt="" /></span>
                                    </button>
                                </div>

                            <?php } else { ?>

                                <div class="header-action">
                                    <button class="header-action-icon popup-open" data-popup="popup-login-2">
                                        <span class="icon">
                                            <img src="<?php echo esc_url(get_site_url()); ?>/template/assets/images/user.svg" alt="" /></span>
                                    </button>
                                </div>

                            <?php } ?>

                            <div class="header-action">
                                <!-- <div class="header-action-icon popup-open" id="popup-cart" data-popup="popup-cart"> -->
                                <a href="<?php echo esc_url(get_permalink(MONA_WC_CHECKOUT)); ?>" class="header-action-icon">
                                    <span class="icon">
                                        <img src="<?php echo esc_url(get_site_url()); ?>/template/assets/images/cart.svg" alt="" />
                                    </span>
                                    <span class="text num" id="mona-cart-qty">
                                        <?php echo absint(WC()->cart->get_cart_contents_count()); ?>
                                    </span>
                                </a>
                            </div>

                            <div class="header-action">
                                <div class="header-action-icon popup-open" id="popup-cart" data-popup="popup-cart">
                                    <!-- <a href="<?php //echo get_permalink(MONA_WC_CHECKOUT); 
                                                    ?>" class="header-action-icon"> -->
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="mobile-overlay"></div>

            <!-- header mobile version  -->
            <div class="mobile">
                <div class="mobile-con">
                    <div class="mobile-close"> <img src="<?php echo esc_url(get_site_url()); ?>/template/assets/images/close.png" alt="" />
                    </div>
                    <div class="mobile-wr">
                        <div class="mobile-nav">

                            <!-- Frimary menu -->
                            <?php wp_nav_menu(array(
                                'container' => false,
                                'container_class' => '',
                                'menu_class' => 'menu-list',
                                'theme_location' => 'mobile-menu',
                                'walker' => new Mona_Walker_Nav_Menu_Mobile,
                            ));

                            // nam 
                            $parent_cat_dong_ho_nam = get_term_by('slug', 'dong-ho-nam', 'product_cat');
                            $parent_cat_trang_suc_nam = get_term_by('slug', 'trang-suc-nam', 'product_cat');
                            $parent_cat_day_dong_ho = get_term_by('slug', 'day-dong-ho', 'product_cat');
                            $parent_cat_best_sellers = get_term_by('slug', 'best-sellers', 'product_cat');
                            $link_2_best_sellers = get_field('link_2_best_sellers', MONA_PAGE_HOME);

                            // nữ 
                            $parent_cat_dong_ho_nu = get_term_by('slug', 'dong-ho-nu', 'product_cat');
                            $parent_cat_trang_suc_nu = get_term_by('slug', 'trang-suc-nu', 'product_cat');
                            $parent_cat_day_dong_ho_nu = get_term_by('slug', 'day-dong-ho-nu', 'product_cat');
                            $parent_cat_best_sellers_nu = get_term_by('slug', 'best-sellers', 'product_cat');
                            $link_2_best_sellers_nu = get_field('link_2_best_sellers', MONA_PAGE_HOME);

                            // quà tặng 
                            $mona_tax_qua_tang = get_term_by('slug', 'qua-tang', 'product_cat');
                            ?>

                            <div class="mobile-nav-btn">
                                <a class="link" href="<?php site_url('nam/') ?>"><?php _e('SHOP ALL PRODUCTS', 'monamedia'); ?></a>
                            </div>
                        </div>
                    </div>

                    <!-- nam   -->
                    <div class="mobile-sub mobile-sub-js">
                        <a class="mobile-sub-pre">
                            <span class="icon">
                                <i class="fa-solid fa-arrow-left"></i>
                            </span>
                            <span class="text f-title">
                                <?php _e('NAM', 'monamedia') ?>
                            </span>
                        </a>
                        <div class="mobile-sub-ctn">

                            <!-- đồng hồ nam  -->
                            <?php if ($parent_cat_dong_ho_nam && is_object($parent_cat_dong_ho_nam)) {
                                $child_cats = get_terms([
                                    'taxonomy'   => 'product_cat',
                                    'parent'     => $parent_cat_dong_ho_nam->term_id,
                                    'hide_empty' => false,
                                ]);
                                if (!empty($child_cats) || isset($child_cats)) {  ?>
                                    <div class="mobile-sub-item">
                                        <div class="mobile-sub-item-top tech-item-head">
                                            <span class="text">
                                            <?php echo esc_html($parent_cat_dong_ho_nam->name); ?>
                                            </span>
                                            <a class="mobile-sub-link" href="<?php echo site_url('dong-ho/dong-ho-nam/'); ?>">
                                                <?php _e('SHOP ALL', 'monamedia') ?>
                                            </a>
                                        </div>
                                        <div class="mobile-sub-main tech-body">
                                            <div class="mega-dh-list">

                                                <?php foreach ($child_cats as $child_cat) {
                                                    $link_child_cat = get_term_link($child_cat);
                                                    $image_product_cat = get_term_meta($child_cat->term_id, 'thumbnail_id', true); ?>

                                                    <a class="mega-dh-item" href="<?php echo esc_url($link_child_cat); ?>">
                                                        <span class="mega-dh-img">
                                                            <?php echo wp_get_attachment_image($image_product_cat, 'full'); ?>
                                                        </span>
                                                        <span class="mega-dh-name">
                                                            <?php echo esc_html($child_cat->name); ?>
                                                        </span>
                                                    </a>

                                                <?php } ?>

                                            </div>
                                        </div>
                                    </div>
                            <?php }
                            } ?>

                            <?php if ($parent_cat_trang_suc_nam && is_object($parent_cat_trang_suc_nam)) {
                                $child_cats = get_terms([
                                    'taxonomy'   => 'product_cat',
                                    'parent'     => $parent_cat_trang_suc_nam->term_id,
                                    'hide_empty' => false,
                                ]);
                                if (!empty($child_cats) || isset($child_cats)) {  ?>
                                    <!-- trang sức nam  -->
                                    <div class="mobile-sub-item">
                                        <div class="mobile-sub-item-top tech-item-head"><span class="text">
                                                <?php echo esc_html($parent_cat_trang_suc_nam->name); ?>
                                            </span>
                                            <a class="mobile-sub-link" href="<?php echo site_url('trang-suc/trang-suc-nam'); ?>">
                                                <?php _e('SHOP ALL', 'monamedia') ?>
                                            </a>
                                        </div>
                                        <div class="mobile-sub-main tech-body">
                                            <div class="mega-ts-list">

                                                <?php foreach ($child_cats as $child_cat) {
                                                    $link_child_cat = get_term_link($child_cat);
                                                    $image_child_cat = get_term_meta($child_cat->term_id, 'thumbnail_id', true)
                                                ?>

                                                    <div class="mega-ts-item">
                                                        <div class="mega-ts-img">
                                                            <a class="box" href="<?php echo esc_url($link_child_cat); ?>">
                                                                <?php echo wp_get_attachment_image($image_child_cat, 'full'); ?>
                                                            </a>
                                                        </div>
                                                        <a class="mega-ts-name" href="<?php echo esc_url($link_child_cat); ?>"><?php echo esc_html($child_cat->name); ?></a>
                                                    </div>

                                                <?php } ?>

                                            </div>
                                        </div>
                                    </div>
                            <?php }
                            } ?>

                            <?php if ($parent_cat_day_dong_ho && is_object($parent_cat_day_dong_ho)) {
                                $child_cats = get_terms([
                                    'taxonomy'   => 'product_cat',
                                    'parent'     => $parent_cat_day_dong_ho->term_id,
                                    'hide_empty' => false,
                                ]);
                                if (!empty($child_cats) || isset($child_cats)) {  ?>
                                    <!-- dây đồng hồ   -->
                                    <div class="mobile-sub-item">
                                        <div class="mobile-sub-item-top tech-item-head"><span class="text">
                                                <?php echo esc_html($parent_cat_day_dong_ho->name); ?>
                                            </span>
                                            <a class="mobile-sub-link" href="<?php echo site_url('dong-ho/day-dong-ho-nam'); ?>">
                                                <?php _e('SHOP ALL', 'monamedia') ?>
                                            </a>
                                        </div>
                                        <div class="mobile-sub-main tech-body">
                                            <div class="swiper megaddhSwiper">
                                                <div class="swiper-wrapper">

                                                    <?php foreach ($child_cats as $child_cat) {
                                                        $link_child_cat = get_term_link($child_cat);
                                                        $image_child_cat = get_term_meta($child_cat->term_id, 'thumbnail_id', true)
                                                    ?>

                                                        <div class="swiper-slide">
                                                            <div class="mega-ddh-item">
                                                                <div class="mega-ddh-img">
                                                                    <a class="box" href="<?php echo esc_url($link_child_cat); ?>">
                                                                        <?php echo wp_get_attachment_image($image_child_cat, 'full'); ?>
                                                                    </a>
                                                                </div>
                                                                <a class="mega-ddh-name" href="<?php echo esc_url($link_child_cat); ?>"><?php echo esc_html($child_cat->name); ?></a>
                                                            </div>
                                                        </div>

                                                    <?php } ?>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            <?php }
                            } ?>

                            <?php if ($parent_cat_best_sellers && is_object($parent_cat_best_sellers)) {
                                $mona_hinh_anh_1_best_sellers = get_field('mona_hinh_anh_1_best_sellers', MONA_PAGE_HOME);
                                $tieu_de_1_best_sellers = get_field('tieu_de_1_best_sellers', MONA_PAGE_HOME);
                                $mona_hinh_anh_2_best_sellers = get_field('mona_hinh_anh_2_best_sellers', MONA_PAGE_HOME);
                                $tieu_de_2_best_sellers = get_field('tieu_de_2_best_sellers', MONA_PAGE_HOME);
                            ?>
                                <!-- best sellers   -->
                                <div class="mobile-sub-item">
                                    <div class="mobile-sub-item-top tech-item-head">
                                        <span class="text"><?php echo esc_html($tieu_de_1_best_sellers); ?></span><a class="mobile-sub-link" href="<?php echo esc_url(site_url('best-sellers')); ?>">
                                            <?php _e('SHOP ALL', 'monamedia') ?>
                                        </a>
                                    </div>
                                    <div class="mobile-sub-main tech-body">
                                        <div class="mega-bs-flex">
                                            <div class="mega-bs-left">
                                                <div class="mega-bs-img">
                                                    <div class="box">
                                                        <?php echo wp_get_attachment_image($mona_hinh_anh_1_best_sellers, 'full'); ?>
                                                    </div>
                                                    <span class="text">
                                                        <?php echo esc_html($tieu_de_1_best_sellers); ?>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="mega-bs-right">
                                                <div class="mega-bs-simg">
                                                    <div class="box">
                                                        <?php echo wp_get_attachment_image($mona_hinh_anh_2_best_sellers, 'full'); ?>
                                                    </div>
                                                </div>
                                                <div class="mega-bs-desc">
                                                    <span class="text"><?php echo esc_html($tieu_de_2_best_sellers); ?></span><a class="mega-bs-link" href="<?php echo esc_url(site_url('new-arrivals')); ?>"><?php _e('SHOP NOW', 'monamedia') ?></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>

                            <?php
                            $count = 4;
                            $args = array(
                                'post_type'      => 'product',
                                'post_status'    => 'publish',
                                'order' => 'DESC',
                                'posts_per_page' => $count,
                                'tax_query'     => array(
                                    array(
                                        'taxonomy' => 'product_visibility',
                                        'field'    => 'name',
                                        'terms'    => 'featured',
                                        'operator' => 'IN',
                                    ),
                                ),
                            );
                            $Query_Feature = new WP_Query($args);
                            if ($Query_Feature->have_posts()) {
                            ?>
                                <div class="mobile-sub-item">
                                    <div class="mobile-sub-item-top tech-item-head">
                                        <span class="text"><?php _e('New Arrivals', 'monamedia'); ?></span>
                                        <a class="mobile-sub-link" href="<?php echo site_url('new-arrivals'); ?>">
                                            <?php _e('SHOP ALL', 'monamedia') ?>
                                        </a>
                                    </div>
                                    <div class="mobile-sub-main tech-body">
                                        <div class="swiper megaNewSwiper">
                                            <div class="swiper-wrapper">

                                                <?php
                                                while ($Query_Feature->have_posts()) :
                                                    $Query_Feature->the_post();
                                                ?>

                                                    <div class="swiper-slide">

                                                        <?php get_template_part('partials/product/item');  ?>

                                                    </div>

                                                <?php
                                                endwhile;
                                                wp_reset_postdata();
                                                ?>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } else { ?>

                                <div class="container">
                                    <div class="empty-product">
                                        <a class="image-empty-product" href="<?php echo home_url(); ?>">
                                            <img src="<?php echo esc_url(get_site_url()); ?>/template/assets/images/empty-cart-curnon.png" alt="this is a image of empty product">
                                        </a>
                                        <p class="text">
                                            <?php _e('Hiện tại, sản phẩm bạn tìm kiếm hiện đang cập nhật. Vui lòng quay lại sau hoặc liên hệ với chúng tôi.', 'monamedia'); ?>
                                        </p>
                                        <?php if (is_cart()) : ?>
                                            <a class="btn btn-pri" href="<?php echo home_url(); ?>">
                                                <span class="text"> <?php _e('TIẾP TỤC MUA SẮM', 'monamedia') ?></span>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </div>

                            <?php } ?>
                        </div>
                    </div>

                    <!-- nu   -->
                    <div class="mobile-sub mobile-sub-js">
                        <a class="mobile-sub-pre">
                            <span class="icon">
                                <i class="fa-solid fa-arrow-left"></i>
                            </span>
                            <span class="text f-title">
                                <?php _e('NỮ', 'monamedia') ?>
                            </span>
                        </a>
                        <div class="mobile-sub-ctn">

                            <!-- đồng hồ nu  -->
                            <?php if ($parent_cat_dong_ho_nu && is_object($parent_cat_dong_ho_nu)) {
                                $child_cats = get_terms([
                                    'taxonomy'   => 'product_cat',
                                    'parent'     => $parent_cat_dong_ho_nu->term_id,
                                    'hide_empty' => false,
                                ]);
                                if (!empty($child_cats) || isset($child_cats)) {  ?>
                                    <div class="mobile-sub-item">
                                        <div class="mobile-sub-item-top tech-item-head">
                                            <span class="text">
                                                <?php echo esc_html($parent_cat_dong_ho_nu->name); ?>
                                            </span>
                                            <a class="mobile-sub-link" href="<?php echo site_url('dong-ho/dong-ho-nu'); ?>">
                                                <?php _e('SHOP ALL', 'monamedia') ?>
                                            </a>
                                        </div>
                                        <div class="mobile-sub-main tech-body">
                                            <div class="mega-dh-list">

                                                <?php foreach ($child_cats as $child_cat) {
                                                    $link_child_cat = get_term_link($child_cat);
                                                    $image_product_cat = get_term_meta($child_cat->term_id, 'thumbnail_id', true); ?>

                                                    <a class="mega-dh-item" href="<?php echo esc_url($link_child_cat); ?>">
                                                        <span class="mega-dh-img">
                                                            <?php echo wp_get_attachment_image($image_product_cat, 'full'); ?>
                                                        </span>
                                                        <span class="mega-dh-name">
                                                            <?php echo esc_html($child_cat->name); ?>
                                                        </span>
                                                    </a>

                                                <?php } ?>

                                            </div>
                                        </div>
                                    </div>
                            <?php }
                            } ?>

                            <?php if ($parent_cat_trang_suc_nu && is_object($parent_cat_trang_suc_nu)) {
                                $child_cats = get_terms([
                                    'taxonomy'   => 'product_cat',
                                    'parent'     => $parent_cat_trang_suc_nu->term_id,
                                    'hide_empty' => false,
                                ]);
                                if (!empty($child_cats) || isset($child_cats)) {  ?>
                                    <!-- trang sức nu  -->
                                    <div class="mobile-sub-item">
                                        <div class="mobile-sub-item-top tech-item-head"><span class="text">
                                                <?php echo esc_html($parent_cat_trang_suc_nu->name); ?>
                                            </span>
                                            <a class="mobile-sub-link" href="<?php echo site_url('trang-suc/trang-suc-nu'); ?>">
                                                <?php _e('SHOP ALL', 'monamedia') ?>
                                            </a>
                                        </div>
                                        <div class="mobile-sub-main tech-body">
                                            <div class="mega-ts-list">

                                                <?php foreach ($child_cats as $child_cat) {
                                                    $link_child_cat = get_term_link($child_cat);
                                                    $image_child_cat = get_term_meta($child_cat->term_id, 'thumbnail_id', true)
                                                ?>

                                                    <div class="mega-ts-item">
                                                        <div class="mega-ts-img">
                                                            <a class="box" href="<?php echo esc_url($link_child_cat); ?>">
                                                                <?php echo wp_get_attachment_image($image_child_cat, 'full'); ?>
                                                            </a>
                                                        </div>
                                                    <a class="mega-ts-name" href="<?php echo esc_url($link_child_cat); ?>"><?php echo esc_html($child_cat->name); ?></a>
                                                    </div>

                                                <?php } ?>

                                            </div>
                                        </div>
                                    </div>
                            <?php }
                            } ?>

                            <?php if ($parent_cat_day_dong_ho_nu && is_object($parent_cat_day_dong_ho_nu)) {
                                $child_cats = get_terms([
                                    'taxonomy'   => 'product_cat',
                                    'parent'     => $parent_cat_day_dong_ho_nu->term_id,
                                    'hide_empty' => false,
                                ]);
                                if (!empty($child_cats) || isset($child_cats)) {  ?>
                                    <!-- dây đồng hồ nữ  -->
                                    <div class="mobile-sub-item">
                                        <div class="mobile-sub-item-top tech-item-head"><span class="text">
                                                <?php echo esc_html($parent_cat_day_dong_ho_nu->name); ?>
                                            </span>
                                            <a class="mobile-sub-link" href="<?php echo site_url('dong-ho/day-dong-ho-nu'); ?>">
                                                <?php _e('SHOP ALL', 'monamedia') ?>
                                            </a>
                                        </div>
                                        <div class="mobile-sub-main tech-body">
                                            <div class="swiper megaddhSwiper">
                                                <div class="swiper-wrapper">

                                                    <?php foreach ($child_cats as $child_cat) {
                                                        $link_child_cat = get_term_link($child_cat);
                                                        $image_child_cat = get_term_meta($child_cat->term_id, 'thumbnail_id', true)
                                                    ?>

                                                        <div class="swiper-slide">
                                                            <div class="mega-ddh-item">
                                                                <div class="mega-ddh-img">
                                                                    <a class="box" href="<?php echo esc_url($link_child_cat); ?>">
                                                                        <?php echo wp_get_attachment_image($image_child_cat, 'full'); ?>
                                                                    </a>
                                                                </div>
                                                                <a class="mega-ddh-name" href="<?php echo esc_url($link_child_cat); ?>"><?php echo esc_html($child_cat->name); ?></a>
                                                            </div>
                                                        </div>

                                                    <?php } ?>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            <?php }
                            } ?>

                            <?php if ($parent_cat_best_sellers_nu && is_object($parent_cat_best_sellers_nu)) {
                                $mona_hinh_anh_1_best_sellers = get_field('mona_hinh_anh_1_best_sellers', MONA_PAGE_HOME);
                                $tieu_de_1_best_sellers = get_field('tieu_de_1_best_sellers', MONA_PAGE_HOME);
                                $mona_hinh_anh_2_best_sellers = get_field('mona_hinh_anh_2_best_sellers', MONA_PAGE_HOME);
                                $tieu_de_2_best_sellers = get_field('tieu_de_2_best_sellers', MONA_PAGE_HOME);
                            ?>
                                <!-- best sellers nữ   -->
                                <div class="mobile-sub-item">
                                    <div class="mobile-sub-item-top tech-item-head">
                                        <span class="text"><?php echo esc_html($tieu_de_1_best_sellers); ?></span><a class="mobile-sub-link" href="<?php echo esc_url(site_url('best-sellers')); ?>">
                                            <?php _e('SHOP ALL', 'monamedia') ?>
                                        </a>
                                    </div>
                                    <div class="mobile-sub-main tech-body">
                                        <div class="mega-bs-flex">
                                            <div class="mega-bs-left">
                                                <div class="mega-bs-img">
                                                    <div class="box">
                                                        <?php echo wp_get_attachment_image($mona_hinh_anh_1_best_sellers, 'full'); ?>
                                                    </div>
                                                    <span class="text">
                                                        <?php echo esc_html($tieu_de_1_best_sellers); ?>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="mega-bs-right">
                                                <div class="mega-bs-simg">
                                                    <div class="box">
                                                        <?php echo wp_get_attachment_image($mona_hinh_anh_2_best_sellers, 'full'); ?>
                                                    </div>
                                                </div>
                                                <div class="mega-bs-desc">
                                                    <span class="text"><?php echo esc_html($tieu_de_2_best_sellers); ?></span><a class="mega-bs-link" href="<?php echo esc_url(site_url('new-arrivals')); ?>"><?php _e('SHOP NOW', 'monamedia') ?></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>

                            <?php
                            $count = 4;
                            $args = array(
                                'post_type'      => 'product',
                                'post_status'    => 'publish',
                                'order' => 'DESC',
                                'posts_per_page' => $count,
                                'tax_query'     => array(
                                    array(
                                        'taxonomy' => 'product_visibility',
                                        'field'    => 'name',
                                        'terms'    => 'featured',
                                        'operator' => 'IN',
                                    ),
                                ),
                            );
                            $Query_Feature = new WP_Query($args);
                            if ($Query_Feature->have_posts()) {
                            ?>
                                <div class="mobile-sub-item">
                                    <div class="mobile-sub-item-top tech-item-head">
                                        <span class="text"><?php _e('New Arrivals', 'monamedia'); ?></span>
                                        <a class="mobile-sub-link" href="<?php echo site_url('dong-ho'); ?>">
                                            <?php _e('SHOP ALL', 'monamedia') ?>
                                        </a>
                                    </div>
                                    <div class="mobile-sub-main tech-body">
                                        <div class="swiper megaNewSwiper">
                                            <div class="swiper-wrapper">

                                                <?php
                                                while ($Query_Feature->have_posts()) :
                                                    $Query_Feature->the_post();
                                                ?>

                                                    <div class="swiper-slide">

                                                        <?php get_template_part('partials/product/item');  ?>

                                                    </div>

                                                <?php
                                                endwhile;
                                                wp_reset_postdata();
                                                ?>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } else { ?>

                                <div class="container">
                                    <div class="empty-product">
                                        <a class="image-empty-product" href="<?php echo home_url(); ?>">
                                            <img src="<?php echo esc_url(get_site_url()); ?>/template/assets/images/empty-cart-curnon.png" alt="this is a image of empty product">
                                        </a>
                                        <p class="text">
                                            <?php _e('Hiện tại, sản phẩm bạn tìm kiếm hiện đang cập nhật. Vui lòng quay lại sau hoặc liên hệ với chúng tôi.', 'monamedia'); ?>
                                        </p>
                                        <?php if (is_cart()) : ?>
                                            <a class="btn btn-pri" href="<?php echo home_url(); ?>">
                                                <span class="text"> <?php _e('TIẾP TỤC MUA SẮM', 'monamedia') ?></span>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </div>

                            <?php } ?>
                        </div>
                    </div>

                    <!-- quà tặng  -->
                    <?php if ($mona_tax_qua_tang) : ?>
                        <div class="mobile-sub mobile-sub-js"><a class="mobile-sub-pre">
                                <span class="icon"> <i class="fa-solid fa-arrow-left"></i></span><span class="text f-title"><?php echo esc_html($mona_tax_qua_tang->name); ?></span></a>
                            <div class="mobile-sub-ctn">
                                <div class="mobile-sub-item">
                                    <div class="mega-qt-list">

                                        <?php
                                        $child_cats_qua_tang = get_terms([
                                            'taxonomy'   => 'product_cat',
                                            'parent'     => $mona_tax_qua_tang->term_id,
                                            'hide_empty' => false,
                                        ]);
                                        foreach ($child_cats_qua_tang as $key => $item) {
                                            $link_item = get_term_link($item);
                                            $image_product_cat = get_term_meta($item->term_id, 'thumbnail_id', true);
                                        ?>

                                            <div class="mega-qt-item">
                                                <div class="mega-qt-box">
                                                    <a class="mega-qt-img" href="<?php echo esc_url($link_item); ?>">
                                                        <?php echo wp_get_attachment_image($image_product_cat, 'full'); ?>
                                                    </a>
                                                    <a class="mega-qt-name fw-5"><?php echo esc_html($item->name); ?></a>
                                                </div>
                                            </div>

                                        <?php } ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <div class="mobile-contact">

                        <!-- footer menu 4(lấy từ footer) -->
                        <?php wp_nav_menu(array(
                            'container' => false,
                            'container_class' => '',
                            'menu_class' => 'menu-list',
                            'theme_location' => 'footer-menu-4',
                            'walker' => new Mona_Walker_Nav_Menu,
                        )); ?>

                        <?php $social_items_footer = mona_get_option('social_items_footer');
                        if (is_array($social_items_footer)) { ?>

                            <div class="footer-social">

                                <?php foreach ($social_items_footer as $item) { ?>

                                    <a class="footer-social-link" href="<?php echo esc_url($item['link']); ?>">
                                        <?php echo '<img src="' . esc_url($item['icon']) . '">'; ?>
                                    </a>

                                <?php } ?>

                            </div>

                        <?php } ?>

                    </div>
                </div>
            </div>

        </div>

        <!-- form search  -->
        <?php get_template_part('searchform') ?>

        <!-- popup login  -->
        <div class="popup popup-login" data-popup-id="popup-login">
            <div class="popup-main">
                <div class="popup-over">
                    <p class="t36 fw-6 f-title"><?php _e('ĐĂNG NHẬP', 'monamedia') ?></p>
                    <p class="t12 fw-5">
                        <?php _e('Đăng nhập để không bỏ lỡ quyền lợi tích luỹ và hoàn tiền cho bất kỳ đơn hàng nào.', 'monamedia') ?>
                    </p><a class="btn btn-pri" href="<?php echo site_url('dang-nhap/') ?>"><span class="text"><?php _e('Đăng nhập', 'monamedia') ?></span></a>
                    <div class="popup-login-bot">
                        <p class="t12 fw-5 desc"><?php _e('Thành viên mới? ', 'monamedia') ?><a class="link" href="<?php echo site_url('dang-ky/') ?>"><?php _e('Tạo tài khoản', 'monamedia') ?></a>
                        </p>
                    </div>
                </div>
                <div class="popup-close"><i class="fas fa-times icon"></i></div>
            </div>
        </div>

        <!-- popup thêm item vào giỏ hàng  -->
        <div class="popup popup-cart" data-popup-id="popup-cart">
            <div class="popup-overlay"></div>
            <div class="popup-main">
                <div class="popup-over">
                    <p class="fw-6 f-title title"><?php _e('GIỎ HÀNG!', 'monamedia'); ?></p>
                    <div class="cmini-ctn">

                        <div class="widget_shopping_cart_content" id="m_mini_cart">
                            <?php woocommerce_mini_cart(); ?>
                        </div>

                    </div>
                    <div class="popup-cart-bot">
                        <a class="btn btn-pri" href="<?php echo site_url('thanh-toan/') ?>"><span class="text">
                                <?php _e('XEM GIỎ HÀNG', 'monamedia'); ?></span>
                        </a>
                        <span class="btn btn-second popup-close" id="close-cart">
                            <span class="text">
                                <?php _e('TIẾP TỤC MUA SẮM', 'monamedia'); ?>
                            </span>
                        </span>

                    </div>
                </div>
                <div class="popup-close" id="close-cart"><i class="fas fa-times icon"></i></div>
            </div>
        </div>

        <!-- popup-attri  -->
        <?php
        // get_template_part('partials/popup/PopupAttri');
        ?>
        <div class="monaPopupProductAttr"></div>

        <!-- popup acocunt  -->
        <?php $user_data = get_userdata(get_current_user_id()); ?>
        <div class="popup popup-login" data-popup-id="popup-login-2">
            <div class="popup-overlay"></div>
            <div class="popup-main">
                <div class="popup-over">
                    <p class="t28 fw-6 f-title"><?php _e('HI, ', 'monamedia'); ?>
                        <?php echo esc_html($user_data->display_name); ?>
                    </p>
                    <div class="popup-login-list">
                        <a class="popup-login-item" href="<?php echo site_url('tai-khoan/') ?>"><?php _e('My Account', 'monamedia') ?></a>
                        <a class="popup-login-item" href="<?php echo site_url('tai-khoan/hang-the/') ?>"><?php _e('Store Credits', 'monamedia') ?></a>
                        <!-- <a class="popup-login-item" href="">Returns</a> -->
                        <!-- logout  -->
                        <a class="popup-login-item" href="<?php echo wp_logout_url(home_url()); ?>"><?php _e('Sign Out', 'monamedia'); ?></a>
                    </div>
                </div>
                <div class="popup-close"><i class="fas fa-times icon"></i></div>
            </div>
        </div>

    </header>