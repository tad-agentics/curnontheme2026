<?php
add_action('wp_ajax_mona_ajax_pagination_posts',  'mona_ajax_pagination_posts'); // login
add_action('wp_ajax_nopriv_mona_ajax_pagination_posts',  'mona_ajax_pagination_posts'); // no login
function mona_ajax_pagination_posts()
{
    $form = array();
    check_ajax_referer('mona_ajax_nonce', 'nonce');

    $formdata = isset($_POST['formdata']) ? wp_unslash($_POST['formdata']) : '';
    if (!empty($formdata)) {
        parse_str($formdata, $form);
    }
    if (!is_array($form)) {
        $form = [];
    }
    $paged              = isset($_POST['paged']) ? absint($_POST['paged']) : 1;
    $action             = isset($_POST['action_layout']) ? sanitize_text_field($_POST['action_layout']) : 'reload';
    $flagAction         = isset($_POST['action_flag']) ? sanitize_text_field($_POST['action_flag']) : '';

    $action_return      = $action;
    $post_type          = !empty($form['post_type']) ? sanitize_key($form['post_type']) : 'post';
    $posts_per_page     = !empty($form['posts_per_page']) ? absint($form['posts_per_page']) : 9;
    $offset             = ($paged - 1) * $posts_per_page;
    $order              = 'DESC';
    $argsPost = array(
        'post_type' => $post_type,
        'post_status' => 'publish',
        'posts_per_page' => $posts_per_page,
        'paged' => $paged,
        'offset' => $offset,
        'meta_query' => [
            'relation' => 'AND',
        ],
        'tax_query' => [
            'relation' => 'AND',
        ]
    );

    if (isset($form['s']) && !empty($form['s'])) {
        $argsPost['s'] = sanitize_text_field($form['s']);
    }
    // search
    if (isset($form['findProduct']) && !empty($form['findProduct'])) {
        $findProductValue = sanitize_text_field($form['findProduct']);

        $argsPost['s'] = $findProductValue;
    }

    /** Không được gỡ **/
    if ($flagAction == 'false' && $action == 'loadmore' && (isset($form['s']) || isset($form['sort']))) {
        $action_return = 'reload';
    }

    // product_cat
    if (isset($form['taxonomies']) && is_array($form['taxonomies']) && !empty($form['taxonomies'])) {
        foreach ($form['taxonomies'] as $taxonomy => $slug) {
            $taxonomy = sanitize_key($taxonomy);
            $slug = sanitize_title($slug);
            if ($slug != '') {
                $argsPost['tax_query'][] =  array(
                    'taxonomy'  => $taxonomy,
                    'field'     => 'slug',
                    'terms'     => $slug,
                    'operator'  => 'IN'
                );
            }
        }
    }

    // product_cat
    if (isset($form['tax']) && is_array($form['tax']) && !empty($form['tax'])) {
        foreach ($form['tax'] as $taxonomy => $slug) {
            $taxonomy = sanitize_key($taxonomy);
            $slug = sanitize_title($slug);
            if ($slug != '') {
                $argsPost['tax_query'][] =  array(
                    'taxonomy'  => $taxonomy,
                    'field'     => 'slug',
                    'terms'     => $slug,
                    'operator'  => 'IN'
                );
            }
        }
    }

    // taxonomy_color
    if (isset($form['taxonomy_color']) && is_array($form['taxonomy_color']) && !empty($form['taxonomy_color'])) {
        foreach ($form['taxonomy_color'] as $taxonomy => $slug) {
            $taxonomy = sanitize_key($taxonomy);
            $slug = sanitize_title($slug);
            if ($slug != '') {
                $argsPost['tax_query'][] =  array(
                    'taxonomy'  => $taxonomy,
                    'field'     => 'slug',
                    'terms'     => $slug,
                    'operator'  => 'IN'
                );
            }
        }
    }

    // taxonomy_size
    if (isset($form['taxonomy_size']) && is_array($form['taxonomy_size']) && !empty($form['taxonomy_size'])) {
        foreach ($form['taxonomy_size'] as $taxonomy => $slug) {
            $taxonomy = sanitize_key($taxonomy);
            $slug = sanitize_title($slug);
            if ($slug != '') {
                $argsPost['tax_query'][] =  array(
                    'taxonomy'  => $taxonomy,
                    'field'     => 'slug',
                    'terms'     => $slug,
                    'operator'  => 'IN'
                );
            }
        }
    }

    // taxonomy_material
    if (isset($form['taxonomy_material']) && is_array($form['taxonomy_material']) && !empty($form['taxonomy_material'])) {
        foreach ($form['taxonomy_material'] as $taxonomy => $slug) {
            $taxonomy = sanitize_key($taxonomy);
            $slug = sanitize_title($slug);
            if ($slug != '') {
                $argsPost['tax_query'][] =  array(
                    'taxonomy'  => $taxonomy,
                    'field'     => 'slug',
                    'terms'     => $slug,
                    'operator'  => 'IN'
                );
            }
        }
    }

    // price_min,price_max 
    // if (isset($form['price_min']) && is_numeric($form['price_min']) && isset($form['price_max']) && is_numeric($form['price_max'])) {
    //     $argsPost['meta_query'][] = array(
    //         'relation' => 'OR',

    //         array(
    //             'key' => '_sale_price',
    //             'value' => array($form['price_min'], $form['price_max']),
    //             'type' => 'NUMERIC',
    //             'compare' => 'BETWEEN',
    //         ),

    //         array(
    //             'key' => '_price',
    //             'value' => array($form['price_min'], $form['price_max']),
    //             'type' => 'NUMERIC',
    //             'compare' => 'BETWEEN',
    //         )
    //     );
    // }

    // rating
    if (isset($form['rating']) && is_array($form['rating'])) {
        $argsPost['meta_query'][] = array(
            'key' => '_wc_average_rating',
            'value' => array_map('floatval', $form['rating']),
            'compare' => '=',
            'type' => 'NUMERIC',
        );
    }

    if ($post_type == 'product') {

        if (isset($form['prices']) && is_array($form['prices']) && !empty($form['prices'])) {

            $priceArray = $form['prices'];
            $postIDs_byPrice = [];

            global $wpdb;
            $sql = "SELECT DISTINCT p.ID
                FROM {$wpdb->prefix}posts AS p
                INNER JOIN {$wpdb->prefix}postmeta AS pm ON p.ID = pm.post_id
                WHERE p.post_type = 'product'
                AND p.post_status = 'publish'
                AND pm.meta_key = '_price'";

            $conditions = [];
            $params = [];
            foreach ($priceArray as $index => $price) {
                if (!is_array($price)) {
                    continue;
                }
                $active = isset($price['active']) ? sanitize_text_field($price['active']) : '';
                if (!empty($active)) {
                    $option = isset($price['option']) ? sanitize_text_field($price['option']) : '';
                    if ($option === 'less') {
                        $single = isset($price['single']) ? floatval($price['single']) : 0;
                        $conditions[] = "(pm.meta_value < %f)";
                        $params[] = $single;
                    } elseif ($option === 'range') {
                        $from = isset($price['from']) ? floatval($price['from']) : 0;
                        $to = isset($price['to']) ? floatval($price['to']) : 0;
                        $conditions[] = "(pm.meta_value >= %f AND pm.meta_value <= %f)";
                        $params[] = $from;
                        $params[] = $to;
                    } elseif ($option === 'more') {
                        $single = isset($price['single']) ? floatval($price['single']) : 0;
                        $conditions[] = "(pm.meta_value > %f)";
                        $params[] = $single;
                    }
                }
            }

            if (!empty($conditions)) {
                $sql .= ' AND (' . implode(' OR ', $conditions) . ')';
            }

            $prepared_sql = !empty($params) ? $wpdb->prepare($sql, $params) : $sql;
            $results = $wpdb->get_results($prepared_sql);
            if ($results) {
                foreach ($results as $result) {
                    $postIDs_byPrice[] = $result->ID;
                }

                if (is_array($postIDs_byPrice) && !empty($postIDs_byPrice)) {
                    $argsPost['post__in'] = $postIDs_byPrice;
                }
            }
        }

        if (isset($form['sort']) && !empty($form['sort'])) {
            $sort = sanitize_text_field($form['sort']);
            switch ($sort) {
                case 'az':
                    $argsPost['orderby'] = 'title';
                    $argsPost['order']   = 'ASC';
                    break;

                case 'za':
                    $argsPost['orderby'] = 'title';
                    $argsPost['order']   = 'DESC';
                    break;

                case 'lowtohigh':
                    $argsPost['orderby']['meta_price'] = 'ASC';
                    $argsPost['meta_query']['meta_price'] = [
                        'key'               => '_price',
                        'compare'           => 'EXISTS',
                    ];
                    break;

                case 'hightolow':
                    $argsPost['orderby']['meta_price'] = 'DESC';
                    $argsPost['meta_query']['meta_price'] = [
                        'key'               => '_price',
                        'compare'           => 'EXISTS',
                    ];
                    break;

                case 'featured':
                    $argsPost['tax_query'][] = array(
                        'taxonomy' => 'product_visibility',
                        'field'    => 'name',
                        'terms'    => 'featured',
                        'operator' => 'IN',
                    );
                    break;

                case 'total_sales':
                    $argsPost['orderby']['meta_total_sales'] = 'DESC';
                    $argsPost['meta_query']['meta_total_sales'] = [
                        'key'               => 'total_sales',
                        'value'             => intval(0),
                        'compare'           => '>=',
                        'type'               => 'NUMERIC'
                    ];
                    break;

                default:
                    $argsPost['orderby']['meta_total_sales'] = 'DESC';
                    $argsPost['meta_query']['meta_total_sales'] = [
                        'key'               => 'total_sales',
                        'value'             => intval(0),
                        'compare'           => '>=',
                        'type'               => 'NUMERIC'
                    ];
                    break;
            }
        }
    } else {

        if (isset($form['sort']) && !empty($form['sort'])) {
            $sort = esc_attr($form['sort']);
            switch ($sort) {
                case 'view':
                    $argsPost['meta_query']['meta_view'] = [
                        'key' => '_mona_post_view',
                        'value' => 0,
                        'compare' => '>=',
                        'type' => 'numeric',
                    ];
                    $argsPost['orderby']['meta_view'] = 'desc';
                    break;

                case 'asc':
                    $argsPost['order'] = 'asc';
                    break;

                default:
                    $argsPost['order'] = 'desc';
                    break;
            }
        } else {
            $argsPost['order'] = 'desc';
        }
    }


    ob_start();
    $postsMONA = new WP_Query($argsPost);
    if ($postsMONA->have_posts()) {
?>

        <?php
        $count = 0;
        while ($postsMONA->have_posts()) {
            $postsMONA->the_post();

        ?>

            <div class="pro-item ">
                <?php
                switch ($post_type) {

                    case 'product':

                        /**
                         * GET TEMPLATE PART
                         * product-inner
                         */
                        // $slug = '/partials/loop/product';
                        // $name = 'inner';
                        // echo get_template_part($slug, $name);

                        get_template_part('partials/product/item');
                        break;
                }
                ?>
            </div>

        <?php
            $count++;
        }
        wp_reset_query(); ?>


        <?php if ($action == 'reload') { ?>

            <!-- <div class="pagination-posts-ajax pagination">
                <?php mona_pagination_links_ajax($postsMONA, $paged); ?>
            </div> -->

            <?php if ($count >= 12) : ?>
                <div class="btn btn-pri center monaLoadMoreJS is-loading-btn" data-paged="<?php echo ++$paged; ?>">
                    <span class="text">
                        <?php _e(' View more', 'monamedia'); ?>
                    </span>
                </div>
            <?php endif; ?>

        <?php } else if ($action == 'loadmore') { ?>

            <?php if ($paged < $postsMONA->max_num_pages) { ?>
                <div class="btn btn-pri center monaLoadMoreJS is-loading-btn" data-paged="<?php echo ++$paged; ?>">
                    <span class="text">
                        <?php _e('View more', 'monamedia'); ?>
                    </span>
                </div>
            <?php } ?>

        <?php } ?>

    <?php } else { ?>

        <div class="container">
            <div class="empty-product">
                <a class="image-empty-product" href="<?php echo home_url(); ?>">
                    <img src="<?php echo esc_url(get_site_url()); ?>/template/assets/images/empty-cart-curnon.png" alt="this is a image of empty product">
                </a>
                <p class="text">
                    <?php _e('Hiện tại, sản phẩm bạn tìm kiếm hiện đang cập nhật. Vui lòng quay lại sau hoặc liên hệ với chúng tôi.', 'monamedia'); ?>
                </p>
                <?php if (is_cart()) : ?>
                    <a class="btn btn-pri" href="<?php echo home_url(); ?>">
                        <span class="text"> <?php _e('TIẾP TỤC MUA SẮM', 'monamedia') ?></span>
                    </a>
                <?php endif; ?>
            </div>
        </div>

    <?php } ?>

    <?php
    switch ($post_type) {
        default:
            $class_scroll = 'monaPostsList';
            break;
    }
    wp_send_json_success(
        [
            'title'         => __('Thông báo!', 'monamedia'),
            'message'       =>  __('Load thêm thành công!', 'monamedia'),
            'title_close'   =>  __('Đóng', 'monamedia'),
            'posts_html'    => ob_get_clean(),
            'argsPosts'     => $argsPost,
            'scroll'        => $class_scroll,
            'action_return' => $action_return
        ]
    );
    wp_die();
}

add_action('wp_ajax_mona_ajax_pagination_products',  'mona_ajax_pagination_products'); // login
add_action('wp_ajax_nopriv_mona_ajax_pagination_products',  'mona_ajax_pagination_products'); // no login
function mona_ajax_pagination_products()
{
    check_ajax_referer('mona_ajax_nonce', 'nonce');

    $paged              = isset($_POST['paged']) ? absint($_POST['paged']) : 1;
    $form = array();
    $formdata = isset($_POST['formdata']) ? wp_unslash($_POST['formdata']) : '';
    if (!empty($formdata)) {
        parse_str($formdata, $form);
    }
    if (!is_array($form)) {
        $form = [];
    }
    $post_type          = !empty($form['post_type']) ? sanitize_key($form['post_type']) : 'post';
    $posts_per_page     = !empty($form['posts_per_page']) ? absint($form['posts_per_page']) : 12;
    $offset             = ($paged - 1) * $posts_per_page;
    $order              = 'DESC';
    $argsPost = array(
        'post_type' => $post_type,
        'post_status' => 'publish',
        'posts_per_page' => $posts_per_page,
        'paged' => $paged,
        'offset' => $offset,
        'meta_query' => [
            'relation' => 'AND',
        ],
        'tax_query' => [
            'relation' => 'AND',
        ]
    );

    $keyword = '';
    if (!empty($form['s'])) {
        $keyword = sanitize_text_field($form['s']);
        $argsPost['s'] = $keyword;
    }

    if (!empty($form['taxonomies'])) {
        if (is_array($form['taxonomies'])) {
            foreach ($form['taxonomies'] as $taxonomy => $slug) {
                $taxonomy = sanitize_key($taxonomy);
                $slug = sanitize_title($slug);
                if ($slug != '') {
                    $argsPost['tax_query'][] =  array(
                        'taxonomy'  => $taxonomy,
                        'field'     => 'slug',
                        'terms'     => $slug,
                        'operator'  => 'IN'
                    );
                }
            }
        }
    }

    if (isset($form['prices']) && is_array($form['prices']) && !empty($form['prices'])) {
        $priceArray = $form['prices'];
        $postIDs_byPrice = [];
        global $wpdb;
        $sql = "SELECT DISTINCT p.ID
            FROM {$wpdb->prefix}posts AS p
            INNER JOIN {$wpdb->prefix}postmeta AS pm ON p.ID = pm.post_id
            WHERE p.post_type = 'product'
            AND p.post_status = 'publish'
            AND pm.meta_key = '_price'";

        $conditions = [];
        $params = [];
        foreach ($priceArray as $index => $price) {
            if (!is_array($price)) {
                continue;
            }
            $active = isset($price['active']) ? sanitize_text_field($price['active']) : '';
            if (!empty($active)) {
                $option = isset($price['option']) ? sanitize_text_field($price['option']) : '';
                if ($option === 'less') {
                    $single = isset($price['single']) ? floatval($price['single']) : 0;
                    $conditions[] = "(pm.meta_value < %f)";
                    $params[] = $single;
                } elseif ($option === 'range') {
                    $from = isset($price['from']) ? floatval($price['from']) : 0;
                    $to = isset($price['to']) ? floatval($price['to']) : 0;
                    $conditions[] = "(pm.meta_value >= %f AND pm.meta_value <= %f)";
                    $params[] = $from;
                    $params[] = $to;
                } elseif ($option === 'more') {
                    $single = isset($price['single']) ? floatval($price['single']) : 0;
                    $conditions[] = "(pm.meta_value > %f)";
                    $params[] = $single;
                }
            }
        }

        if (!empty($conditions)) {
            $sql .= ' AND (' . implode(' OR ', $conditions) . ')';
        }

        $prepared_sql = !empty($params) ? $wpdb->prepare($sql, $params) : $sql;
        $results = $wpdb->get_results($prepared_sql);
        if ($results) {
            foreach ($results as $result) {
                $postIDs_byPrice[] = $result->ID;
            }

            if (is_array($postIDs_byPrice) && !empty($postIDs_byPrice)) {
                $argsPost['post__in'] = $postIDs_byPrice;
            }
        }
    }

    if (isset($form['sort']) && !empty($form['sort'])) {
        $sort = sanitize_text_field($form['sort']);
        switch ($sort) {
            case 'az':
                $argsPost['orderby'] = 'title';
                $argsPost['order']   = 'ASC';
                break;

            case 'za':
                $argsPost['orderby'] = 'title';
                $argsPost['order']   = 'DESC';
                break;

            case 'lowtohigh':
                $argsPost['orderby']['meta_price'] = 'ASC';
                $argsPost['meta_query']['meta_price'] = [
                    'key'               => '_price',
                    'compare'           => 'EXISTS',
                ];
                break;

            case 'hightolow':
                $argsPost['orderby']['meta_price'] = 'DESC';
                $argsPost['meta_query']['meta_price'] = [
                    'key'               => '_price',
                    'compare'           => 'EXISTS',
                ];
                break;

            case 'featured':
                $argsPost['tax_query'][] = array(
                    'taxonomy' => 'product_visibility',
                    'field'    => 'name',
                    'terms'    => 'featured',
                    'operator' => 'IN',
                );
                break;

            default:
                $argsPost['orderby']['meta_total_sales'] = 'DESC';
                $argsPost['meta_query']['meta_total_sales'] = [
                    'key'               => 'total_sales',
                    'value'             => intval(0),
                    'compare'           => '>=',
                    'type'               => 'NUMERIC'
                ];
                break;
        }
    }

    ob_start();
    $postsMONA = new WP_Query($argsPost);
    if ($postsMONA->have_posts()) { ?>

        <?php
        while ($postsMONA->have_posts()) {
            $postsMONA->the_post();
            $class_item = 'dsmall-item pro-item pro-item-3 product-mona';
        ?>
            <div class="<?php echo $class_item; ?>">
                <?php
                /**
                 * GET TEMPLATE PART
                 * product
                 */
                $slug = '/partials/loop/box';
                $name = 'product';
                echo get_template_part($slug, $name, ['keyword' => esc_attr($keyword)]);
                ?>
            </div>
        <?php }
        wp_reset_query(); ?>

        <div class="pagination-products-ajax pagination">
            <?php mona_pagination_links_ajax($postsMONA, $paged); ?>
        </div>

    <?php } else { ?>

        <div class="mona-empty-message-large">
            <p><?php echo __('No posts were found matching your search filter!', 'monamedia') ?></p>
        </div>

    <?php } ?>

    <?php
    $class_scroll = 'pro-list';
    wp_send_json_success(
        [
            'title'             => __('Alert!', 'monamedia'),
            'message'           =>  __('Successful!', 'monamedia'),
            'title_close'       =>  __('Close', 'monamedia'),
            'products_html'     => ob_get_clean(),
            'products_count'    => $postsMONA->have_posts() ? $postsMONA->found_posts : 0,
            'argsPosts'         => $argsPost,
            'scroll'            => $class_scroll,
            'keyword'           => esc_attr($keyword)
        ]
    );
    wp_die();
}


add_action('wp_ajax_mona_ajax_pagination_home',  'mona_ajax_pagination_home'); // login
add_action('wp_ajax_nopriv_mona_ajax_pagination_home',  'mona_ajax_pagination_home'); // no login
function mona_ajax_pagination_home()
{
    $form = array();
    check_ajax_referer('mona_ajax_nonce', 'nonce');

    $formdata = isset($_POST['formdata']) ? wp_unslash($_POST['formdata']) : '';
    if (!empty($formdata)) {
        parse_str($formdata, $form);
    }
    if (!is_array($form)) {
        $form = [];
    }
    $paged              = isset($_POST['paged']) ? absint($_POST['paged']) : 1;
    $action             = isset($_POST['action_layout']) ? sanitize_text_field($_POST['action_layout']) : 'reload';
    $flagAction         = isset($_POST['action_flag']) ? sanitize_text_field($_POST['action_flag']) : '';

    $action_return      = $action;
    $post_type          = !empty($form['post_type']) ? sanitize_key($form['post_type']) : 'post';
    $posts_per_page     = !empty($form['posts_per_page']) ? absint($form['posts_per_page']) : 9;
    $offset             = ($paged - 1) * $posts_per_page;
    $order              = 'DESC';
    $argsPost = array(
        'post_type' => $post_type,
        'post_status' => 'publish',
        'posts_per_page' => $posts_per_page,
        'paged' => $paged,
        'offset' => $offset,
        'meta_query' => [
            'relation' => 'AND',
        ],
        'tax_query' => [
            'relation' => 'AND',
        ]
    );

    /** Không được gỡ **/
    if ($flagAction == 'false' && $action == 'loadmore' && (isset($form['s']) || isset($form['sort']))) {
        $action_return = 'reload';
    }
    // product_cat
    if (!empty($form['all'])) {
        $argsPost = array(
            'post_type' => $post_type,
            'post_status' => 'publish',
            'posts_per_page' => $posts_per_page,
            'tax_query' => array(),
        );
    }

    // product_cat
    if (isset($form['tax']) && is_array($form['tax']) && !empty($form['tax'])) {
        foreach ($form['tax'] as $taxonomy => $slug) {
            $taxonomy = sanitize_key($taxonomy);
            $slug = sanitize_title($slug);
            if ($slug != '') {
                $argsPost['tax_query'][] =  array(
                    'taxonomy'  => $taxonomy,
                    'field'     => 'slug',
                    'terms'     => $slug,
                    'operator'  => 'IN'
                );
            }
        }
    }

    if ($post_type == 'product') {

        if (isset($form['prices']) && is_array($form['prices']) && !empty($form['prices'])) {

            $priceArray = $form['prices'];
            $postIDs_byPrice = [];

            global $wpdb;
            $sql = "SELECT DISTINCT p.ID
                FROM {$wpdb->prefix}posts AS p
                INNER JOIN {$wpdb->prefix}postmeta AS pm ON p.ID = pm.post_id
                WHERE p.post_type = 'product'
                AND p.post_status = 'publish'
                AND pm.meta_key = '_price'";

            $conditions = [];
            $params = [];
            foreach ($priceArray as $index => $price) {
                if (!is_array($price)) {
                    continue;
                }
                $active = isset($price['active']) ? sanitize_text_field($price['active']) : '';
                if (!empty($active)) {
                    $option = isset($price['option']) ? sanitize_text_field($price['option']) : '';
                    if ($option === 'less') {
                        $single = isset($price['single']) ? floatval($price['single']) : 0;
                        $conditions[] = "(pm.meta_value < %f)";
                        $params[] = $single;
                    } elseif ($option === 'range') {
                        $from = isset($price['from']) ? floatval($price['from']) : 0;
                        $to = isset($price['to']) ? floatval($price['to']) : 0;
                        $conditions[] = "(pm.meta_value >= %f AND pm.meta_value <= %f)";
                        $params[] = $from;
                        $params[] = $to;
                    } elseif ($option === 'more') {
                        $single = isset($price['single']) ? floatval($price['single']) : 0;
                        $conditions[] = "(pm.meta_value > %f)";
                        $params[] = $single;
                    }
                }
            }

            if (!empty($conditions)) {
                $sql .= ' AND (' . implode(' OR ', $conditions) . ')';
            }

            $prepared_sql = !empty($params) ? $wpdb->prepare($sql, $params) : $sql;
            $results = $wpdb->get_results($prepared_sql);
            if ($results) {
                foreach ($results as $result) {
                    $postIDs_byPrice[] = $result->ID;
                }

                if (is_array($postIDs_byPrice) && !empty($postIDs_byPrice)) {
                    $argsPost['post__in'] = $postIDs_byPrice;
                }
            }
        }

        if (isset($form['sort']) && !empty($form['sort'])) {
            $sort = $form['sort'];
            switch ($sort) {
                case 'az':
                    $argsPost['orderby'] = 'title';
                    $argsPost['order']   = 'ASC';
                    break;

                case 'za':
                    $argsPost['orderby'] = 'title';
                    $argsPost['order']   = 'DESC';
                    break;

                case 'lowtohigh':
                    $argsPost['orderby']['meta_price'] = 'ASC';
                    $argsPost['meta_query']['meta_price'] = [
                        'key'               => '_price',
                        'compare'           => 'EXISTS',
                    ];
                    break;

                case 'hightolow':
                    $argsPost['orderby']['meta_price'] = 'DESC';
                    $argsPost['meta_query']['meta_price'] = [
                        'key'               => '_price',
                        'compare'           => 'EXISTS',
                    ];
                    break;

                case 'featured':
                    $argsPost['tax_query'][] = array(
                        'taxonomy' => 'product_visibility',
                        'field'    => 'name',
                        'terms'    => 'featured',
                        'operator' => 'IN',
                    );
                    break;

                case 'total_sales':
                    $argsPost['orderby']['meta_total_sales'] = 'DESC';
                    $argsPost['meta_query']['meta_total_sales'] = [
                        'key'               => 'total_sales',
                        'value'             => intval(0),
                        'compare'           => '>=',
                        'type'               => 'NUMERIC'
                    ];
                    break;

                default:
                    $argsPost['orderby']['meta_total_sales'] = 'DESC';
                    $argsPost['meta_query']['meta_total_sales'] = [
                        'key'               => 'total_sales',
                        'value'             => intval(0),
                        'compare'           => '>=',
                        'type'               => 'NUMERIC'
                    ];
                    break;
            }
        }
    } else {

        if (isset($form['sort']) && !empty($form['sort'])) {
            $sort = esc_attr($form['sort']);
            switch ($sort) {
                case 'view':
                    $argsPost['meta_query']['meta_view'] = [
                        'key' => '_mona_post_view',
                        'value' => 0,
                        'compare' => '>=',
                        'type' => 'numeric',
                    ];
                    $argsPost['orderby']['meta_view'] = 'desc';
                    break;

                case 'asc':
                    $argsPost['order'] = 'asc';
                    break;

                default:
                    $argsPost['order'] = 'desc';
                    break;
            }
        } else {
            $argsPost['order'] = 'desc';
        }
    }


    ob_start();
    $postsMONA = new WP_Query($argsPost);
    if ($postsMONA->have_posts()) {
    ?>

        <?php
        $count = 0;
        while ($postsMONA->have_posts()) {
            $postsMONA->the_post();

        ?>

            <div class="swiper-slide">
                <div class="pro-item">
                    <?php
                    switch ($post_type) {

                        case 'product':

                            /**
                             * GET TEMPLATE PART
                             * product-inner
                             */
                            // $slug = '/partials/loop/product';
                            // $name = 'inner';
                            // echo get_template_part($slug, $name);

                            get_template_part('partials/product/item');
                            break;
                    }
                    ?>
                </div>
            </div>

        <?php
            $count++;
        }
        wp_reset_query(); ?>


        <?php if ($action == 'reload') { ?>

            <!-- <div class="pagination-posts-ajax pagination">
                <?php mona_pagination_links_ajax($postsMONA, $paged); ?>
            </div> -->

        <?php } else if ($action == 'loadmore') { ?>

            <?php if ($paged < $postsMONA->max_num_pages) { ?>
                <div class="btn-more monaLoadMoreJS is-loading-btn" data-paged="<?php echo ++$paged; ?>">
                    <span class="text">
                        <?php _e('Xem thêm', 'monamedia'); ?>
                    </span>
                </div>
            <?php } ?>

        <?php } ?>

    <?php } else { ?>

        <div class="container">
            <div class="empty-product">
                <a class="image-empty-product" href="<?php echo home_url(); ?>">
                    <img src="<?php echo esc_url(get_site_url()); ?>/template/assets/images/empty-cart-curnon.png" alt="this is a image of empty product">
                </a>
                <p class="text">
                    <?php _e('Hiện tại, sản phẩm bạn tìm kiếm hiện đang cập nhật. Vui lòng quay lại sau hoặc liên hệ với chúng tôi.', 'monamedia'); ?>
                </p>
                <?php if (is_cart()) : ?>
                    <a class="btn btn-pri" href="<?php echo home_url(); ?>">
                        <span class="text"> <?php _e('TIẾP TỤC MUA SẮM', 'monamedia') ?></span>
                    </a>
                <?php endif; ?>
            </div>
        </div>

    <?php } ?>

<?php
    switch ($post_type) {
        default:
            $class_scroll = 'monaPostsList';
            break;
    }
    wp_send_json_success(
        [
            'title'         => __('Thông báo!', 'monamedia'),
            'message'       =>  __('Load thêm thành công!', 'monamedia'),
            'title_close'   =>  __('Đóng', 'monamedia'),
            'posts_html'    => ob_get_clean(),
            'argsPosts'     => $argsPost,
            'scroll'        => $class_scroll,
            'action_return' => $action_return
        ]
    );
    wp_die();
}
