<?php

/**
 * Section name: Home Banners
 * Description: 
 * Author: Monamedia
 * Order: 0
 */
$mona_sc_1_group = get_field('mona_sc_1_group');
if (isset($mona_sc_1_group) || !empty($mona_sc_1_group)) {
    $tieu_de = $mona_sc_1_group['tieu_de'];
    $noi_dung = $mona_sc_1_group['noi_dung'];
    $select = $mona_sc_1_group['select'];
    $relationship = $mona_sc_1_group['relationship'];
}
?>
<div class="bban">
    <div class="bban-wrap">
        <div class="container">
            <div class="bban-inner">
                <div class="bban-top">
                    <div class="bban-top-flex">
                        <div class="bban-top-left" data-aos="fade-right">
                            <h1 class="title f-title fw-7"><?php echo $tieu_de; ?></h1>
                        </div>
                        <div class="bban-top-right" data-aos="fade-left">
                            <p class="text fw-5"><?php echo $noi_dung; ?></p>
                        </div>
                    </div>
                </div>

                <!-- posts  -->
                <?php
                $count = 4;
                $arg_posts = [
                    'post_type' => 'post',
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

                    <div class="bban-slide" data-aos="fade-up">
                        <div class="swiper bbanSwiper">
                            <div class="swiper-wrapper">

                                <?php while ($loop_posts->have_posts()) :
                                    $loop_posts->the_post();
                                    global $post;
                                    $cat_posts = get_the_terms($post->ID, 'category');
                                    $post_expect = get_the_excerpt($post->ID);
                                    $view = mona_get_post_view($post->ID);
                                ?>

                                    <div class="swiper-slide">
                                        <div class="bban-item">
                                            <div class="bban-item-bg">
                                                <?php echo get_the_post_thumbnail($post->ID, 'full'); ?>
                                            </div>
                                            <div class="bban-flex">
                                                <div class="bban-left">
                                                    <div class="bban-text">

                                                        <?php if (!empty($cat_posts) || isset($cat_posts)) {
                                                            foreach ($cat_posts as $cat) {
                                                                $link_cat = get_term_link($cat); ?>
                                                                <a class="c-white fw-6" href="<?php echo esc_url($link_cat); ?>">
                                                                    <?php echo $cat->name; ?>

                                                                </a>
                                                        <?php }
                                                        } ?>

                                                        <p class="title"><?php echo $post->post_title; ?></p>
                                                        <p class="text"><?php echo $post_expect; ?></p>
                                                        <p class="time">
                                                            <?php echo date('F j, Y', strtotime($post->post_date)); ?>
                                                            <?php _e('- ', 'monamedia'); ?> <?php echo $view; ?>
                                                            <?php _e('view', 'monamedia'); ?></p>
                                                    </div>
                                                </div>
                                                <div class="bban-right">
                                                    <a class="bban-link" href="<?php echo esc_url(get_the_permalink($post->ID)); ?>">
                                                        <span class="icon"> <i class="fa-light fa-arrow-right-long"></i></span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                <?php $count++;
                                endwhile;
                                wp_reset_postdata(); ?>

                            </div>
                            <div class="bban-pagi">
                                <span class="num f-title current"><?php _e('01', 'monamedia') ?></span>
                                <div class="swiper-pagination bbanSwiper-pagination"> </div><span class="num f-title total"><?php _e('0', 'monamedia') ?><?php echo $count; ?></span>
                            </div>

                        </div>
                    </div>

                <?php endif; ?>

            </div>
        </div>
    </div>
</div>