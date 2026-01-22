<?php

/**
 * Undocumented function
 *
 * @return void
 */
function add_after_setup_theme()
{
    // regsiter menu
    register_nav_menus(
        [
            'primary-menu'  => __('Theme Main Menu', 'monamedia'),
            'about-menu'    => __('Theme About Menu', 'monamedia'),
            'mobile-menu'   => __('Theme Mobile Menu', 'monamedia'),
            'footer-menu'   => __('Theme Footer Menu', 'monamedia'),
            'footer-menu-2' => __('Theme Footer Menu 2', 'monamedia'),
            'footer-menu-3' => __('Theme Footer Menu 3', 'monamedia'),
            'footer-menu-4' => __('Theme Footer Menu 4', 'monamedia'),
        ]
    );
    // add size image
    add_image_size('banner-desktop-image', 1920, 790, false);
    add_image_size('banner-mobile-image', 400, 675, false);
    add_image_size('600x600', 600, 600, false);
    add_image_size('600x400', 600, 400, false);
}
add_action('after_setup_theme', 'add_after_setup_theme');

/**
 * Undocumented function
 *
 * @return void
 */
function mona_add_styles_scripts()
{
    $theme_dir = get_template_directory();
    $theme_uri = get_template_directory_uri();
    $assets_base = defined('MONA_HOME_URL') ? MONA_HOME_URL : get_site_url();
    $template_assets_url = $assets_base . '/template/assets';
    $template_js_url = $assets_base . '/template/js';

    $main_style_path = $theme_dir . '/public/builder/css/style.css';
    $backdoor_style_path = $theme_dir . '/public/builder/css/backdoor.css';
    $custom_style_path = $theme_dir . '/public/helpers/css/mona-custom.css';
    $frontend_script_path = $theme_dir . '/public/helpers/scripts/mona-frontend.js';

    wp_enqueue_style(
        'mona-style',
        $theme_uri . '/public/builder/css/style.css',
        [],
        file_exists($main_style_path) ? filemtime($main_style_path) : null
    );
    wp_enqueue_style(
        'mona-backdoor',
        $theme_uri . '/public/builder/css/backdoor.css',
        ['mona-style'],
        file_exists($backdoor_style_path) ? filemtime($backdoor_style_path) : null
    );
    wp_enqueue_style(
        'mona-custom',
        $theme_uri . '/public/helpers/css/mona-custom.css',
        ['mona-style'],
        file_exists($custom_style_path) ? filemtime($custom_style_path) : null
    );
    wp_enqueue_script(
        'mona-frontend',
        $theme_uri . '/public/helpers/scripts/mona-frontend.js',
        ['jquery'],
        file_exists($frontend_script_path) ? filemtime($frontend_script_path) : null,
        true
    );
    wp_enqueue_script(
        'mona-swiper',
        $template_assets_url . '/library/swiper/swiper-bundle.min.js',
        [],
        null,
        true
    );
    wp_enqueue_script(
        'mona-aos',
        $template_assets_url . '/library/aos/aos.js',
        [],
        null,
        true
    );
    wp_enqueue_script(
        'mona-lightgallery',
        $template_assets_url . '/library/gallery/lightgallery-all.min.js',
        [],
        null,
        true
    );
    wp_enqueue_script(
        'mona-jquery-migrate',
        $template_assets_url . '/library/jquery/jquery-migrate.js',
        ['jquery'],
        null,
        true
    );
    wp_enqueue_script(
        'mona-fancybox',
        $template_assets_url . '/library/fancybox/fancybox.umd.js',
        ['jquery'],
        null,
        true
    );
    wp_enqueue_script(
        'mona-moment',
        $template_assets_url . '/library/datetime/moment.min.js',
        [],
        null,
        true
    );
    wp_enqueue_script(
        'mona-daterangepicker',
        $template_assets_url . '/library/datetime/daterangepicker.min.js',
        ['jquery', 'mona-moment'],
        null,
        true
    );
    wp_enqueue_script(
        'mona-main',
        $template_js_url . '/main.js',
        [
            'jquery',
            'mona-swiper',
            'mona-aos',
            'mona-lightgallery',
            'mona-fancybox',
            'mona-daterangepicker',
        ],
        null,
        true
    );
    wp_localize_script(
        'mona-frontend',
        'mona_ajax_url',
        [
            'ajaxURL' => admin_url('admin-ajax.php'),
            'siteURL' => get_site_url(),
            'nonce' => wp_create_nonce('mona_ajax_nonce'),
        ]
    );
}
add_action('wp_enqueue_scripts', 'mona_add_styles_scripts');

/**
 * Undocumented function
 *
 * @param [type] $tag
 * @param [type] $handle
 * @param [type] $src
 * @return void
 */
function mona_add_module_to_my_script($tag, $handle, $src)
{
    if (in_array($handle, ['mona-frontend', 'mona-main'], true)) {
        $tag = '<script type="module" src="' . esc_url($src) . '"></script>';
    }
    return $tag;
}
add_filter('script_loader_tag', 'mona_add_module_to_my_script', 10, 3);

/**
 * Undocumented function
 *
 * @return void
 */
function mona_redirect_external_after_logout()
{
    wp_redirect(get_the_permalink(MONA_PAGE_HOME));
    exit();
}
//add_action( 'wp_logout', 'mona_redirect_external_after_logout' );

/**
 * Undocumented function
 *
 * @param [type] $query
 * @return void
 */
function mona_parse_request_post_type($query)
{
    if (!is_admin()) {
        $query->set('ignore_sticky_posts', true);
        $ptype = $query->get('post_type', true);
        $ptype = (array) $ptype;

        if (isset($_GET['s']) && is_search()) {
            $ptype[] = 'product';
            $query->set('post_type', $ptype);
            $query->set('posts_per_page', 12);
        }

        // if ( $query->is_main_query() && $query->is_tax( 'category_library' ) ) {
        //     $ptype[] = 'mona_library';
        //     $query->set('post_type', $ptype);
        //     $query->set('posts_per_page', 12);
        // }

    }
    return $query;
}
add_filter('pre_get_posts', 'mona_parse_request_post_type');

/**
 * Undocumented function
 *
 * @return void
 */
function mona_register_sidebars()
{
    register_sidebar(
        [
            'id'            => 'footer_column1',
            'name'          => __('Footer Column 1', 'mona-admin'),
            'description'   => __('Widget Content.', 'mona-admin'),
            'before_widget' => '<div id="%1$s" class="widget footer-menu-item footer-menu-item-first %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<div class="mona-widget-title">',
            'after_title'   => '</div>',
        ]
    );

    register_sidebar(
        [
            'id'            => 'footer_column2',
            'name'          => __('Footer Column 2', 'mona-admin'),
            'description'   => __('Widget Content.', 'mona-admin'),
            'before_widget' => '<div id="%1$s" class="widget footer-menu-item footer-menu-item-second %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<div class="mona-widget-title">',
            'after_title'   => '</div>',
        ]
    );

    register_sidebar(
        [
            'id'            => 'footer_column3',
            'name'          => __('Footer Column 3', 'mona-admin'),
            'description'   => __('Widget Content.', 'mona-admin'),
            'before_widget' => '<div id="%1$s" class="widget footer-menu-item footer-menu-item-third %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<div class="mona-widget-title">',
            'after_title'   => '</div>',
        ]
    );

    register_sidebar(
        [
            'id'            => 'footer_description',
            'name'          => __('Footer Description', 'mona-admin'),
            'description'   => __('Widget Content.', 'mona-admin'),
            'before_widget' => '<div id="%1$s" class="widget footer-description %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<div class="mona-widget-title">',
            'after_title'   => '</div>',
        ]
    );
}
add_action('widgets_init', 'mona_register_sidebars');

/**
 * Undocumented function
 *
 * @param [type] $post_states
 * @param [type] $post
 * @return void
 */
function mona_add_post_state($post_states, $post)
{
    if ($post->ID == MONA_PAGE_HOME) {
        $post_states[] = __('PAGE - Trang chủ', 'mona-admin');
    }
    if ($post->ID == MONA_PAGE_BLOG) {
        $post_states[] = __('PAGE - Trang Tin tức', 'mona-admin');
    }
    return $post_states;
}
//add_filter( 'display_post_states', 'mona_add_post_state', 10, 2 );

/**
 * Undocumented function
 *
 * @param [type] $html
 * @return void
 */
function mona_change_logo_class($html)
{
    $custom_logo_id = get_theme_mod('custom_logo');
    $html           = sprintf(
        '<a href="%1$s" class="custom-logo-link" rel="home" itemprop="url">%2$s</a>',
        esc_url(home_url()),
        wp_get_attachment_image(
            $custom_logo_id,
            'full',
            false,
            [
                'class'  => 'header-logo-image',
            ]
        )
    );
    return $html;
}
add_filter('get_custom_logo', 'mona_change_logo_class');

/**
 * Undocumented function
 *
 * @param [type] $url
 * @param [type] $path
 * @param [type] $blog_id
 * @return void
 */
function mona_filter_admin_url($url, $path, $blog_id)
{
    if ($path === 'admin-ajax.php' && !is_admin()) {
        $url .= '?mona-ajax';
    }
    return $url;
}
add_filter('admin_url', 'mona_filter_admin_url', 999, 3);

function change_wp_admin_bar_logo($wp_admin_bar)
{
    // Add a new logo with a custom image
    $args = array(
        'id' => 'wp-logo',
        // 'title' => '<img src="' . get_stylesheet_directory_uri() . '/public/helpers/images/icon-fav.svg" alt="">',
        'title' => '<img src="' . get_site_icon_url() . '" alt="">',
        'href' => home_url() . '/wp-admin/about.php',
        'meta' => array(
            'class' => 'custom-logo',
            'title' => __('My Logo'),
        ),
    );
    $wp_admin_bar->add_node($args);
}
add_action('admin_bar_menu', 'change_wp_admin_bar_logo', 999);

function getLogoCustomHtml()
{
    $custom_logo_id     = get_theme_mod('custom_logo');
    $custom_logo_url    = wp_get_attachment_image_url($custom_logo_id, 'full');
    $site_title = get_bloginfo('name');
    $user_id = get_current_user_id(); // Replace with the user ID you want to get the profile URL for
    $user_profile_url = admin_url('profile.php');
    ob_start(); ?>
    <div class="overview-profile">
        <?php if (!empty($custom_logo_url)) { ?>
            <div class="overview-profile-logo">
                <img src="<?php echo esc_url($custom_logo_url); ?>" alt="logo" />
            </div>
        <?php } ?>
        <?php if (!empty($site_title)) { ?>
            <div class="overview-profile-title">
                <?php echo esc_html($site_title); ?>
            </div>
        <?php } ?>
        <div class="overview-profile-action">
            <div class="overview-profile-user">
                <span class="monaRedirectAdmin" data-redirect="<?php echo esc_url($user_profile_url); ?>">
                    <img src="<?php echo get_template_directory_uri(); ?>/public/helpers/images/ic-admin-user.svg" />
                </span>
            </div>
            <div class="overview-profile-logout">
                <span class="monaRedirectAdmin" data-redirect="<?php echo esc_url(wp_logout_url(home_url('/wp-login.php'))); ?>">
                    <img src="<?php echo get_template_directory_uri(); ?>/public/helpers/images/ic-admin-logout.svg" />
                </span>
            </div>
        </div>
    </div>

<?php
    return ob_get_clean();
}

function add_html_at_top_of_first_menu_item()
{
    global $menu;
    $html = getLogoCustomHtml();
    $new_menu_item = array($html, 'read', 'javascript:;', '', 'wp-menu-overview-profile');
    // Add your custom HTML code in the first element of this array
    array_unshift($menu, $new_menu_item);
}
add_action('admin_menu', 'add_html_at_top_of_first_menu_item');

add_action('admin_enqueue_scripts', 'mona_admin_styles_scripts');
function mona_admin_styles_scripts()
{
    wp_enqueue_style('mona-custom-admin', get_template_directory_uri() . '/public/helpers/css/mona-custom-admin.css', array(), rand());
    wp_enqueue_script('mona-backend', get_template_directory_uri() . '/public/helpers/scripts/mona-admin.js', array(), false, true);
    wp_localize_script(
        'mona-backend',
        'mona_ajax_backend_url',
        [
            'ajaxURL' => admin_url('admin-ajax.php'),
            'siteURL' => get_site_url(),
        ]
    );
}

add_filter(
    'admin_footer_text',
    function ($footer_text) {
        $footer_text = 'Powered by <a href="https://mona.media/" target="_blank" rel="noopener">MONA.Media</a>';
        return $footer_text;
    }
);
// fragment 
add_action('wp_ajax_mona_cart_fragments',  'mona_cart_fragments'); // login
add_action('wp_ajax_nopriv_mona_cart_fragments',  'mona_cart_fragments'); // no login
function mona_cart_fragments()
{
    check_ajax_referer('mona_ajax_nonce', 'nonce');
    wp_send_json_success(
        WC_AJAX::get_refreshed_fragments()
    );
}

add_filter('woocommerce_add_to_cart_fragments', 'mona_cart_count_fragments', 10, 1);

function mona_cart_count_fragments($fragments)
{
    ob_start();
    woocommerce_mini_cart();
    $mini_cart_content = ob_get_clean();

    $fragments['#mona-cart-qty'] = '<span class="text num" id="mona-cart-qty">(' . WC()->cart->get_cart_contents_count() . ')</span>';

    $fragments['#m_mini_cart'] = '<div class="bds widget_shopping_cart_content" id="m_mini_cart">' . $mini_cart_content . '</div>';

    $fragments['#update-qty'] = ' <p class="hds-text" id="update-qty">(' . WC()->cart->get_cart_contents_count() . ')</div>';

    $fragments['#total-cart'] = '<p class="val" id="total-cart">' . wc_price(WC()->cart->get_cart_contents_total()) . '</div>';

    $fragments['#mona-checkout-qty'] = '<h2 class="title fw-6 f-title"  id="mona-checkout-qty">GIỎ HÀNG ' . WC()->cart->get_cart_contents_count() . '</h2>';

    return $fragments;
}
add_action('wp_ajax_apply_coupon_action', 'apply_coupon_action');
add_action('wp_ajax_nopriv_apply_coupon_action', 'apply_coupon_action');
function apply_coupon_action()
{
    check_ajax_referer('mona_ajax_nonce', 'nonce');

    $coupon_code = '';
    if (isset($_POST['coupon_code'])) {
        $coupon_code = sanitize_text_field(wp_unslash($_POST['coupon_code']));
    }
    $user_id = get_current_user_id();
    if ($user_id) {
        $user_coupon_codes = get_user_meta($user_id, 'coupon_codes', true);
        if (!is_array($user_coupon_codes)) {
            $user_coupon_codes = [];
        }
        $user_coupon_codes = array_unique($user_coupon_codes);
        update_user_meta($user_id, 'coupon_codes', $user_coupon_codes);
    }

    // Set a session cookie to remember the coupon if they continue shopping.
	WC()->session->set_customer_session_cookie(true);

    if (!empty($coupon_code) && !WC()->cart->has_discount($coupon_code)) {
        WC()->cart->add_discount($coupon_code);
        wp_send_json_success(
            [
                'title' => __('Thông báo!', 'monamedia'),
                'mess'  =>  __('Áp dụng mã giảm thành công', 'monamedia'),
            ]
        );
        wp_die();
    } else {
        wp_send_json_error(
            [
                'title' => __('Thông báo!', 'monamedia'),
                'mess'  =>  __('Mã code đã sử dụng trước đó hoặc không tồn tại.', 'monamedia'),
            ]
        );
        wp_die();
    }
    wp_die();
}
/*
* Remove product-category in URL
* Thay product-category bằng slug hiện tại của bạn. Mặc định là product-category
*/
add_filter('term_link', 'devvn_product_cat_permalink', 10, 3);
function devvn_product_cat_permalink($url, $term, $taxonomy)
{
    switch ($taxonomy):
        case 'product_cat':
            $taxonomy_slug = 'danh-muc-san-pham'; //Thay bằng slug hiện tại của bạn. Mặc định là product-category
            if (strpos($url, $taxonomy_slug) === FALSE) break;
            $url = str_replace('/' . $taxonomy_slug, '', $url);
            break;
        case 'category_thuong_hieu':
            $taxonomy_slug = 'category-thuong-hieu'; //Thay bằng slug hiện tại của bạn. Mặc định là product-category
            if (strpos($url, $taxonomy_slug) === FALSE) break;
            $url = str_replace('/' . $taxonomy_slug, '', $url);
            break;
        case 'category_nuoc_hoa':
            $taxonomy_slug = 'category-nuoc-hoa'; //Thay bằng slug hiện tại của bạn. Mặc định là product-category
            if (strpos($url, $taxonomy_slug) === FALSE) break;
            $url = str_replace('/' . $taxonomy_slug, '', $url);
            break;
        case 'category_nong_do':
            $taxonomy_slug = 'category-nong-do'; //Thay bằng slug hiện tại của bạn. Mặc định là product-category
            if (strpos($url, $taxonomy_slug) === FALSE) break;
            $url = str_replace('/' . $taxonomy_slug, '', $url);
            break;
        case 'category_nhom_huong':
            $taxonomy_slug = 'category-nhom-huong'; //Thay bằng slug hiện tại của bạn. Mặc định là product-category
            if (strpos($url, $taxonomy_slug) === FALSE) break;
            $url = str_replace('/' . $taxonomy_slug, '', $url);
            break;
        case 'category_dung_tich':
            $taxonomy_slug = 'category-dung-tich'; //Thay bằng slug hiện tại của bạn. Mặc định là product-category
            if (strpos($url, $taxonomy_slug) === FALSE) break;
            $url = str_replace('/' . $taxonomy_slug, '', $url);
            break;
    endswitch;
    return $url;
}
// Add our custom product cat rewrite rules
function devvn_product_category_rewrite_rules($flash = false)
{
    $taxonomies = array('product_cat', 'category_thuong_hieu', 'category_nuoc_hoa', 'category_nong_do', 'category_nhom_huong', 'category_dung_tich'); // Thêm taxonomy mới vào đây nếu có
    foreach ($taxonomies as $taxonomy) {
        $terms = get_terms(array(
            'taxonomy' => $taxonomy,
            'post_type' => 'product', // Thay đổi nếu có post type khác
            'hide_empty' => false,
        ));
        if ($terms && !is_wp_error($terms)) {
            $siteurl = esc_url(home_url('/'));
            foreach ($terms as $term) {
                $term_slug = $term->slug;
                $baseterm = str_replace($siteurl, '', get_term_link($term->term_id, $taxonomy));
                add_rewrite_rule($baseterm . '?$', 'index.php?' . $taxonomy . '=' . $term_slug, 'top');
                add_rewrite_rule($baseterm . 'page/([0-9]{1,})/?$', 'index.php?' . $taxonomy . '=' . $term_slug . '&paged=$matches[1]', 'top');
                add_rewrite_rule($baseterm . '(?:feed/)?(feed|rdf|rss|rss2|atom)/?$', 'index.php?' . $taxonomy . '=' . $term_slug . '&feed=$matches[1]', 'top');
            }
        }
    }
    if ($flash == true)
        flush_rewrite_rules(false);
}
add_action('init', 'devvn_product_category_rewrite_rules');

/*Sửa lỗi khi tạo mới taxomony bị 404*/
add_action('create_term', 'devvn_new_product_cat_edit_success', 10, 2);
function devvn_new_product_cat_edit_success($term_id, $taxonomy)
{
    devvn_product_category_rewrite_rules(true);
}

/*
* Code Bỏ /product/ hoặc /cua-hang/ hoặc /shop/ ... có hỗ trợ dạng %product_cat%
* Thay /cua-hang/ bằng slug hiện tại của bạn
*/
function devvn_remove_slug($post_link, $post)
{
    if (!in_array(get_post_type($post), array('product')) || 'publish' != $post->post_status) {
        return $post_link;
    }
    if ('product' == $post->post_type) {
        $post_link = str_replace('/san-pham/', '/', $post_link); //Thay cua-hang bằng slug hiện tại của bạn
    } else {
        $post_link = str_replace('/' . $post->post_type . '/', '/', $post_link);
    }
    return $post_link;
}


add_filter('post_type_link', 'devvn_remove_slug', 10, 2);
/*Sửa lỗi 404 sau khi đã remove slug product hoặc cua-hang*/
function devvn_woo_product_rewrite_rules($flash = false)
{
    global $wp_post_types, $wpdb;
    $siteLink = esc_url(home_url('/'));
    foreach ($wp_post_types as $type => $custom_post) {
        if ($type == 'product') {
            if ($custom_post->_builtin == false) {
                $querystr = "SELECT {$wpdb->posts}.post_name, {$wpdb->posts}.ID
                            FROM {$wpdb->posts} 
                            WHERE {$wpdb->posts}.post_status = 'publish' 
                            AND {$wpdb->posts}.post_type = '{$type}'";
                $posts = $wpdb->get_results($querystr, OBJECT);
                foreach ($posts as $post) {
                    $current_slug = get_permalink($post->ID);
                    $base_product = str_replace($siteLink, '', $current_slug);
                    add_rewrite_rule($base_product . '?$', "index.php?{$custom_post->query_var}={$post->post_name}", 'top');
                    add_rewrite_rule($base_product . 'comment-page-([0-9]{1,})/?$', 'index.php?' . $custom_post->query_var . '=' . $post->post_name . '&cpage=$matches[1]', 'top');
                    add_rewrite_rule($base_product . '(?:feed/)?(feed|rdf|rss|rss2|atom)/?$', 'index.php?' . $custom_post->query_var . '=' . $post->post_name . '&feed=$matches[1]', 'top');
                }
            }
        }
    }
    if ($flash == true)
        flush_rewrite_rules(false);
}
add_action('init', 'devvn_woo_product_rewrite_rules');


/*Fix lỗi khi tạo sản phẩm mới bị 404*/
function devvn_woo_new_product_post_save($post_id)
{
    global $wp_post_types;
    $post_type = get_post_type($post_id);
    foreach ($wp_post_types as $type => $custom_post) {
        if ($custom_post->_builtin == false && $type == $post_type) {
            devvn_woo_product_rewrite_rules(true);
        }
    }
}
add_action('wp_insert_post', 'devvn_woo_new_product_post_save');

// Hook vào quá trình thanh toán thành công
// add_action('woocommerce_payment_complete', 'update_shipping_info_on_payment_complete', 10, 1);
// function update_shipping_info_on_payment_complete($order_id)
// {
//     // Lấy đối tượng đơn
//     $order = wc_get_order($order_id);

//     // Kiểm tra xem order có tồn tại không
//     if (!$order) {
//         return;
//     }

//     // Lấy thông tin địa chỉ giao hàng từ đơn hàng
//     $shipping_first_name = $order->get_shipping_first_name();
//     $shipping_last_name  = $order->get_shipping_last_name();
//     $shipping_email      = $order->get_billing_email();
//     $shipping_phone      = $order->get_billing_phone();
//     $shipping_state      = $order->get_shipping_state();
//     $shipping_city       = $order->get_shipping_city();
//     $shipping_address_1  = $order->get_shipping_address_1();
//     $shipping_address_2  = $order->get_shipping_address_2();

//     // Lấy user ID từ đơn hàng
//     $user_id = $order->get_user_id();

//     // Cập nhật thông tin vận chuyển cho người dùng
//     update_user_meta($user_id, "shipping_first_name", $shipping_first_name);
//     update_user_meta($user_id, "shipping_last_name", $shipping_last_name);
//     update_user_meta($user_id, "shipping_email", $shipping_email);
//     update_user_meta($user_id, "shipping_phone", $shipping_phone);
//     update_user_meta($user_id, "shipping_state", $shipping_state);
//     update_user_meta($user_id, "shipping_city", $shipping_city);
//     update_user_meta($user_id, "shipping_address_1", $shipping_address_1);
//     update_user_meta($user_id, "shipping_address_2", $shipping_address_2);
// }

function apply_gift_discount($cart)
{
    if (is_admin() && !defined('DOING_AJAX')) {
        return;
    }

    foreach ($cart->get_cart() as $cart_item) {
        if (!empty($cart_item['mona_data']['select_gift']) && $cart_item['mona_data']['select_gift'] === 'on') {
            // if (!empty($cart_item['mona_data']['select_content']) && $cart_item['mona_data']['select_content'] === '') {
            $discount = 30000;
            $cart_item['data']->set_price($cart_item['data']->get_price() + $discount);
            // }
        }
    }
}
// add_action('woocommerce_before_calculate_totals', 'apply_gift_discount');

add_action('woocommerce_checkout_create_order_line_item', 'save_gift_data_to_order', 10, 4);
function save_gift_data_to_order($item, $cart_item_key, $values, $order)
{
    if ($values['mona_data']['select_gift'] === 'on') {
        if(!empty($values['mona_data']['select_content'])){
            $item->add_meta_data(__('Nội dung gói quà', 'text-domain'), esc_html($values['mona_data']['select_content']));
        }else{
            $item->add_meta_data(__('Nội dung gói quà', 'text-domain'), esc_html('Thắt nơ + thiệp - Miễn phí'));

        }
    }
}

add_action('woocommerce_order_item_meta_end', 'display_gift_info_in_order_meta', 10, 4);
function display_gift_info_in_order_meta($item_id, $item, $order, $plain_text)
{
    // Kiểm tra nếu sản phẩm có chứa quà tặng
    $select_gift = $item->get_meta('_select_gift');
    if (!empty($select_gift) && $select_gift === 'on') {
        $select_content = $item->get_meta('_select_content');
        echo '<p><strong>' . __('Nội dung gói quà:', 'text-domain') . '</strong> ' . esc_html($select_content) . '</p>';
    }
}

add_action('woocommerce_new_order', 'save_gift_data_to_order_meta', 10, 1);
function save_gift_data_to_order_meta($order_id)
{
    $order = wc_get_order($order_id);

    foreach ($order->get_items() as $item_id => $item) {
        $select_gift = $item->get_meta('_select_gift');
        if (!empty($select_gift) && $select_gift === 'on') {
            $select_content = $item->get_meta('_select_content');
            // update_post_meta($order_id, '_select_content_' . $item_id, $select_content);
            $order->update_meta_data('_select_content_' . $item_id, $select_content);
        }
    }

    $order->save();
}
