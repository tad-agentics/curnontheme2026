<?php

if (class_exists('Kirki')) {

    /**
     * Add sections
     */
    function kirki_demo_scripts()
    {
        wp_enqueue_style('kirki-demo', get_stylesheet_uri(), array(), time());
    }

    add_action('wp_enqueue_scripts', 'kirki_demo_scripts');

    $priority = 1;

    /**
     * Add panel
     */
    Kirki::add_panel(
        'panel_site',
        [
            'title'     => sprintf(__('%s SITE', 'mona-admin'), get_bloginfo()),
            'priority'   => $priority++,
            'capability' => 'edit_theme_options',
        ]
    );
    /**
     * Add section
     */
    Kirki::add_section(
        'section_default',
        [
            'title'      => __('Thông tin', 'mona-admin'),
            'priority'   => $priority++,
            'capability' => 'edit_theme_options',
            'panel'      => 'panel_site'
        ]
    );
    /**
     * Add field
     */
    Kirki::add_field(
        'mona_setting',
        [
            'type'        => 'image',
            'settings'    => 'mona_thumbnail_default',
            'label'       => __('Thumbnail Default', 'mona-admin'),
            'description' => '',
            'help'        => '',
            'section'     => 'section_default',
            'default'     => '',
            'priority'    => $priority++,
        ]
    );
    Kirki::add_field(
        'mona_setting',
        [
            'type'        => 'image',
            'settings'    => 'mona_thumbnail_default_square',
            'label'       => __('Thumbnail Default [square]', 'mona-admin'),
            'description' => '',
            'help'        => '',
            'section'     => 'section_default',
            'default'     => '',
            'priority'    => $priority++,
        ]
    );

    /**
     * Add section
     */
    Kirki::add_section(
        'section_header',
        [
            'title'      => __('Header', 'mona-admin'),
            'priority'   => $priority++,
            'capability' => 'edit_theme_options',
            'panel'      => 'panel_site'
        ]
    );

    //title 1
    /**
     * Add field 
     */
    Kirki::add_field(
        'mona_setting',
        [
            'type'        => 'image',
            'settings'    => 'header_image_mobile_logo',
            'label'       => __('Logo mobile version', 'mona-admin'),
            'description' => '',
            'help'        => '',
            'section'     => 'section_header',
            'default'     => '',
            'priority'    => $priority++,
        ]
    );

    /**
     * Add section
     */
    Kirki::add_section(
        'section_footer',
        [
            'title'      => __('Footer', 'mona-admin'),
            'priority'   => $priority++,
            'capability' => 'edit_theme_options',
            'panel'      => 'panel_site'
        ]
    );
    //icon địa chỉ
    Kirki::add_field(
        'mona_setting',
        [
            'type'        => 'image',
            'settings'    => 'mona_footer_icon',
            'label'       => __('Icon địa chỉ', 'mona-admin'),
            'description' => '',
            'help'        => '',
            'section'     => 'section_footer',
            'default'     => '',
            'priority'    => $priority++,
        ]
    );
    //  tiêu đề 1
    Kirki::add_field(
        'mona_setting',
        [
            'type'        => 'text',
            'settings'    => 'footer_title_1',
            'label'       => __('Tiêu đề (1)', 'mona-admin'),
            'description' => '',
            'help'        => '',
            'section'     => 'section_footer',
            'default'     => '',
            'priority'    => $priority++,
        ]
    );
    //  Địa chỉ hà nội
    /**
     * Add field 
     */
    kirki::add_field('mona_setting', [
        'type'        => 'repeater',
        'label'       => __('Địa chỉ', 'mona-admin'),
        'section'     => 'section_footer',
        'priority'    =>  $priority++,
        'row_label' => [
            'type'  => 'text',
            'value' => __('Địa chỉ', 'mona-admin'),

        ],
        'button_label' => __('Add new', 'mona-admin'),
        'settings'     => 'dia_chi_items_1',
        'fields' => [
            'content' => [
                'type'        => 'text',
                'label'       => __('Địa chỉ', 'mona-admin'),
                'description' => '',
                'default'     => '',
            ],
            'link' => [
                'type'        => 'text',
                'label'       => __('Link', 'mona-admin'),
                'description' => '',
                'default'     => '',
            ],
        ]
    ]);

    //  tiêu đề 2
    Kirki::add_field(
        'mona_setting',
        [
            'type'        => 'text',
            'settings'    => 'footer_title_2',
            'label'       => __('Tiêu đề (2)', 'mona-admin'),
            'description' => '',
            'help'        => '',
            'section'     => 'section_footer',
            'default'     => '',
            'priority'    => $priority++,
        ]
    );
    //  Địa chỉ hồ chí minh
    /**
     * Add field 
     */
    kirki::add_field('mona_setting', [
        'type'        => 'repeater',
        'label'       => __('Địa chỉ', 'mona-admin'),
        'section'     => 'section_footer',
        'priority'    =>  $priority++,
        'row_label' => [
            'type'  => 'text',
            'value' => __('Địa chỉ', 'mona-admin'),

        ],
        'button_label' => __('Add new', 'mona-admin'),
        'settings'     => 'dia_chi_items_2',
        'fields' => [
            'content' => [
                'type'        => 'text',
                'label'       => __('Địa chỉ', 'mona-admin'),
                'description' => '',
                'default'     => '',
            ],
            'link' => [
                'type'        => 'text',
                'label'       => __('Link', 'mona-admin'),
                'description' => '',
                'default'     => '',
            ],
        ]
    ]);
    //  tiêu đề 3
    Kirki::add_field(
        'mona_setting',
        [
            'type'        => 'text',
            'settings'    => 'footer_title_3',
            'label'       => __('Tiêu đề (3)', 'mona-admin'),
            'description' => '',
            'help'        => '',
            'section'     => 'section_footer',
            'default'     => '',
            'priority'    => $priority++,
        ]
    );
    //  tiêu đề 4
    Kirki::add_field(
        'mona_setting',
        [
            'type'        => 'text',
            'settings'    => 'footer_title_4',
            'label'       => __('Tiêu đề (4)', 'mona-admin'),
            'description' => '',
            'help'        => '',
            'section'     => 'section_footer',
            'default'     => '',
            'priority'    => $priority++,
        ]
    );
    //  tiêu đề 5
    Kirki::add_field(
        'mona_setting',
        [
            'type'        => 'text',
            'settings'    => 'footer_title_5',
            'label'       => __('Tiêu đề (5)', 'mona-admin'),
            'description' => '',
            'help'        => '',
            'section'     => 'section_footer',
            'default'     => '',
            'priority'    => $priority++,
        ]
    );
    //  tiêu đề 6
    Kirki::add_field(
        'mona_setting',
        [
            'type'        => 'text',
            'settings'    => 'footer_title_6',
            'label'       => __('Tiêu đề (6)', 'mona-admin'),
            'description' => '',
            'help'        => '',
            'section'     => 'section_footer',
            'default'     => '',
            'priority'    => $priority++,
        ]
    );

    //Mang xã hội
    /**
     * Add field 
     */

    kirki::add_field('mona_setting', [
        'type'        => 'repeater',
        'label'       => __('Mạng xã hội', 'mona-admin'),
        'section'     => 'section_footer',
        'priority'    =>  $priority++,
        'row_label' => [
            'type'  => 'text',
            'value' => __('Item', 'mona-admin'),

        ],
        'button_label' => __('Thêm mới', 'mona-admin'),
        'settings'     => 'social_items_footer',
        'fields' => [
            'icon' => [
                'type'        => 'image',
                'label'       => __('Icon', 'mona-admin'),
                'description' => '',
                'default'     => '',
            ],
            'link' => [
                'type'        => 'text',
                'label'       => __('Link', 'mona-admin'),
                'description' => '',
                'default'     => '',
            ],
        ]
    ]);

    //  tiêu đề 7
    Kirki::add_field(
        'mona_setting',
        [
            'type'        => 'text',
            'settings'    => 'footer_title_7',
            'label'       => __('Tiêu đề (7)', 'mona-admin'),
            'description' => '',
            'help'        => '',
            'section'     => 'section_footer',
            'default'     => '',
            'priority'    => $priority++,
        ]
    );

    //  tiêu đề 8
    Kirki::add_field(
        'mona_setting',
        [
            'type'        => 'text',
            'settings'    => 'footer_title_8',
            'label'       => __('Tiêu đề (8)', 'mona-admin'),
            'description' => '',
            'help'        => '',
            'section'     => 'section_footer',
            'default'     => '',
            'priority'    => $priority++,
        ]
    );

    //  short code
    Kirki::add_field(
        'mona_setting',
        [
            'type'        => 'text',
            'settings'    => 'footer_shortcode',
            'label'       => __('Shortcode', 'mona-admin'),
            'description' => '',
            'help'        => '',
            'section'     => 'section_footer',
            'default'     => '',
            'priority'    => $priority++,
        ]
    );

    //hình ảnh
    Kirki::add_field(
        'mona_setting',
        [
            'type'        => 'image',
            'settings'    => 'mona_footer_image',
            'label'       => __('Hình ảnh', 'mona-admin'),
            'description' => '',
            'help'        => '',
            'section'     => 'section_footer',
            'default'     => '',
            'priority'    => $priority++,
        ]
    );

    //  Phương thức thanh toán
    /**
     * Add field 
     */
    kirki::add_field('mona_setting', [
        'type'        => 'repeater',
        'label'       => __('Thanh toán', 'mona-admin'),
        'section'     => 'section_footer',
        'priority'    =>  $priority++,
        'row_label' => [
            'type'  => 'text',
            'value' => __('Thanh toán', 'mona-admin'),

        ],
        'button_label' => __('Add new', 'mona-admin'),
        'settings'     => 'thanh_toan_items',
        'fields' => [
            'image' => [
                'type'        => 'image',
                'label'       => __('Hình ảnh', 'mona-admin'),
                'description' => '',
                'default'     => '',
            ],
        ]
    ]);
    /**
     * Add field 
     */
    // kirki::add_field( 'mona_setting', [
    //     'type'        => 'repeater',
    //     'label'       => __( 'Danh sách liên kết', 'mona-admin' ),
    //     'section'     => 'section_contact_socials',
    //     'priority'    =>  $priority++,
    //     'row_label' => [
    //         'type'  => 'text',
    //         'value' => __( 'Liên kết', 'mona-admin' ),

    //     ],
    //     'button_label' => __( 'Thêm mới', 'mona-admin' ),
    //     'settings'     => 'contact_social_items',
    //     'fields' => [
    //         'icon' => [
    //             'type'        => 'image',
    //             'label'       => __( 'Icon', 'mona-admin' ),
    //             'description' => '',
    //             'default'     => '',
    //         ],
    //         'link' => [
    //             'type'        => 'text',
    //             'label'       => __( 'Link', 'mona-admin' ),
    //             'description' => '',
    //             'default'     => '',
    //         ],
    //     ]
    // ]);

}

if (!function_exists('mona_option')) {

    /**
     * Undocumented function
     *
     * @param [type] $setting
     * @param string $default
     * @return void
     */
    function mona_option($setting, $default = '')
    {
        echo mona_get_option($setting, $default);
    }

    /**
     * Undocumented function
     *
     * @param [type] $setting
     * @param string $default
     * @return void
     */
    function mona_get_option($setting, $default = '')
    {

        if (class_exists('Kirki')) {

            $value = $default;

            $options = get_option('option_name', array());
            $options = get_theme_mod($setting, $default);

            if (isset($options)) {
                $value = $options;
            }

            return $value;
        }

        return $default;
    }
}
