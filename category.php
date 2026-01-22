<?php

/**
 * The template for displaying category.
 *
 * @package Monamedia
 */

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

get_header();

$cat_post = get_terms(
	array(
		'taxonomy'   => 'category',
		'hide_empty' => false,
		'order' => 'desc',
	)
);

$cat_curent = get_queried_object();
$action_layout      = 'reload'; // loadmore / reload
$count = 12;
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

$mona_banner_mol = get_field('mona_banner_mol', $cat_curent->taxonomy . '_' . $cat_curent->term_id);
$mona_banner_des = get_field('mona_banner_des', $cat_curent->taxonomy . '_' . $cat_curent->term_id);
$mona_title_cat_post = get_field('mona_title_cat_post', $cat_curent->taxonomy . '_' . $cat_curent->term_id);
$des = term_description($cat_curent->term_id);
?>
<main class="main page-template">
    <div class="bcban">
        <div class="bcban-wrap">
            <div class="bcban-bg">
                <?php echo wp_get_attachment_image($mona_banner_des, 'full') ?>
            </div>
            <div class="bcban-bg bcban-bg-mb d-none">
                <?php echo wp_get_attachment_image($mona_banner_mol, 'full') ?>
            </div>
            <div class="container">
                <div class="bcban-inner">
                    <div class="bcban-ctn" data-aos="fade-up">
                        <h2 class="title fw-7 f-title c-white"><?php echo $mona_title_cat_post; ?></h2>
                        <div class="desc c-white fw-5"><?php echo $des; ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="blog blog-child">
        <div class="blog-wrap">
            <div class="container">
                <div class="blog-inner">
                    <div class="blog-top">
                        <div class="blog-link" data-aos="fade-right">
                            <a class="blog-link-item" href="<?php echo site_url('blog/'); ?>">
                                <?php _e('TẤT CẢ', 'monamedia'); ?>
                            </a>

                            <?php if (!empty($cat_post)) {
								foreach ($cat_post as $key => $item) { ?>

                            <a class="blog-link-item <?php if ($cat_curent->name ==  $item->name) {
																	echo 'active';
																} ?>" href="<?php echo get_term_link($item) ?>">
                                <?php echo $item->name ?>
                            </a>

                            <?php }
							} ?>

                        </div>

                        <!-- search post -->
                        <div class="blog-srch" data-aos="fade-left">
                            <?php get_template_part('searchform_page_blog') ?>
                        </div>

                    </div>
                    <div class="blog-ctn">
                        <div class="blog-row">
                            <div class="blog-row-top">
                                <h1 class="fw-7 f-title title" data-aos="fade-right"><?php _e('CHỦ ĐỀ ', 'monamedia') ?>
                                    <?php echo $cat_curent->name; ?></h1>
                            </div>

                            <?php $query = new WP_Query($args);
							if ($query->have_posts()) {   ?>

                            <div class="blog-list">

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

                            <?php } ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- FormBlog  -->
    <?php get_template_part('partials/global/FormBlog');  ?>

</main>
<?php get_footer();