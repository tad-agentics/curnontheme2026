<?php

/**
 * Section name: Home Banners
 * Description: 
 * Author: Monamedia
 * Order: 2
 */
$tax = get_field('tax');
?>
<?php if (!empty($tax)) : ?>

    <div class="blog">
        <div class="blog-wrap">
            <div class="container">
                <div class="blog-inner">
                    <div class="blog-top">
                        <div class="blog-link" data-aos="fade-right">
                            <span class="blog-link-item active">
                                <?php _e('TẤT CẢ', 'monamedia'); ?>
                            </span>
                            <?php foreach ($tax as $key => $item) {
                                $link_term = get_term_link($item);
                            ?>
                                <a class="blog-link-item" href="<?php echo esc_url($link_term); ?>"><?php echo $item->name; ?>
                                </a>
                            <?php } ?>
                        </div>

                        <!-- search post -->
                        <div class="blog-srch" data-aos="fade-left">
                            <?php get_template_part('searchform_page_blog') ?>
                        </div>

                    </div>

                    <div class="blog-ctn">

                        <?php foreach ($tax as $key => $item) {
                            $link_term = get_term_link($item);

                            $count = 3;
                            $arg_posts = [
                                'post_type'   => 'post',
                                'post_status' => 'publish',
                                'order'       => 'desc',
                                'category_name'  => $item->name,
                                'posts_per_page' => $count,
                            ];

                            $loop_posts = new WP_Query($arg_posts);
                            if ($loop_posts->have_posts()) :
                        ?>

                                <div class="blog-row">
                                    <div class="blog-row-top">
                                        <h2 class="fw-7 f-title title" data-aos="fade-right"><?php echo $item->name; ?></h2><a class="link" href="<?php echo esc_url($link_term); ?>" data-aos="fade-left"><?php _e('XEM TẤT CẢ', 'monamedia'); ?></a>
                                    </div>
                                    <div class="blog-list" data-aos="fade-up">

                                        <?php while ($loop_posts->have_posts()) :
                                            $loop_posts->the_post();
                                        ?>

                                            <div class="blog-item" data-aos="fade-up">
                                                <?php get_template_part('partials/product/item_post') ?>
                                            </div>

                                        <?php endwhile;
                                        wp_reset_postdata(); ?>

                                    </div>
                                </div>

                            <?php endif; ?>

                        <?php } ?>

                    </div>
                </div>
            </div>
        </div>
    </div>

<?php endif; ?>