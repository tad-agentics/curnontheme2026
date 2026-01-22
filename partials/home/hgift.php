<?php

/**
 * Section name: Home Banners
 * Description: 
 * Author: Monamedia
 * Order: 8
 */
$mona_sc_7_group = get_field('mona_sc_7_group');
?>
<div class="hgift">
    <div class="hgift-wrap">
        <div class="hgift-flex">
            <?php
            $count = 4;
            $arg_posts = [
                'post_type' => 'product',
                'post_status' => 'publish',
                'posts_per_page' => $count,
            ];

            if ($mona_sc_7_group['select'] == '2') {
                $arg_posts['orderby'] = 'post__in';
                $arg_posts['post__in'] = $mona_sc_7_group['relationship'];
            } else {
                $arg_posts['order'] = 'desc';
            }

            $loop_posts = new WP_Query($arg_posts);
            if ($loop_posts->have_posts()) :
            ?>
                <div class="hgift-left">
                    <div class="hgift-list">
                        <?php while ($loop_posts->have_posts()) :
                            $loop_posts->the_post();
                        ?>

                            <?php get_template_part('partials/product/item_home');  ?>

                        <?php endwhile;
                        wp_reset_postdata(); ?>
                    </div>
                </div>
            <?php endif; ?>

            <?php if (isset($mona_sc_7_group['rp']) || !empty($mona_sc_7_group['rp'])) : ?>
                <div class="hgift-right">
                    <div class="hgift-slide">
                        <div class="swiper hgiftSwiper">
                            <div class="swiper-wrapper">
                                <?php foreach ($mona_sc_7_group['rp'] as $key => $item) :
                                    $link = get_term_link($item);
                                ?>
                                    <div class="swiper-slide">
                                        <div class="hgift-box">
                                            <div class="hgift-box-img">
                                                <?php echo wp_get_attachment_image($item['image'], 'full') ?>
                                            </div>
                                            <div class="hgift-box-desc">
                                                <p class="title f-title"><?php echo $item['des']; ?></p><a class="link" href="<?php echo $item['link']; ?>"><?php _e('SHOP NOW', 'monamedia') ?></a>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <div class="hgift-btn">
                                <div class="swiper-button-next hgift-btn-next"><i class="fa-solid fa-arrow-right"></i>
                                </div>
                                <div class="swiper-button-prev hgift-btn-prev"><i class="fa-solid fa-arrow-left"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>