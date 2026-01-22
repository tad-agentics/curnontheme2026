<?php
global $post;

$array = [
    [
        'url'   => get_the_permalink(MONA_PAGE_HOME),
        'title' => __('Home', 'monamedia')
    ],
];

if (wp_get_post_parent_id(get_the_ID())) {
    $parentId = wp_get_post_parent_id(get_the_ID());
    $array[] = [
        'url' => get_permalink($parentId),
        'title' => get_the_title($parentId),
    ];
}

if (is_home()) {


    $array[] = [
        'url' => '',
        'title' => get_the_title(MONA_PAGE_BLOG),
    ];
} elseif (is_singular('post')) {

    // $array[] = [
    //     'url' => get_permalink(MONA_PAGE_BLOG),
    //     'title' => get_the_title(MONA_PAGE_BLOG),
    // ];

    global $post;
    $primary_taxonomy_term = get_primary_taxonomy_term($post->ID, 'category');
    if (!empty($primary_taxonomy_term)) {
        $root = [];
        $root[$primary_taxonomy_term['slug']] = $primary_taxonomy_term['id'];
        $root = get_path_taxonomy_term_root($primary_taxonomy_term['parent'], $root, 'category');
        if (!empty($root)) {
            foreach ($root as $slug => $term_id) {

                $array[] = [
                    'url' => get_term_link($term_id, 'category'),
                    'title' => get_term_by('id', $term_id, 'category')->name,
                ];
            }
        } else {
            $array[] = [
                'url' => $primary_taxonomy_term['url'],
                'title' => $primary_taxonomy_term['title'],
            ];
        }
    }

    $array[] = [
        'url' => '',
        'title' => get_the_title(),
    ];
} elseif (is_singular('product')) {

    // $array[] = [
    //     'url' => get_permalink(MONA_WC_PRODUCTS),
    //     'title' => get_the_title(MONA_WC_PRODUCTS),
    // ];

    global $post;
    $primary_taxonomy_term = get_primary_taxonomy_term($post->ID, 'product_cat');
    if (!empty($primary_taxonomy_term)) {
        $root = [];
        $root[$primary_taxonomy_term['slug']] = $primary_taxonomy_term['id'];
        $root = get_path_taxonomy_term_root($primary_taxonomy_term['parent'], $root, 'product_cat');
        if (!empty($root)) {
            foreach ($root as $slug => $term_id) {

                $array[] = [
                    'url' => get_term_link($term_id, 'product_cat'),
                    'title' => get_term_by('id', $term_id, 'product_cat')->name,
                ];
            }
        } else {
            $array[] = [
                'url' => $primary_taxonomy_term['url'],
                'title' => $primary_taxonomy_term['title'],
            ];
        }
    }

    $array[] = [
        'url' => '',
        'title' => get_the_title(),
    ];
} elseif (is_singular('mona_recruitment')) {

    $array[] = [
        'url'   => get_permalink(MONA_PAGE_ABOUT),
        'title' => get_the_title(MONA_PAGE_ABOUT),
    ];

    global $post;
    $primary_taxonomy_term = get_primary_taxonomy_term($post->ID, 'recruitment_location');
    if (!empty($primary_taxonomy_term)) {
        $root = [];
        $root[$primary_taxonomy_term['slug']] = $primary_taxonomy_term['id'];
        $root = get_path_taxonomy_term_root($primary_taxonomy_term['parent'], $root, 'recruitment_location');
        if (!empty($root)) {
            foreach ($root as $slug => $term_id) {

                $array[] = [
                    'url' => get_term_link($term_id, 'recruitment_location'),
                    'title' => get_term_by('id', $term_id, 'recruitment_location')->name,
                ];
            }
        } else {
            $array[] = [
                'url' => $primary_taxonomy_term['url'],
                'title' => $primary_taxonomy_term['title'],
            ];
        }
    }

    $array[] = [
        'url' => '',
        'title' => get_the_title(),
    ];
} elseif (is_category() || is_tag()) {

    $array[] = [
        'url' => get_permalink(MONA_PAGE_BLOG),
        'title' => get_the_title(MONA_PAGE_BLOG),
    ];

    $array[] = [
        'url' => '',
        'title' => get_queried_object()->name,
    ];
} elseif (is_tax('product_cat')) {

    // $array[] = [
    //     'url' => get_permalink(MONA_WC_PRODUCTS),
    //     'title' => get_the_title(MONA_WC_PRODUCTS),
    // ];

    $current = get_queried_object();
    $root = [];
    if ($current->parent != 0) {

        $root[$current->slug] = $current->term_id;
        $root = get_path_taxonomy_term_root($current->parent, $root, $current->taxonomy);
        if (!empty($root)) {
            foreach ($root as $slug => $term_id) {
                $array[] = [
                    'url' => get_term_link($term_id, $current->taxonomy),
                    'title' => get_term_by('id', $term_id, $current->taxonomy)->name,
                ];
            }
        }
    } else {

        $array[] = [
            'url' => '',
            'title' => $current->name,
        ];
    }
} elseif (is_tax('recruitment_location')) {

    $array[] = [
        'url'   => get_permalink(MONA_PAGE_ABOUT),
        'title' => get_the_title(MONA_PAGE_ABOUT),
    ];

    $current = get_queried_object();
    $root = [];
    if ($current->parent != 0) {

        $root[$current->slug] = $current->term_id;
        $root = get_path_taxonomy_term_root($current->parent, $root, $current->taxonomy);
        if (!empty($root)) {
            foreach ($root as $slug => $term_id) {
                $array[] = [
                    'url' => get_term_link($term_id, $current->taxonomy),
                    'title' => get_term_by('id', $term_id, $current->taxonomy)->name,
                ];
            }
        }
    } else {

        $array[] = [
            'url' => '',
            'title' => $current->name,
        ];
    }
} elseif (is_search()) {

    $array[] = [
        'url' => '',
        'title' => __('Search Results: ', 'monamedia') . '"<span class="keyword">' . get_search_query('s') . '</span>"',
    ];
} elseif (is_account_page()) {

    $array[] = [
        'url' => get_the_permalink(MONA_WC_MYACCOUNT),
        'title' => __('My Account', 'monamedia'),
    ];
} elseif (is_shop()) {

    $array[] = [
        'url' => '',
        'title' => get_the_title(MONA_WC_PRODUCTS),
    ];
} else {

    $array[] = [
        'url' => '',
        'title' => get_the_title(),
    ];
}

if (is_page(MONA_WC_MYACCOUNT)) {
    $result = WC()->query->get_current_endpoint();
    if (!empty($result)) {

        switch ($result) {

            case 'dashboard':
                $array[] = [
                    'url' => '',
                    'title' => __('Personal Details', 'monamedia'),
                ];
                break;

            case 'edit-account':
                $array[] = [
                    'url' => '',
                    'title' => __('Edit Password', 'monamedia'),
                ];
                break;

            case 'orders':
                $array[] = [
                    'url' => '',
                    'title' => __('History', 'monamedia'),
                ];
                break;

            case 'view-order':

                $array[] = [
                    'url' => wc_get_account_endpoint_url('orders'),
                    'title' => __('Orders', 'monamedia'),
                ];

                $array[] = [
                    'url' => '',
                    'title' => get_the_title()
                ];
                break;

            case 'promotion':

                $array[] = [
                    'url' => '',
                    'title' => __('Promotion', 'monamedia')
                ];
                break;

            default:
                break;
        }
    }
}

$title_primary = $array[count($array) - 1]['title'];
?>
<div class="breadcrumb <?php echo is_page(MONA_WC_MYACCOUNT) ? $result : 'default'; ?>">
    <div class="breadcrumb-inner">
        <ul class="breadcrumb-list">
            <?php
            if (is_array($array)) {
                $countArray = count($array);
                foreach ($array as $key => $item) {
                    $title = $item['title'];
                    $url = $item['url'];
            ?>
            <li class="breadcrumb-item <?php echo (empty($url) && $key == ($countArray - 1)) ? 'current-item' : ''; ?>"
                data-aos="fade-left">
                <a href="<?php echo $url ? $url : 'javascript:;'; ?>" class="breadcrumb-link">
                    <?php echo $title; ?>
                </a>
            </li>
            <?php }
            } ?>
        </ul>
    </div>
</div>