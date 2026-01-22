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
?>

    <main class="main page-template">
        <div class="policy">
            <div class="policy-wrap">
                <div class="container">
                    <div class="policy-inner">
                        <div class="policy-flex">
                            <div class="policy-left">
                                <div class="policy-ctn" id="main-content">
                                    <h1 class="title f-title fw-7">
                                        <?php _e('CURNON GIÚP GÌ ĐƯỢC CHO BẠN?', 'monamedia'); ?>
                                    </h1>
                                    <h2 class="subtitle fw-6 f-title"><?php echo the_title(); ?></h2>
                                    <div class="mona-content">
                                        <?php the_content(); ?>
                                    </div>
                                </div>
                            </div>
                            <?php if (!empty(do_shortcode('[ez-toc]'))) : ?>
                                <div class="policy-right">

                                    <?php echo do_shortcode('[ez-toc]'); ?>

                                    <a class="dblog-totop" href="#main-content">
                                        <span class="icon">
                                            <i class="fa-solid fa-arrow-up"></i>
                                        </span>
                                        <span class="text fw-5 t12">
                                            <?php _e('Back to top', 'monamedia'); ?>
                                        </span>
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

<?php
endwhile;
get_footer();
