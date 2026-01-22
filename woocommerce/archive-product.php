<?php
if (isset($_GET['advanced']) && $_GET['advanced'] === 'true') {
    /**
     * The Template for displaying product archives, including the main shop page which is a post type archive
     *
     * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
     *
     * HOWEVER, on occasion WooCommerce will need to update template files and you
     * (the theme developer) will need to copy the new files to your theme to
     * maintain compatibility. We try to do this as little as possible, but it does
     * happen. When this occurs the version of the template file will be bumped and
     * the readme will list any important changes.
     *
     * @see https://woo.com/document/template-structure/
     * @package WooCommerce\Templates
     * @version 3.4.0
     */

    defined('ABSPATH') || exit;

    get_header('shop');

    /**
     * Hook: woocommerce_before_main_content.
     *
     * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
     * @hooked woocommerce_breadcrumb - 20
     * @hooked WC_Structured_Data::generate_website_data() - 30
     */
    do_action('woocommerce_before_main_content');

?>
    <header class="woocommerce-products-header">
        <?php if (apply_filters('woocommerce_show_page_title', true)) : ?>
            <h1 class="woocommerce-products-header__title page-title"><?php woocommerce_page_title(); ?></h1>
        <?php endif; ?>

        <?php
        /**
         * Hook: woocommerce_archive_description.
         *
         * @hooked woocommerce_taxonomy_archive_description - 10
         * @hooked woocommerce_product_archive_description - 10
         */
        do_action('woocommerce_archive_description');
        ?>
    </header>
    <?php
    if (woocommerce_product_loop()) {

        /**
         * Hook: woocommerce_before_shop_loop.
         *
         * @hooked woocommerce_output_all_notices - 10
         * @hooked woocommerce_result_count - 20
         * @hooked woocommerce_catalog_ordering - 30
         */
        do_action('woocommerce_before_shop_loop');

        woocommerce_product_loop_start();

        if (wc_get_loop_prop('total')) {
            while (have_posts()) {
                the_post();

                /**
                 * Hook: woocommerce_shop_loop.
                 */
                do_action('woocommerce_shop_loop');

                wc_get_template_part('content', 'product');
            }
        }

        woocommerce_product_loop_end();

        /**
         * Hook: woocommerce_after_shop_loop.
         *
         * @hooked woocommerce_pagination - 10
         */
        do_action('woocommerce_after_shop_loop');
    } else {
        /**
         * Hook: woocommerce_no_products_found.
         *
         * @hooked wc_no_products_found - 10
         */
        do_action('woocommerce_no_products_found');
    }

    /**
     * Hook: woocommerce_after_main_content.
     *
     * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
     */
    do_action('woocommerce_after_main_content');

    /**
     * Hook: woocommerce_sidebar.
     *
     * @hooked woocommerce_get_sidebar - 10
     */
    do_action('woocommerce_sidebar');

    get_footer('shop');
} else {
    /**
     * The Template for displaying product archives, including the main shop page which is a post type archive
     *
     * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
     *
     * HOWEVER, on occasion WooCommerce will need to update template files and you
     * (the theme developer) will need to copy the new files to your theme to
     * maintain compatibility. We try to do this as little as possible, but it does
     * happen. When this occurs the version of the template file will be bumped and
     * the readme will list any important changes.
     *
     * @see https://docs.woocommerce.com/document/template-structure/
     * @package WooCommerce\Templates
     * @version 3.4.0
     */

    defined('ABSPATH') || exit;

    get_header();
    $image_product = mona_get_option('image_product');
    $sc_product_page = get_field('sc_product_page', MONA_PAGE_HOME);

    $product_count = wp_count_posts('product');
    $total_products = $product_count->publish;

    if (is_tax()) {
        $ob = get_queried_object();
        $product_count = $ob->count;
    } else {
        $product_query = new WP_Query(array(
            'post_type' => 'product',
            'posts_per_page' => -1,
        ));

        $product_count = $product_query->post_count;
    }

    $action_layout      = 'reload'; // loadmore / reload
    $count = 12;
    $paged = max(1, get_query_var('paged'));
    $offset = ($paged - 1) * $count;
    $post_type          = 'product';

    $args = array(
        'post_type'      => $post_type,
        'post_status' => 'publish',
        // 'orderby' => 'title',
        'posts_per_page' => $count,
        'offset'         => $offset,
        'paged'          => $paged,
        'meta_query'     => [
            'relation' => 'AND',
        ],
        'tax_query'      => [
            'relation' => 'AND',
        ],
    );

    if (is_tax()) {
        $args['tax_query'] = array(
            array(
                'taxonomy' => $ob->taxonomy,
                'field' => 'slug',
                'terms' => $ob->slug,
                'include_children' => false,
            ),
        );
    }

    $wp_query = new WP_Query($args);

    // $mona_tax_global = get_field('mona_tax_global', MONA_PAGE_HOME);
    $mona_sc_7_group_global     = get_field('mona_sc_7_group_global', MONA_PAGE_HOME);

    // $mona_tax_global = $mona_sc_7_group_global['mona_tax_global'];
    $rp_mona_sc_7_group_global  = $mona_sc_7_group_global['rp'];

    $current_term_id = get_queried_object()->term_id;
    $parent_lv0 = get_ancestors($current_term_id, 'product_cat');
    if (!empty($parent_lv0)) {
        $lv0_term_id = end($parent_lv0);
    }
    ?>

    <main class="main page-template">
        <div class="pcollec">
            <div class="pcollec-wrap">
                <div class="container">
                    <div class="pcollec-inner">
                        <div class="pcollec-flex">

                            <?php if (!empty($rp_mona_sc_7_group_global) && is_array($rp_mona_sc_7_group_global)) : ?>

                                <div class="pcollec-left" data-aos="fade-right">
                                    <div class="pcollec-cate">

                                        <?php foreach ($rp_mona_sc_7_group_global as $key => $item) :
                                        ?>

                                            <div class="pcollec-cate-item">
                                                <div class="pcollec-cate-head tech-item-head">
                                                    <span class="text">
                                                        <?php echo $item['title']; ?>
                                                    </span>
                                                    <span class="icon">
                                                        <i class="fa-regular fa-plus-large"></i>
                                                        <i class="fa-light fa-minus"></i></span>
                                                </div>

                                                <?php if (!empty($item['tax']) && is_array($item['tax'])) : ?>

                                                    <div class="pcollec-cate-body tech-body">
                                                        <ul class="scate-list">

                                                            <?php foreach ($item['tax'] as $key => $item_tax) :
                                                                $link_tax = get_term_link($item_tax);
                                                                // lv1
                                                                $cat_child = get_terms(array(
                                                                    'taxonomy'      => 'product_cat',
                                                                    'parent'        => $item_tax->term_id,
                                                                    'hide_empty'    => false,
                                                                ));

                                                                $parent_lv0_2 = get_ancestors($item_tax->term_id, 'product_cat');
                                                                if (!empty($parent_lv0_2)) {
                                                                    $lv0_term_id_2 = end($parent_lv0_2);
                                                                } ?>

                                                                <li class="scate-item <?php if ($item_tax->term_id == $current_term_id ||  $current_term_id == $lv0_term_id_2) {
                                                                                            echo 'active';
                                                                                        } ?> "><a class="scate-link" href="<?php echo $link_tax; ?>">
                                                                        <?php echo $item_tax->name; ?>

                                                                    </a>

                                                                    <?php if ($cat_child) : ?>

                                                                        <ul class="scate-list">

                                                                            <?php foreach ($cat_child as $key => $item_child) :
                                                                                $link_tax_child = get_term_link($item_child);

                                                                                $parent_lv0_3 = get_ancestors($item_child->term_id, 'product_cat');
                                                                                if (!empty($parent_lv0_3)) {
                                                                                    $lv0_term_id_3 = end($parent_lv0_3);
                                                                                } ?>

                                                                                <li class="scate-item <?php if ($item_child->term_id == $current_term_id) {
                                                                                                            echo 'active';
                                                                                                        } ?>">
                                                                                    <a class="scate-link" href="<?php echo $link_tax_child; ?>">
                                                                                        <?php echo $item_child->name; ?>
                                                                                    </a>
                                                                                </li>

                                                                            <?php endforeach; ?>

                                                                        </ul>

                                                                    <?php endif; ?>

                                                                </li>

                                                            <?php endforeach; ?>

                                                        </ul>
                                                    </div>

                                                <?php endif; ?>

                                            </div>

                                        <?php endforeach; ?>

                                    </div>
                                </div>

                            <?php endif; ?>

                            <!-- fillter category  -->
                            <div class="pcollec-right">
                                <div class="pcollec-top">

                                    <!-- breadcumb  -->
                                    <?php get_template_part('partials/breadcrumb'); ?>

                                    <?php
                                    // display cat 
                                    $mona_select_cat_pro_global = get_field('mona_select_cat_pro_global', MONA_PAGE_HOME);
                                    if ($mona_select_cat_pro_global == 2) {
                                    ?>
                                        <!-- option 1  -->
                                        <div class="pcollec-tf-1 pcollec-tf">
                                            <div class="pcollec-tf-top" data-aos="fade-up">
                                                <h1 class="title f-title fw-7">
                                                    <?php echo get_queried_object()->name; ?>
                                                </h1>
                                                <span class="text c-grey fw-5">
                                                    <?php echo get_queried_object()->description; ?>
                                                </span>
                                            </div>

                                            <?php $parent_tax = get_terms(array(
                                                'taxonomy' => 'product_cat',
                                                'order' => 'DESC',
                                                'parent' => get_queried_object()->term_id,
                                                'hide_empty' => false,
                                            ));
                                            if ($parent_tax) {
                                            ?>

                                                <div class="recheck" data-aos="fade-up">
                                                    <div class="recheck-block">
                                                        <div class="swiper pcollectfSwiper">
                                                            <div class="swiper-wrapper">

                                                                <?php foreach ($parent_tax as $parent_category) {
                                                                    $link_term = get_term_link($parent_category);
                                                                    $image_product_cat = get_term_meta($parent_category->term_id, 'thumbnail_id', true);
                                                                ?>

                                                                    <div class="swiper-slide">
                                                                        <a href="<?php echo esc_url($link_term); ?>" class="pcollec-tf-1-item">
                                                                            <span class="recheck-checkbox">
                                                                                <?php echo wp_get_attachment_image($image_product_cat, 'full'); ?>
                                                                            </span>
                                                                            <span class="recheck-text">
                                                                                <?php echo $parent_category->name; ?>
                                                                            </span>
                                                                        </a>
                                                                    </div>

                                                                <?php } ?>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            <?php } ?>

                                        </div>
                                    <?php } else { ?>
                                        <!-- option 2  -->
                                        <div class="pcollec-tf-2 pcollec-tf">
                                            <div class="pcollec-tf-top" data-aos="fade-up">
                                                <h1 class="title f-title fw-7">
                                                    <?php echo get_queried_object()->name; ?>
                                                </h1>
                                                <span class="text c-grey fw-5">
                                                    <?php echo get_queried_object()->description; ?>
                                                </span>
                                            </div>

                                            <?php $parent_tax = get_terms(array(
                                                'taxonomy' => 'product_cat',
                                                'order' => 'DESC',
                                                'parent' => get_queried_object()->term_id,
                                                'hide_empty' => false,
                                            ));
                                            if ($parent_tax) {
                                            ?>

                                                <div class="recheck" data-aos="fade-up">
                                                    <div class="recheck-block">
                                                        <div class="swiper pcollectfSwiper">
                                                            <div class="swiper-wrapper">

                                                                <?php foreach ($parent_tax as $parent_category) {
                                                                    $link_term = get_term_link($parent_category); ?>

                                                                    <div class="swiper-slide">
                                                                        <a href="<?php echo esc_url($link_term); ?>" class="recheck-text">
                                                                            <?php echo $parent_category->name; ?>
                                                                        </a>
                                                                    </div>

                                                                <?php } ?>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            <?php } ?>

                                        </div>
                                    <?php } ?>
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
                                            <div class="pcollec-fill-left">

                                                <!-- filter product  -->
                                                <?php get_template_part('partials/product/filter');  ?>

                                                <!-- sort by  -->
                                                <?php get_template_part('partials/product/sort');  ?>

                                            </div>
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

                                            <?php if ($wp_query->have_posts()) {
                                                while ($wp_query->have_posts()) :
                                                    $wp_query->the_post(); ?>

                                                    <div class="pro-item">
                                                        <?php get_template_part('partials/product/item');  ?>
                                                    </div>

                                                <?php
                                                endwhile;
                                                wp_reset_postdata(); ?>

                                                <?php if ($quantity_product >= 12) : ?>
                                                    <div class="btn btn-pri center monaLoadMoreJS is-loading-btn" data-paged="<?php echo ++$paged; ?>">
                                                        <span class="text">
                                                            <?php _e(' View more', 'monamedia'); ?>
                                                        </span>
                                                    </div>
                                                <?php endif; ?>
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

<?php
    get_footer();
}
?>
