<?php

add_action('wp_ajax_mona_ajax_add_to_cart',  'mona_ajax_add_to_cart'); // login
add_action('wp_ajax_nopriv_mona_ajax_add_to_cart',  'mona_ajax_add_to_cart'); // no login
function mona_ajax_add_to_cart()
{
    check_ajax_referer('mona_ajax_nonce', 'nonce');

    if (!class_exists('woocommerce') || !WC()->cart) {
        return;
    }
    $type = isset($_POST['type']) ? sanitize_text_field(wp_unslash($_POST['type'])) : '';
    $form = [];
    $formdata = isset($_POST['formdata']) ? wp_unslash($_POST['formdata']) : '';
    if (!empty($formdata)) {
        parse_str($formdata, $form);
    }
    if (!is_array($form)) {
        $form = [];
    }
    $form = array_map('sanitize_text_field', $form);
    $product_id = isset($form['product_id']) ? absint($form['product_id']) : 0;
    $quantity = isset($form['quantity']) && absint($form['quantity']) > 0 ? absint($form['quantity']) : 1;
    $cart_item_data = [
        'role' => 'root'
    ];
    $label = __('Sản phẩm', 'monamedia');
    if (empty($product_id)) {
        wp_send_json_error(
            [
                'title' => $label . ' ' . __('Không tồn tại hoặc đã xảy ra lỗi', 'monamedia'),
                'cart-open' => false,
                'message'   => __('Đã xảy ra lỗi! Vui lòng thử lại sau', 'monamedia'),
                'action'    => [
                    'title' => __('Thử lại', 'monamedia'),
                    'title_close' => __('Đóng', 'monamedia'),
                ],
            ]
        );
        wp_die();
    } else {

        $_product = wc_get_product($product_id);
        if (!$_product) {
            wp_send_json_error(
                [
                    'title' => $label . ' ' . __('Không tồn tại hoặc đã xảy ra lỗi', 'monamedia'),
                    'cart-open' => false,
                    'message'   => __('Đã xảy ra lỗi! Vui lòng thử lại sau', 'monamedia'),
                    'action'    => [
                        'title' => __('Thử lại', 'monamedia'),
                        'title_close' => __('Đóng', 'monamedia'),
                    ],
                ]
            );
            wp_die();
        }
        if ($_product->is_type('variable')) {

            $mona_attr = [];
            if (is_array($_product->get_attributes())) {
                foreach ($_product->get_attributes() as $attribute_name => $attribute) {
                    if ($attribute['variation'] || $attribute['visible']) {
                        $attribute_value = isset($form[$attribute_name]) ? sanitize_title($form[$attribute_name]) : '';
                        if (empty($attribute_value)) {
                            wp_send_json_error(
                                [
                                    'title' => __("Bạn chưa chọn thuộc tính", 'monamedia'),
                                    'cart-open' => false,
                                    'message'   => __('Hãy chọn thuộc tính', 'monamedia'),
                                    'action'    => [
                                        'title' => __('Thử lại', 'monamedia'),
                                        'title_close' => __('Đóng', 'monamedia'),
                                    ],
                                ]
                            );
                            wp_die();
                        }
                        $term = get_term_by('slug', $attribute_value, $attribute_name);
                        if (!empty($term)) {
                            $mona_attr['attribute_' . $attribute_name] = $term->slug;
                            $cart_item_data['attributes']['attribute_' . $attribute_name] = $term->slug;
                        } else {
                            $raw_value = isset($form[$attribute_name]) ? sanitize_text_field($form[$attribute_name]) : '';
                            $mona_attr['attribute_' . $attribute_name] = $raw_value;
                            $cart_item_data['attributes']['attribute_' . $attribute_name] = $raw_value;
                        }
                    }
                }
            }
            $variation = [];
            $data_store   = WC_Data_Store::load('product');
            $varid = $data_store->find_matching_product_variation(new \WC_Product($product_id), $mona_attr);

            if (isset($form['select_gift']) && !empty($form['select_gift'])) {
                $cart_item_data['select_gift'] = 'on';
            }
            if (isset($form['select_content']) && !empty($form['select_content'])) {
                $cart_item_data['select_content'] = sanitize_textarea_field($form['select_content']);
            }

            $product_cart_id     = WC()->cart->generate_cart_id($product_id, $varid, $mona_attr, ['mona_data' => $cart_item_data]);
            $product_item_key    = WC()->cart->find_product_in_cart($product_cart_id);
            $cart_data = WC()->cart->add_to_cart($product_id, $quantity, $varid, $mona_attr, ['mona_data' => $cart_item_data]);
            if ($cart_data) {
                wp_send_json_success(
                    [
                        'title'     => __('Thông báo!', 'monamedia'),
                        'message'   => __('Sản phẩm được thêm vào giỏ hàng thành công', 'monamedia'),
                        'title_btn' =>  __('Đã thêm vào giỏ hàng', 'monamedia'),
                        'action'    => [
                            'title' => get_the_title(MONA_WC_CART),
                            'url'   => get_the_permalink(MONA_WC_CART),
                            'title_close' => __('Đóng', 'monamedia'),
                        ],
                        'cart_data' => [
                            'count' => WC()->cart->get_cart_contents_count(),
                            'total' => WC()->cart->get_cart_total(),
                        ],
                        'redirect'  => $type == 'now' ? get_the_permalink(MONA_WC_CHECKOUT) : ''
                    ]
                );
                wp_die();
            } else {
                wp_send_json_error(
                    [
                        'title'     => __('Thông báo!', 'monamedia'),
                        'message'   => __('Sản phẩm tạm hết hàng!', 'monamedia'),
                        'action'    => [
                            'title' => __('Thử lại', 'monamedia'),
                            'title_close' => __('Đóng', 'monamedia'),
                        ],
                    ]
                );
                wp_die();
            }
        } else {

            $mona_attr = [];
            if (is_array($_product->get_attributes())) {
                foreach ($_product->get_attributes() as $attribute_name => $attribute) {
                    if ($attribute['visible']) {
                        $attribute_value = isset($form[$attribute_name]) ? sanitize_title($form[$attribute_name]) : '';
                        if (empty($attribute_value)) {
                            $attribute_label_name = wc_attribute_label($attribute_name);
                            wp_send_json_error(
                                [
                                    'title' => __("Bạn chưa chọn thuộc tính", 'monamedia') . $attribute_label_name,
                                    'cart-open' => false,
                                    'message'   => __('Hãy chọn thuộc tính', 'monamedia'),
                                    'action'    => [
                                        'title' => __('Thử lại', 'monamedia'),
                                        'title_close' => __('Đóng', 'monamedia'),
                                    ],
                                ]
                            );
                            wp_die();
                        }
                        $term = get_term_by('slug', $attribute_value, $attribute_name);
                        if (!empty($term)) {
                            $cart_item_data['attributes']['attribute_' . $attribute_name] = $term->slug;
                            $mona_attr['attribute_' . $attribute_name] = $term->slug;
                        } else {
                            $raw_value = isset($form[$attribute_name]) ? sanitize_text_field($form[$attribute_name]) : '';
                            $cart_item_data['attributes']['attribute_' . $attribute_name] = $raw_value;
                            $mona_attr['attribute_' . $attribute_name] = $raw_value;
                        }
                    }
                }
            }

            if (isset($form['select_gift']) && !empty($form['select_gift'])) {
                $cart_item_data['select_gift'] = 'on';
            }
            if (isset($form['select_content']) && !empty($form['select_content'])) {
                $cart_item_data['select_content'] = sanitize_textarea_field($form['select_content']);
            }

            $product_cart_id     = WC()->cart->generate_cart_id($product_id, false, $mona_attr, ['mona_data' => $cart_item_data]);
            $product_item_key    = WC()->cart->find_product_in_cart($product_cart_id);
            $cart_data = WC()->cart->add_to_cart($product_id, $quantity, false, $mona_attr, ['mona_data' => $cart_item_data]);
            if ($cart_data) {
                wp_send_json_success(
                    [
                        'title'     => __('Thông báo!', 'monamedia'),
                        'message'   => __('Sản phẩm được thêm vào giỏ hàng thành công', 'monamedia'),
                        'title_btn' =>  __('Đã thêm vào giỏ hàng', 'monamedia'),
                        'action'    => [
                            'title' => get_the_title(MONA_WC_CART),
                            'url'   => get_the_permalink(MONA_WC_CART),
                            'title_close' => __('Đóng', 'monamedia'),
                        ],
                        'cart_data' => [
                            'count' => WC()->cart->get_cart_contents_count(),
                            'total' => WC()->cart->get_cart_total(),
                        ],
                        'redirect'  => $type == 'now' ? get_the_permalink(MONA_WC_CHECKOUT) : ''
                    ]
                );
                wp_die();
            } else {

                wp_send_json_error(
                    [
                        'title'     => __('Thông báo!', 'monamedia'),
                        'message'   => __('Sản phẩm tạm hết hàng!', 'monamedia'),
                        'action'    => [
                            'title' => __('Thử lại', 'monamedia'),
                            'title_close' => __('Đóng', 'monamedia'),
                        ],
                    ]
                );
                wp_die();
            }
        }
    }
    wp_die();
}
