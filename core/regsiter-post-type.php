<?php

/**
 * Undocumented function
 *
 * @return void
 */
function mona_regsiter_custom_post_types()
{

    // $posttype_product = [
    //     'labels' => [
    //         'name'          => __('Products', 'mona-admin'),
    //         'singular_name' => __('Product', 'mona-admin'),
    //         'all_items'     => __( 'All', 'mona-admin' ),
    //         'add_new'       => __( 'Add', 'mona-admin' ),
    //         'add_new_item'  => __( 'New Product', 'mona-admin' ),
    //         'edit_item'     => __( 'Edit', 'mona-admin' ),
    //         'new_item'      => __( 'Add', 'mona-admin' ),
    //         'view_item'     => __( 'View', 'mona-admin' ),
    //         'view_items'    => __( 'View', 'mona-admin' ),
    //     ],
    //     'description' => __('Add','mona-admin'),
    //     'supports'    => [
    //         'title',
    //         'editor',
    //         'author',
    //         'thumbnail',
    //         'comments',
    //         'revisions',
    //         'custom-fields',
    //         'excerpt',
    //     ],
    //     'taxonomies'   => array( 'product_cat' ),
    //     'hierarchical' => false,
    //     'show_in_rest' => true,
    //     'public'       => true,
    //     'has_archive'  => true,
    //     'rewrite'      => [
    //         'slug' => 'product-detail',
    //         'with_front' => true
    //     ],
    //     'show_ui'             => true,
    //     'show_in_menu'        => true,
    //     'show_in_nav_menus'   => true,
    //     'show_in_admin_bar'   => true,
    //     'menu_position'       => 5,
    //     'menu_icon'           => 'dashicons-book-alt',
    //     'can_export'          => true,
    //     'has_archive'         => true,
    //     'exclude_from_search' => true,
    //     'publicly_queryable'  => true,
    //     'capability_type'     => 'post'
    // ];
    // register_post_type( 'product', $posttype_product );
    // $taxonomy_product_cat = array(
    //     'labels' => array(
    //         'name'              => __('Categories [product]', 'monamedia'),
    //         'singular_name'     => __('Category [product]', 'monamedia'),
    //         'search_items'      => __('Search', 'monamedia'),
    //         'all_items'         => __('All', 'monamedia'),
    //         'parent_item'       => __('Category', 'monamedia'),
    //         'parent_item_colon' => __('Category', 'monamedia'),
    //         'edit_item'         => __('Edit', 'monamedia'),
    //         'add_new'           => __('Add', 'monamedia'),
    //         'update_item'       => __('Update', 'monamedia'),
    //         'add_new_item'      => __('Add', 'monamedia'),
    //         'new_item_name'     => __('Add', 'monamedia'),
    //         'menu_name'         => __('Categories [product]', 'monamedia'),
    //     ),
    //     'hierarchical'      => true,
    //     'show_in_rest'      => true,
    //     'show_admin_column' => true,
    //     'has_archive'       => true,
    //     'public'            => true,
    //     'rewrite'           => array(
    //         'slug'       => 'product-cat',
    //         'with_front' => true
    //     ),
    //     'capabilities' => array(
    //         'manage_terms' => 'publish_posts',
    //         'edit_terms'   => 'publish_posts',
    //         'delete_terms' => 'publish_posts',
    //         'assign_terms' => 'publish_posts',
    //     ),
    // );
    // register_taxonomy('product_cat', 'product', $taxonomy_product_cat);
    //policy
    $posttype_policy = [
        'labels' => [
            'name'          => __('Policy', 'mona-admin'),
            'singular_name' => __('Policy', 'mona-admin'),
            'all_items'     => __('All Posts', 'mona-admin'),
            'add_new'       => __('Add New', 'mona-admin'),
            'add_new_item'  => __('New Post', 'mona-admin'),
            'edit_item'     => __('Edit Post', 'mona-admin'),
            'new_item'      => __('Add Post ', 'mona-admin'),
            'view_item'     => __('View Post', 'mona-admin'),
            'view_items'    => __('View Post ', 'mona-admin'),
        ],
        'description' => __('Add Post', 'mona-admin'),
        'supports'    => [
            'title',
            'editor',
            'author',
            'thumbnail',
            'comments',
            'revisions',
            'custom-fields',
            'excerpt',
        ],
        'taxonomies'   => array('category_policy'),
        'hierarchical' => false,
        'show_in_rest' => true,
        'public'       => true,
        'has_archive'  => true,
        'rewrite'      => [
            'slug' => 'category-policy',
            'with_front' => true
        ],
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 5,
        'menu_icon'           => 'dashicons-book-alt',
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => true,
        'publicly_queryable'  => true,
        'capability_type'     => 'post'
    ];
    register_post_type('mona_policy', $posttype_policy);
    $taxonomy_policy = array(
        'labels' => array(
            'name'              => __('Category - Policy', 'monamedia'),
            'singular_name'     => __('Category - Policy', 'monamedia'),
            'search_items'      => __('Search', 'mona-admin'),
            'all_items'         => __('Alls', 'mona-admin'),
            'parent_item'       => __('Category Policy', 'mona-admin'),
            'parent_item_colon' => __('Category Policy', 'mona-admin'),
            'edit_item'         => __('Edit', 'mona-admin'),
            'add_new'           => __('Add New', 'mona-admin'),
            'update_item'       => __('Update', 'mona-admin'),
            'add_new_item'      => __('Add New', 'mona-admin'),
            'new_item_name'     => __('Add New', 'mona-admin'),
            'menu_name'         => __('Category Policy', 'mona-admin'),
        ),
        'hierarchical'      => true,
        'show_in_rest'      => true,
        'show_admin_column' => true,
        'has_archive'       => true,
        'public'            => true,
        'rewrite'           => array(
            'slug'       => 'category-policy',
            'with_front' => true
        ),
        'capabilities' => array(
            'manage_terms' => 'publish_posts',
            'edit_terms'   => 'publish_posts',
            'delete_terms' => 'publish_posts',
            'assign_terms' => 'publish_posts',
        ),
    );
    register_taxonomy('category_policy', 'mona_policy', $taxonomy_policy);

    $posttype_dia_chi = [
        'labels' => [
            'name'          => __('Địa chỉ', 'mona-admin'),
            'singular_name' => __('Địa chỉ', 'mona-admin'),
            'all_items'     => __('All Posts', 'mona-admin'),
            'add_new'       => __('Add New', 'mona-admin'),
            'add_new_item'  => __('New Post', 'mona-admin'),
            'edit_item'     => __('Edit Post', 'mona-admin'),
            'new_item'      => __('Add Post ', 'mona-admin'),
            'view_item'     => __('View Post', 'mona-admin'),
            'view_items'    => __('View Post ', 'mona-admin'),
        ],
        'description' => __('Add Post', 'mona-admin'),
        'supports'    => [
            'title',
            'editor',
            'author',
            'thumbnail',
            'comments',
            'revisions',
            'custom-fields',
            'excerpt',
        ],
        'taxonomies'   => array('category_dia_chi'),
        'hierarchical' => false,
        'show_in_rest' => true,
        'public'       => true,
        'has_archive'  => true,
        'rewrite'      => [
            'slug' => 'category-dia-chi',
            'with_front' => true
        ],
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 5,
        'menu_icon'           => 'dashicons-location-alt',
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => true,
        'publicly_queryable'  => true,
        'capability_type'     => 'post'
    ];
    register_post_type('mona_dia_chi', $posttype_dia_chi);
    $taxonomy_dia_chi = array(
        'labels' => array(
            'name'              => __('Thành Phố', 'monamedia'),
            'singular_name'     => __('Thành Phố', 'monamedia'),
            'search_items'      => __('Search', 'mona-admin'),
            'all_items'         => __('Alls', 'mona-admin'),
            'parent_item'       => __('Thành Phố', 'mona-admin'),
            'parent_item_colon' => __('Thành Phố', 'mona-admin'),
            'edit_item'         => __('Edit', 'mona-admin'),
            'add_new'           => __('Add New', 'mona-admin'),
            'update_item'       => __('Update', 'mona-admin'),
            'add_new_item'      => __('Add New', 'mona-admin'),
            'new_item_name'     => __('Add New', 'mona-admin'),
            'menu_name'         => __('Thành Phố', 'mona-admin'),
        ),
        'hierarchical'      => true,
        'show_in_rest'      => true,
        'show_admin_column' => true,
        'has_archive'       => true,
        'public'            => true,
        'rewrite'           => array(
            'slug'       => 'category-thanh-pho',
            'with_front' => true
        ),
        'capabilities' => array(
            'manage_terms' => 'publish_posts',
            'edit_terms'   => 'publish_posts',
            'delete_terms' => 'publish_posts',
            'assign_terms' => 'publish_posts',
        ),
    );
    register_taxonomy('category_dia_chi', 'mona_dia_chi', $taxonomy_dia_chi);

    // Màu sắc
    $labels_mau_sac = array(
        'name'              => __('Màu sắc', 'monamedia'),
        'singular_name'     => __('Màu sắc', 'monamedia'),
        'search_items'      => __('Tìm Kiếm', 'mona-admin'),
        'all_items'         => __('Tất Cả', 'mona-admin'),
        'parent_item'       => __('Màu sắc', 'mona-admin'),
        'parent_item_colon' => __('Màu sắc', 'mona-admin'),
        'edit_item'         => __('Chỉnh Sửa', 'mona-admin'),
        'add_new'           => __('Thêm Mới', 'mona-admin'),
        'update_item'       => __('Cập Nhật', 'mona-admin'),
        'add_new_item'      => __('Thêm Mới', 'mona-admin'),
        'new_item_name'     => __('Thêm Mới', 'mona-admin'),
        'menu_name'         => __('Danh mục màu sắc', 'mona-admin'),
    );

    $taxonomy_san_pham_mau_sac = array(
        'hierarchical'      => true,
        'labels'            => $labels_mau_sac,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'cat-mau-sac'),
    );
    register_taxonomy('category_mau_sac', 'product', $taxonomy_san_pham_mau_sac);

    // Kích thước mặt
    $labels_kich_thuong_mat = array(
        'name'              => __('Kích thước mặt', 'monamedia'),
        'singular_name'     => __('Kích thước mặt', 'monamedia'),
        'search_items'      => __('Tìm Kiếm', 'mona-admin'),
        'all_items'         => __('Tất Cả', 'mona-admin'),
        'parent_item'       => __('Kích thước mặt', 'mona-admin'),
        'parent_item_colon' => __('Kích thước mặt', 'mona-admin'),
        'edit_item'         => __('Chỉnh Sửa', 'mona-admin'),
        'add_new'           => __('Thêm Mới', 'mona-admin'),
        'update_item'       => __('Cập Nhật', 'mona-admin'),
        'add_new_item'      => __('Thêm Mới', 'mona-admin'),
        'new_item_name'     => __('Thêm Mới', 'mona-admin'),
        'menu_name'         => __('Danh mục kích thước mặt', 'mona-admin'),
    );

    $taxonomy_san_pham_kich_thuong_mat = array(
        'hierarchical'      => true,
        'labels'            => $labels_kich_thuong_mat,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'cat-kich-thuoc-mat'),
    );
    register_taxonomy('category_kich_thuong_mat', 'product', $taxonomy_san_pham_kich_thuong_mat);

    // Kích chất liệu dây
    $labels_chat_lieu_day = array(
        'name'              => __('Chất liệu dây', 'monamedia'),
        'singular_name'     => __('Chất liệu dây', 'monamedia'),
        'search_items'      => __('Tìm Kiếm', 'mona-admin'),
        'all_items'         => __('Tất Cả', 'mona-admin'),
        'parent_item'       => __('Chất liệu dây', 'mona-admin'),
        'parent_item_colon' => __('Chất liệu dây', 'mona-admin'),
        'edit_item'         => __('Chỉnh Sửa', 'mona-admin'),
        'add_new'           => __('Thêm Mới', 'mona-admin'),
        'update_item'       => __('Cập Nhật', 'mona-admin'),
        'add_new_item'      => __('Thêm Mới', 'mona-admin'),
        'new_item_name'     => __('Thêm Mới', 'mona-admin'),
        'menu_name'         => __('Danh mục chất liệu dây', 'mona-admin'),
    );

    $taxonomy_san_pham_chat_lieu_day = array(
        'hierarchical'      => true,
        'labels'            => $labels_chat_lieu_day,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'cat-chat-lieu-day'),
    );
    register_taxonomy('category_chat_lieu_day', 'product', $taxonomy_san_pham_chat_lieu_day);

    flush_rewrite_rules();
}
add_action('init', 'mona_regsiter_custom_post_types');
