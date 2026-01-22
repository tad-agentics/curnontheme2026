<?php
if (is_user_logged_in()) {
    $user_id = get_current_user_id();
    $wishlist_array = get_user_meta($user_id, '_wishlist', true) ? get_user_meta($user_id, '_wishlist', true) : [];
} else {
    $wishlist_array = [];
}

if ($wishlist_array) :
?>
<div class="pwish-list">

    <?php
        foreach ($wishlist_array as $key => $item) {
            if (get_post_type($item) == 'product') {
                global $post;
                $url = get_the_permalink($item);
                $thumb = get_the_post_thumbnail($item, 'thumbnail');
                $title = get_the_title($item);
                $product = wc_get_product($item);
                $price_html = $product->get_price_html($item);

                // $ratingScore = get_rating_score($item);
                $args = array(
                    'status'      => 'approve',
                    'post_type'   => 'product',
                    'post_id'     => $item,
                );
                $evaluates = get_comments($args);
                $totalEvaluates = count($evaluates);
        ?>

    <div class="pro-item">
        <!-- item product  -->
        <div class="pro-box">
            <div class="pro-img">
                <button class="icon-remove m-remove-wishlist active" data-key="<?php echo $item; ?>">
                    <i class="fa-light fa-xmark"></i>
                </button>
                <div class="box box-pc">
                    <?php echo $thumb; ?>
                </div>
                <div class="box box-pc">
                    <?php echo wp_get_attachment_image(get_field('mona_hinh_anh_nguoi_mau', $item), 'full') ?>
                </div>
                <div class="swiper proSwiper">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <div class="box">
                                <?php echo $thumb; ?>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="box">
                                <?php echo wp_get_attachment_image(get_field('mona_hinh_anh_nguoi_mau', $item), 'full') ?>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-pagination"></div>
                </div>

                <!-- add product  -->
                <?php if ($product->is_type('variable')) { ?>
                <a class="pro-add pro-add-pc popup-open popup-product-attr" data-product="<?php echo $item ?>"
                    data-popup="popup-attri" id="popup-attri">

                    <span class="text is-loading-group-mobile">
                        <?php _e('Thêm vào giỏ hàng', 'monamedia'); ?>
                    </span>
                    <span class="icon">
                        <img src="<?php echo esc_url(get_site_url()); ?>/template/assets/images/pro-cart.png" alt="" />
                    </span>
                </a>

                <?php } else { ?>

                <div class="pro-add pro-add-pc m-add-to-cart-flash" data-product-id="<?php echo $item; ?>">

                    <span class="text is-loading-group">
                        <?php _e('Thêm vào giỏ hàng', 'monamedia'); ?>
                    </span>
                    <span class="icon">
                        <img src="<?php echo esc_url(get_site_url()); ?>/template/assets/images/pro-cart.png" alt="" />
                    </span>

                </div>

                <?php } ?>

                <?php if ($percent_sale) : ?>
                <span class="pro-tag">
                    <?php echo $percent_sale; ?>
                </span>
                <?php endif; ?>
            </div>

            <div class="pro-desc">
                <a class="pro-name" href="<?php echo $link; ?>"><?php echo $title; ?></a>
                <div class="pro-price">
                    <?php echo $price_html; ?>
                </div>


                <!-- variation -->
                <?php if ($product->is_type('variable')) : ?>
                <!-- <div class="pro-desc-op">
            <div class="recheck">
                <div class="recheck-block">
                    <div class="recheck-item">
                        <input class="recheck-input" type="radio" name="" hidden="" />
                        <div class="recheck-checkbox">
                            <img src="<?php echo esc_url(get_site_url()); ?>/template/assets/images/img1.png" alt="" />
                        </div>
                    </div>
                    <div class="recheck-item">
                        <input class="recheck-input" type="radio" name="" hidden="" />
                        <div class="recheck-checkbox">
                            <img src="<?php echo esc_url(get_site_url()); ?>/template/assets/images/img2.png" alt="" />
                        </div>
                    </div>
                    <div class="recheck-item">
                        <input class="recheck-input" type="radio" name="" hidden="" />
                        <div class="recheck-checkbox">
                            <img src="<?php echo esc_url(get_site_url()); ?>/template/assets/images/img3.png" alt="" />
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
                <?php endif; ?>



                <!-- add product mobile  -->
                <?php if ($product->is_type('variable')) { ?>

                <div class="pro-add pro-add-mb popup-open popup-product-attr" data-product="<?php echo $item ?>"
                    data-popup="popup-attri" id="popup-attri">

                    <span class="text is-loading-group-mobile"> <?php _e('Thêm', 'monamedia'); ?></span>
                    <span class="icon">
                        <img src="<?php echo esc_url(get_site_url()); ?>/template/assets/images/pro-cart.png" alt="" /></span>

                </div>

                <?php } else { ?>


                <a class="pro-add pro-add-mb m-add-to-cart-flash" data-product-id="<?php echo $item; ?>">
                    <span class="text is-loading-group"> <?php _e('Thêm', 'monamedia'); ?></span>
                    <span class="icon">
                        <img src="<?php echo esc_url(get_site_url()); ?>/template/assets/images/pro-cart.png" alt="" /></span>
                </a>

                <?php } ?>

            </div>
        </div>
    </div>

    <?php }
        } ?>

</div>

<?php else :
?>
<div class="container" style="justify-content: center; display: flex; text-align: center;">
    <div class="empty-product">
        <a class="image-empty-product" href="<?php echo home_url(); ?>">
            <img src="<?php echo esc_url(get_site_url()); ?>/template/assets/images/wishlist.png"
                alt="this is a image of empty product">
        </a>
        <p class="text">
            <?php _e('Hiện tại, bạn chưa có sản phẩm yêu thích.', 'monamedia'); ?>
        </p>
        <?php if (is_cart()) : ?>
        <a class="btn btn-pri" href="<?php echo home_url(); ?>">
            <span class="text"> <?php _e('TIẾP TỤC MUA SẮM', 'monamedia') ?></span>
        </a>
        <?php endif; ?>
    </div>
</div>
<?php
endif ?>