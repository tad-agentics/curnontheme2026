<?php

/**
 * Section name: Home Banners
 * Description: 
 * Author: Monamedia
 * Order: 5
 */
$mona_sc_5_group = get_field('mona_sc_5_group');
$count = 10;
$action_layout      = 'reload';
$post_type          = 'product';
?>
<form id="formPostAjax" data-layout="<?php echo $action_layout; ?>">
    <input type="hidden" name="post_type" value="<?php echo $post_type; ?>" />
    <input type="hidden" name="posts_per_page" value="<?php echo $count; ?>" />
    <?php if (is_tax()) {
        $current_cat = get_queried_object(); ?>
        <input type="hidden" name="taxonomies[<?php echo $current_cat->taxonomy; ?>][]" value="<?php echo $current_cat->slug ?>" />
    <?php } ?>

    <div class="spro spro-slide-js">
        <div class="spro-wrap" data-aos="fade-up">
            <?php if (isset($mona_sc_5_group['tax']) || !empty($mona_sc_5_group['tax'])) : ?>
                <div class="spro-top">
                    <div class="container">
                        <div class="spro-top-flex">
                            <div class="spro-top-left">
                                <div class="spro-title f-title fw-7"><?php echo $mona_sc_5_group['title']; ?></div>
                                <div class="spro-fill pcollec-tf-2">
                                    <div class="recheck">
                                        <div class="recheck-block">
                                            <div class="recheck-item">
                                                <input class="recheck-input monaFilterJS-home" type="radio" name="all" id="<?php echo $item->slug; ?>" value="all" hidden="" checked>
                                                <p class="recheck-text"><?php _e('TẤT CẢ', 'monamedia') ?></p>
                                            </div>
                                            <?php foreach ($mona_sc_5_group['tax'] as $key => $item) : ?>
                                                <div class="recheck-item">
                                                    <input class="recheck-input monaFilterJS-home" type="radio" name="tax[<?php echo $item->taxonomy ?>][]" id="<?php echo $item->slug; ?>" value="<?php echo $item->slug ?>" hidden="">
                                                    <p class="recheck-text" style="text-transform: uppercase;">
                                                        <?php echo $item->name; ?></p>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="spro-top-right"><a class="link fw-6 t16" href="<?php echo $mona_sc_5_group['link']; ?>"><?php _e('SHOP ALL', 'monamedia') ?></a>
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
            <?php endif; ?>
            <?php $arg_posts = [
                'post_type'         => $post_type,
                'post_status'       => 'publish',
                'posts_per_page'    => $count,
            ];

            if ($mona_sc_5_group['select'] == '2') {
                $arg_posts['orderby'] = 'post__in';
                $arg_posts['post__in'] = $mona_sc_5_group['relationship'];
            } else {
                $arg_posts['order'] = 'desc';
            }

            $loop_posts = new WP_Query($arg_posts);
            if ($loop_posts->have_posts()) :
            ?>
                <div class="spro-slide">
                    <div class="spro-slide-inner">
                        <div class="swiper sproSwiper">
                            <div class="swiper-wrapper monaPostsList is-loading-group">

                                <?php while ($loop_posts->have_posts()) :
                                    $loop_posts->the_post(); ?>

                                    <div class="swiper-slide">
                                        <div class="pro-item">
                                            <?php get_template_part('partials/product/item');  ?>
                                        </div>
                                    </div>

                                <?php endwhile;
                                wp_reset_postdata(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</form>