<?php

/**
 * Section name: Home Banners
 * Description: 
 * Author: Monamedia
 * Order: 4
 */
$mona_sc_4_group = get_field('mona_sc_4_group');
?>
<?php
$count = 10;
$arg_posts = [
    'post_type' => 'product',
    'post_status' => 'publish',
    'posts_per_page' => $count,
];

if ($mona_sc_4_group['select'] == '2') {
    $arg_posts['orderby'] = 'post__in';
    $arg_posts['post__in'] = $mona_sc_4_group['relationship'];
} else {
    $arg_posts['order'] = 'desc';
}

$loop_posts = new WP_Query($arg_posts);
if ($loop_posts->have_posts()) :
?>
    <div class="hslide">
        <div class="hslide-wrap">
            <div class="hslide-flex">
                <div class="hslide-left" data-aos="fade-right">
                    <div class="hslide-ban">
                        <?php echo wp_get_attachment_image($mona_sc_4_group['image'], 'full'); ?>
                    </div>
                </div>
                <div class="hslide-right" data-aos="fade-left">
                    <div class="hslide-ctn">
                        <div class="hslide-ctn-top">
                            <h2 class="title f-title fw-7 t-center"><?php echo $mona_sc_4_group['title'] ?></h2>
                            <p class="text fw-5 t-center"><?php echo $mona_sc_4_group['des'] ?></p>
                        </div>
                        <div class="hslide-slide">
                            <div class="swiper hslideSwiper">
                                <div class="swiper-wrapper">
                                    <?php while ($loop_posts->have_posts()) :
                                        $loop_posts->the_post(); ?>
                                        <?php get_template_part('partials/product/item_home_outstanding');  ?>
                                    <?php endwhile;
                                    wp_reset_postdata(); ?>
                                </div>
                                <div class="hslide-btn">
                                    <div class="swiper-button-next hslide-btn-next"><i class="fa-solid fa-arrow-right"></i>
                                    </div>
                                    <div class="swiper-button-prev hslide-btn-prev"><i class="fa-solid fa-arrow-left"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="hslide-thumb" thumbsslider="">
                                <div class="swiper hslideThumbSwiper">
                                    <div class="swiper-wrapper">
                                        <?php while ($loop_posts->have_posts()) :
                                            $loop_posts->the_post();
                                            global $post;
                                            $mona_sc_2_group_global = get_field('mona_sc_2_group_global', $post->id);
                                        ?>
                                            <div class="swiper-slide">
                                                <div class="hslide-bot">
                                                    <div class="hslide-bot-flex">
                                                        <?php if (!empty($mona_sc_2_group_global['rp']) && is_array($mona_sc_2_group_global['rp'])) : ?>
                                                            <div class="hslide-bot-left">
                                                                <div class="hslide-color">
                                                                    <?php foreach ($mona_sc_2_group_global['rp'] as $key => $item) : ?>
                                                                        <a class="hslide-color-item" href="<?php echo $mona_sc_2_group_global['link'] ?>">
                                                                            <?php echo wp_get_attachment_image($item['icon'], 'full') ?>
                                                                        </a>
                                                                    <?php endforeach; ?>
                                                                </div>
                                                            </div>
                                                        <?php endif; ?>
                                                        <div class="hslide-bot-right">
                                                            <div class="hslide-review">
                                                                <div class="hslide-review-img">
                                                                    <div class="box">
                                                                        <?php echo wp_get_attachment_image($mona_sc_2_group_global['avatar'], 'full') ?>
                                                                    </div>
                                                                </div>
                                                                <div class="hslide-review-desc">
                                                                    <span class="text"><?php echo $mona_sc_2_group_global['des'] ?></span>
                                                                    <div class="hslide-review-bot">
                                                                        <span class="name">
                                                                            <?php echo $mona_sc_2_group_global['name'] ?>
                                                                        </span>
                                                                        <div class="star">
                                                                            <div class="star-list">
                                                                                <div class="star-flex star-empty">
                                                                                    <img class="icon" src="<?php echo esc_url(get_site_url()); ?>/template/assets/images/Star-fill.svg" alt="" />
                                                                                    <img class="icon" src="<?php echo esc_url(get_site_url()); ?>/template/assets/images/Star-fill.svg" alt="" />
                                                                                    <img class="icon" src="<?php echo esc_url(get_site_url()); ?>/template/assets/images/Star-fill.svg" alt="" />
                                                                                    <img class="icon" src="<?php echo esc_url(get_site_url()); ?>/template/assets/images/Star-fill.svg" alt="" />
                                                                                    <img class="icon" src="<?php echo esc_url(get_site_url()); ?>/template/assets/images/Star-fill.svg" alt="" />
                                                                                </div>
                                                                                <div class="star-flex star-filter" style="width:<?php echo $mona_sc_2_group_global['start'] * 20; ?>%;">
                                                                                    <img class="icon" src="<?php echo esc_url(get_site_url()); ?>/template/assets/images/Star.svg" alt="" />
                                                                                    <img class="icon" src="<?php echo esc_url(get_site_url()); ?>/template/assets/images/Star.svg" alt="" />
                                                                                    <img class="icon" src="<?php echo esc_url(get_site_url()); ?>/template/assets/images/Star.svg" alt="" />
                                                                                    <img class="icon" src="<?php echo esc_url(get_site_url()); ?>/template/assets/images/Star.svg" alt="" />
                                                                                    <img class="icon" src="<?php echo esc_url(get_site_url()); ?>/template/assets/images/Star.svg" alt="" />
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endwhile;
                                        wp_reset_postdata(); ?>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
