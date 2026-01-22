<?php

/**
 * The template for displaying single.
 *
 * @package Monamedia
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}
get_header();
while (have_posts()) :
    the_post();
    mona_set_post_view();
    global $post;
    $post_object = $post;
    $post_title         =   get_the_title($post_object);
    $post_thumbnail     =   get_the_post_thumbnail($post_object, 'large');
    $post_permalink     =   get_the_permalink($post_object);
    $post_excerpt       =   get_the_excerpt($post_object);
    $view = mona_get_post_view($post_object);

    $cat_curent = get_queried_object();
    $action_layout      = 'reload'; // loadmore / reload
    $count = 3;
    $paged = max(1, get_query_var('paged'));
    $offset = ($paged - 1) * $count;
    $post_type          = 'post';

    $args = array(
        'post_type'      => $post_type,
        'post_status' => 'publish',
        // 'orderby' => 'title',
        'posts_per_page' => $count,
        'offset'         => $offset,
        'paged'          => $paged,
        'category_name'  => $cat_curent->name,
        'meta_query'     => [
            'relation' => 'AND',
        ],
        'tax_query'      => [
            'relation' => 'AND',
        ],
    );
?>

    <main class="main page-template">
        <div class="bdban">
            <div class="bdban-wrap">
                <div class="bdban-top">
                    <div class="container">
                        <div class="bdban-top-inner" data-aos="fade-up">

                            <?php get_template_part('partials/breadcrumb'); ?>

                            <h1 class="title f-title fw-7 t-center"><?php echo $post_title; ?>
                            </h1>
                            <p class="desc fw-5 t-center"><?php echo $post_excerpt; ?></p>
                            <div class="bdban-top-bot">
                                <div class="bdban-date t12 fw-5">
                                    <?php echo date('F j, Y', strtotime($post->post_date)); ?>
                                    <?php _e('- ', 'monamedia'); ?>
                                    <?php echo $view; ?>
                                    <?php _e('view', 'monamedia'); ?>
                                </div>

                                <?php get_template_part('partials/social-share'); ?>

                            </div>
                        </div>
                    </div>
                </div>
                <!-- <div class="bdban-img" data-aos="fade-up"><img src="<?php get_site_url(); ?>/template/assets/images/bdban-img.jpg" alt="" />
                </div>
                <div class="bdban-img bdban-img-mb d-none"><img src="<?php get_site_url(); ?>/template/assets/images/bdban-img-mb.jpg" alt="" />
                </div> -->
            </div>
        </div>
        <div class="dblog">
            <div class="dblog-wrap">
                <div class="container">
                    <div class="dblog-inner">
                        <div class="dblog-flex">
                            <div class="dblog-left" data-aos="fade-right">
                                <div class="dblog-ctn" id="main-content">
                                    <div class="mona-content">
                                        <?php the_content(); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="dblog-right" data-aos="fade-left">
                                <div class="dblog-stick">

                                    <?php echo do_shortcode('[ez-toc]'); ?>

                                    <a class="dblog-totop" href="#main-content">
                                        <span class="icon">
                                            <i class="fa-solid fa-arrow-up">

                                            </i>
                                        </span>
                                        <span class="text fw-5 t12">
                                            <?php _e('Back to top', 'monamedia'); ?>
                                        </span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- bài viết liên quan  -->
        <?php $query = new WP_Query($args);
        if ($query->have_posts()) {   ?>

            <div class="reblog" data-aos="fade-up">
                <div class="reblog-wrap">
                    <div class="container">
                        <div class="reblog-inner">
                            <h2 class="title fw-7 f-title"><?php _e('BÀI VIẾT LIÊN QUAN', 'monamedia') ?></h2>
                            <div class="reblog-list">

                                <?php
                                while ($query->have_posts()) {
                                    $query->the_post();
                                    global $post;
                                ?>

                                    <div class="blog-item" data-aos="fade-up">
                                        <?php get_template_part('partials/product/item_post') ?>
                                    </div>

                                <?php }
                                wp_reset_query($query); ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

        <?php } ?>

        <!-- FormBlog  -->
        <?php get_template_part('partials/global/FormBlog');  ?>

    </main>

<?php
endwhile;
get_footer();
