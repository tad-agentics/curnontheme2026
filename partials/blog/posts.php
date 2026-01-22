<?php

/**
 * Section name: Home Banners
 * Description: 
 * Author: Monamedia
 * Order: 1
 */
$mona_sc_2_group = get_field('mona_sc_2_group');
if (isset($mona_sc_2_group) || !empty($mona_sc_2_group)) {
    $tieu_de = $mona_sc_2_group['tieu_de'];
    $noi_dung = $mona_sc_2_group['noi_dung'];
    $icon = $mona_sc_2_group['icon'];
    $select = $mona_sc_2_group['select'];
    $relationship = $mona_sc_2_group['relationship'];
    $select_post = $mona_sc_2_group['select_post'];
    $relationship_post = $mona_sc_2_group['relationship_post'];
}
?>
<div class="lpost">
    <div class="lpost-wrap">
        <div class="container">
            <div class="lpost-inner">
                <h2 class="f-title title fw-7" data-aos="fade-up"><?php echo $tieu_de; ?></h2>
                <div class="lpost-flex">
                    <div class="lpost-left" data-aos="fade-right">
                        <div class="lpost-left-ctn">
                            <div class="lpost-top">
                                <h2 class="title fw-6"><?php echo $noi_dung; ?></h2>
                                <div class="lpost-logo">
                                    <?php echo wp_get_attachment_image($icon, 'full'); ?>
                                </div>
                            </div>

                            <!-- product  -->
                            <?php
                            $count = 5;
                            $arg_posts = [
                                'post_type' => 'product',
                                'post_status' => 'publish',
                                'posts_per_page' => $count,
                            ];

                            if ($select == '2') {
                                $arg_posts['orderby'] = 'post__in';
                                $arg_posts['post__in'] = $relationship;
                            } else {
                                $arg_posts['order'] = 'desc';
                            }
                            $loop_posts = new WP_Query($arg_posts);
                            if ($loop_posts->have_posts()) :
                                $count = 0;
                            ?>
                                <div class="lpost-main">
                                    <div class="lpost-thumb">
                                        <div class="swiper lpostThumbSwiper">
                                            <div class="swiper-wrapper">

                                                <?php
                                                while ($loop_posts->have_posts()) :
                                                    $loop_posts->the_post();
                                                    global $post;
                                                    $categories = get_the_terms($post->ID, 'category');
                                                ?>

                                                    <div class="swiper-slide">
                                                        <div class="lpost-thumb-img">
                                                            <?php echo get_the_post_thumbnail($post->ID, 'full'); ?>
                                                        </div>
                                                    </div>

                                                <?php endwhile;
                                                wp_reset_postdata(); ?>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="lpost-slide">
                                        <div class="swiper lpostSwiper">
                                            <div class="swiper-wrapper">

                                                <?php while ($loop_posts->have_posts()) :
                                                    $loop_posts->the_post();
                                                    global $post; ?>

                                                    <div class="swiper-slide">
                                                        <div class="lpost-slide-img">
                                                            <?php echo wp_get_attachment_image(get_field('mona_hinh_anh_nguoi_mau', $post->ID), 'full') ?>

                                                            <!-- category of product  -->
                                                            <?php
                                                            $tax = 'product_cat';
                                                            $cat_id = get_post_meta($post->ID, '_yoast_wpseo_primary_' . $tax, true);
                                                            if ($cat_id) {
                                                                $primary_cat = get_term($cat_id, $tax);
                                                                if (isset($primary_cat->name)) { ?>

                                                                    <span class="text f-title"><?php echo $primary_cat->name; ?></span>

                                                            <?php }
                                                            } ?>

                                                        </div>
                                                    </div>

                                                <?php endwhile;
                                                wp_reset_postdata(); ?>

                                            </div>
                                            <div class="lpost-btn">
                                                <div class="swiper-button-next lpost-btn-next"><i class="fa-light fa-arrow-right-long"></i></div>
                                                <div class="swiper-button-prev lpost-btn-prev"><i class="fa-light fa-arrow-left-long"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            <?php endif; ?>

                        </div>
                    </div>

                    <!-- product  -->
                    <?php
                    $count = 3;
                    $arg_posts = [
                        'post_type' => 'post',
                        'post_status' => 'publish',
                        'posts_per_page' => $count,
                    ];

                    if ($select_post == '2') {
                        $arg_posts['orderby'] = 'post__in';
                        $arg_posts['post__in'] = $relationship_post;
                    } else {
                        $arg_posts['order'] = 'desc';
                    }
                    $loop_posts = new WP_Query($arg_posts);
                    if ($loop_posts->have_posts()) :
                        $count = 0;
                    ?>

                        <div class="lpost-right" data-aos="fade-left">
                            <div class="lpost-list">

                                <?php while ($loop_posts->have_posts()) :
                                    $loop_posts->the_post();
                                    global $post;
                                    $categories = get_the_terms($post->ID, 'category');
                                    $view = mona_get_post_view($post->ID);
                                ?>

                                    <div class="lpost-item">
                                        <div class="lpost-img"><a class="box" href="<?php echo esc_url(get_the_permalink($post->ID)); ?>">
                                                <?php echo get_the_post_thumbnail($post->ID, 'full'); ?></a>
                                        </div>
                                        <div class="lpost-desc">

                                            <?php if (!empty($cat_posts) || isset($cat_posts)) {
                                                foreach ($cat_posts as $cat) {
                                                    $link_cat = get_term_link($cat); ?>
                                                    <a class="lpost-cate" href="<?php echo esc_url($link_cat); ?>">
                                                        <?php echo $cat->name; ?>

                                                    </a>
                                            <?php }
                                            } ?>

                                            <a class="lpost-name" href="<?php echo esc_url(get_the_permalink($post->ID)); ?>">
                                                <?php echo $post->post_title; ?></a>
                                            <p class="lpost-time"><?php echo $view; ?>
                                                <?php _e('view', 'monamedia'); ?></p>
                                        </div>
                                    </div>

                                <?php endwhile;
                                wp_reset_postdata(); ?>

                            </div>
                        </div>

                    <?php endif; ?>

                </div>
            </div>
        </div>
    </div>
</div>