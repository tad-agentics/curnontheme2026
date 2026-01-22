<?php

/**
 * The template for displaying search.
 *
 * @package Monamedia
 */

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

get_header();

$search_query = isset($_GET['s']) ? $_GET['s'] : '';
$category_slug = isset($_GET['category']) ? $_GET['category'] : '';

$count = 9;
$paged = max(1, get_query_var('paged'));
$offset = ($paged - 1) * $count;
$taxonomy = isset($_GET['taxonomy']) ? $_GET['taxonomy'] : '';

$args = array(
	's' => $search_query,
	'post_type' => array('product'),
	'posts_per_page' => $count,
	'offset'         => $offset,
	'paged'          => $paged,
);

if (!empty($category_slug)) {
	$category = get_term_by('slug', $category_slug, 'product_cat');
	$args['tax_query'] = array(
		array(
			'taxonomy' => 'product_cat',
			'field' => 'slug',
			'terms' => $category_slug,
		),
	);
}

$search_query = new WP_Query($args);
$count = $search_query->found_posts;
?>
<main class="main page-template">
	<div class="pcollec">
		<div class="pcollec-wrap">
			<div class="container">
				<div class="pcollec-inner">
					<div class="pcollec-flex" style="justify-content: center;">

						<!-- fillter category  -->
						<div class="pcollec-right" style="border-left:0;">
							<div class="pcollec-top">

								<!-- breadcumb  -->
								<?php get_template_part('partials/breadcrumb'); ?>

							</div>

							<!-- list product  -->
							<form id="formPostAjax" data-layout="<?php echo $action_layout; ?>">
								<input type="hidden" name="post_type" value="<?php echo $post_type; ?>" />
								<input type="hidden" name="posts_per_page" value="<?php echo $count; ?>" />
								<?php if (is_tax()) {
									$current_cat = get_queried_object(); ?>
									<input type="hidden" name="taxonomies[<?php echo $current_cat->taxonomy; ?>][]" value="<?php echo $current_cat->slug ?>" />
								<?php } ?>

								<!-- filter  -->
								<div class="pcollec-fill" data-aos="fade-up">
									<div class="pcollec-fill-flex">
										<?php
										$term_id = get_queried_object();
										$quantity_product =  $term_id->count;
										if ($term_id) :
											if ($quantity_product > 0) :
										?>
												<div class="pcollec-fill-right">
													<span class="text fw-5 c-grey"><?php echo $quantity_product; ?><?php _e(' sản phẩm', 'monamedia') ?></span>
												</div>
										<?php endif;
										endif; ?>
									</div>
								</div>

								<div class="pcollec-main" data-aos="fade-up">
									<div class="pcollec-list monaPostsList is-loading-group">

										<?php if ($search_query->have_posts()) {
											while ($search_query->have_posts()) :
												$search_query->the_post(); ?>

												<div class="pro-item ">
													<?php get_template_part('partials/product/item');  ?>
												</div>

											<?php
											endwhile;
											wp_reset_postdata(); ?>

											<div style="width: 100%; display: flex; justify-content: center;">
												<?php mona_pagination_links($search_query); ?>
											</div>


										<?php } else { ?>

											<div class="container">
												<div class="empty-product">
													<a class="image-empty-product" href="<?php echo site_url('cua-hang/') ?>">
														<img src="<?php get_site_url(); ?>/template/assets/images/empty-cart-curnon.png" alt="this is a image of empty product">
													</a>
													<p class="text">
														<?php _e('Hiện tại, sản phẩm bạn tìm kiếm hiện đang cập nhật. Vui lòng quay lại sau hoặc liên hệ với chúng tôi.', 'monamedia'); ?>
													</p>
													<a class="btn btn-pri" href="<?php echo site_url('cua-hang/') ?>">
														<span class="text"> <?php _e('Cửa hàng', 'monamedia') ?></span>
													</a>
												</div>
											</div>

										<?php } ?>

									</div>
								</div>

							</form>

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- RunText  -->
	<?php get_template_part('partials/global/RunText');  ?>

	<!-- RunText  -->
	<?php get_template_part('partials/global/BePartOfCurnon');  ?>


</main>

<?php get_footer();
