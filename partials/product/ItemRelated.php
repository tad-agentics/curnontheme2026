<?php
global $post;
$product_id_curent = get_queried_object_id();

$groupGlobal  = get_field('mona_sc_1_group_global', $product_id_curent);
$tieu_de      = isset($groupGlobal['tieu_de']) ? esc_attr($groupGlobal['tieu_de']) : '';
$select       = isset($groupGlobal['select']) ? esc_attr($groupGlobal['select']) : '';
$relationship = isset($groupGlobal['relationship']) ? $groupGlobal['relationship'] : [];

$count = 5;
$arg   = [
    'post_type'      => 'product',
    'posts_per_page' => $count,
    'post_status'    => 'publish',
    'post__not_in'   => [$product_id_curent],
];

if ($select == '2') {
    $arg['orderby'] = 'post__in';
    $arg['post__in'] = $relationship;
} else {
    $arg['order'] = 'desc';
}
$loop_products = new WP_Query($arg);
if ($loop_products->have_posts()) :
?>
    <div class="pdp-dk">
        <div class="pdp-dk-top">
            <div class="pdp-dk-flex">
                <div class="pdp-dk-left">
                    <span class="text fw-5">
                        <?php
                        if (!empty($tieu_de)) {
                            echo $tieu_de;
                        } else {
                            _e('Sản phẩm bạn có thể quan tâm', 'monamedia');
                        } ?>
                    </span>
                </div>
                <div class="pdp-dk-right">
                    <div class="pdp-dk-btn">
                        <div class="swiper-button-next pdp-dk-btn-next"><i class="fa-solid fa-arrow-right"></i></div>
                        <div class="swiper-button-prev pdp-dk-btn-prev"><i class="fa-solid fa-arrow-left"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="pdp-dk-slide">
            <div class="swiper pdpDKSwiper">
                <div class="swiper-wrapper">
                    <?php
                    while ($loop_products->have_posts()) :
                        $loop_products->the_post();
                        $product_id = get_the_ID();
                        $product    = wc_get_product();
                        $price_html = '';

                        if ($product->is_type('variable')) {
                            $variation_ids = $product->get_children();
                            if (count($variation_ids) > 0) {
                                $variation_id = reset($variation_ids);
                                $_product = new WC_Product_Variation($variation_id);
                                if ($product->get_price() == 0) {
                                    $price_html = '<p class="price-new">' . __('Liên hệ', 'monamedia') . '</p>';
                                } else {
                                    $price_html = $product->get_price_html();
                                }
                            }
                        } else {
                            if ($product->get_price() == 0) {
                                $price_html = '<p class="price-new">' . __('Liên hệ', 'monamedia') . '</p>';
                            } else {
                                $price_html = $product->get_price_html();
                            }
                        }
                        $link      = get_the_permalink($product_id);
                        $title     = get_the_title($product_id);
                        $thumbnail = get_the_post_thumbnail($product_id, 'full');
                    ?>
                        <div class="swiper-slide">
                            <div class="pdp-dk-item">
                                <div class="pdp-dk-img">
                                    <div class="box">
                                        <?php echo $thumbnail; ?>
                                    </div>
                                    <?php if ($product->is_type('variable')) { ?>
                                        <a class="pdp-dk-add popup-open popup-product-attr" data-product="<?php echo $product_id ?>" data-popup="popup-attri" id="popup-attri">
                                            <span class="icon">
                                                <img src="<?php get_site_url(); ?>/template/assets/images/pro-cart.png" alt="" />
                                            </span>
                                        </a>
                                    <?php } else { ?>
                                        <div class="pdp-dk-add m-add-to-cart-flash" data-product-id="<?php echo $product_id; ?>">
                                            <span class="icon">
                                                <img src="<?php get_site_url(); ?>/template/assets/images/pro-cart.png" alt="" />
                                            </span>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div class="pdp-dk-desc">
                                    <?php
                                    $taxonomy = 'product_cat';
                                    $primary_cat_id = get_post_meta($product_id, '_yoast_wpseo_primary_' . $taxonomy, true);
                                    if ($primary_cat_id) {
                                        $primary_cat = get_term($primary_cat_id, $taxonomy);
                                        $primary_cat_link = get_term_link($primary_cat, $taxonomy);
                                        if (isset($primary_cat->name)) ?>
                                        <a class="pdp-dk-name" href="<?php echo $link; ?>"><?php echo $primary_cat->name; ?></a>

                                    <?php }  ?>
                                    <a href="<?php echo $link; ?>" class="pdp-dk-name"><?php echo $title; ?></a>
                                    <div class="pdp-dk-price">
                                        <?php echo $price_html; ?>
                                    </div>
                                </div>
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
<?php endif; ?>