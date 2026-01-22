<?php
add_action('wp_ajax_mona_ajax_find_variation', 'mona_ajax_find_variation'); // login
add_action('wp_ajax_nopriv_mona_ajax_find_variation', 'mona_ajax_find_variation'); // no login
function mona_ajax_find_variation()
{
    check_ajax_referer('mona_ajax_nonce', 'nonce');

    $form = [];
    $formdata = isset($_POST['formdata']) ? wp_unslash($_POST['formdata']) : '';
    if (!empty($formdata)) {
        parse_str($formdata, $form);
    }
    if (!is_array($form)) {
        $form = [];
    }
    $sanitized_form = [];
    foreach ($form as $key => $value) {
        $sanitized_form[$key] = is_array($value) ? $value : sanitize_text_field($value);
    }
    $form = $sanitized_form;
    $product_id = isset($form['product_id']) ? absint($form['product_id']) : 0;
    $product = $product_id ? wc_get_product($product_id) : false;
    $request_addons = [];
    $cart_item_data = [];
    $attrbutes_data = [];

    if (!$product || !$product->is_type('variable')) {

        wp_send_json_error(
            [
                'title' => __('Thông báo!', 'monamedia'),
                'message' => __('Hành động này không hợp lệ!', 'monamedia'),
                'title_action' => __('Thử lại', 'monamedia'),
            ]
        );
    } else {

        if (is_array($product->get_attributes())) {

            foreach ($product->get_attributes() as $attribute_name => $attribute) {

                if ($attribute['variation'] || $attribute['visible']) {



                    $request_attributes = isset($form[$attribute_name]) ? sanitize_title($form[$attribute_name]) : '';


                    if (empty($request_attributes)) {

                        wp_send_json_error(
                            [
                                'title' => __('Thông báo!', 'monamedia'),
                                'message' => __('Vui lòng lựa chọn thuộc tính!', 'monamedia'),
                                'title_action' => __('Thử lại', 'monamedia'),
                            ]
                        );
                        wp_die();
                    }

                    $term = get_term_by('slug', $request_attributes, $attribute_name);
                    if ($term) {
                        $attrbutes_data['attribute_' . $attribute_name] = $term->slug;
                    } else {
                        $attrbutes_data['attribute_' . $attribute_name] = sanitize_text_field($request_attributes);
                    }
                }
            }
        }

        $data_store = WC_Data_Store::load('product');
        $varid = $data_store->find_matching_product_variation(new WC_Product($product_id), $attrbutes_data);
        $variations = wc_get_product($varid);


        if ($varid != 0) {
            $productClass = new MonaProductClass();
            // echo $productClass->PriceProduct($varid);
            wp_send_json_success(
                [
                    'current' => [
                        'product_id' => $product_id,
                        'varid' => $varid,
                        'price' => $productClass->PriceProduct($varid, 'detail'),
                        //'description' => MonaProducts::DescriptionProduct($varid),
                        // 'add_cart' => MonaProductClass::ButtonProduct($varid),
                        'gallery' => $productClass->GalleryProduct($varid),
                        'add_cart' => $productClass->AddToCartProduct($varid),
                        // 'combo' => $productClass->ComboProduct($varid),
                        // 'coupon' => MonaProductClass::CouponProduct($varid)
                        'mess' => 'Lựa chọn thuộc tính thành công',
                    ]
                ]
            );
            wp_die();
        } else {

            wp_send_json_error(
                [
                    'title' => __('Thông báo!', 'monamedia'),
                    'message' => __('Không tìm thấy sản phẩm nào phù hợp với thuộc tính đã chọn!', 'monamedia'),
                    'title_close' => __('Thử lại', 'monamedia'),
                ]
            );
            wp_die();
        }
    }

    wp_die();
}



// thêm compo vào giỏ hàng 
add_action('wp_ajax_mona_ajax_add_to_cart_combo', 'mona_ajax_add_to_cart_combo'); // login
add_action('wp_ajax_nopriv_mona_ajax_add_to_cart_combo', 'mona_ajax_add_to_cart_combo'); // no login

function mona_ajax_add_to_cart_combo()
{
    check_ajax_referer('mona_ajax_nonce', 'nonce');

    if (!class_exists('woocommerce') || !WC()->cart) {
        return;
    }

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

    $cart_item_data = [];
    $combo_items = isset($form['combo_items']) && is_array($form['combo_items']) ? $form['combo_items'] : [];
    $product_item_key = '';

    if (empty($product_id)) {
        $label = __('Sản phẩm', 'monamedia');
        wp_send_json_error(
            [
                'title' => $label . ' ' . __('Does not exist or an error occurred.', 'monamedia'),
                'cart-open' => false,
                'message'   => __('An error occurred! Please try again later.', 'monamedia'),
                'action'    => [
                    'title' => __('Try again', 'monamedia'),
                    'title_close' => __('Close', 'monamedia'),
                ],
            ]
        );
        wp_die();
    } else {

        //add to cart [product root];
        $product_root_id = $product_id;
        $_product = wc_get_product($product_id);
        if (!$_product) {
            $label = __('Sản phẩm', 'monamedia');
            wp_send_json_error(
                [
                    'title' => $label . ' ' . __('Does not exist or an error occurred.', 'monamedia'),
                    'cart-open' => false,
                    'message'   => __('An error occurred! Please try again later.', 'monamedia'),
                    'action'    => [
                        'title' => __('Try again', 'monamedia'),
                        'title_close' => __('Close', 'monamedia'),
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
                            $attribute_label_name = wc_attribute_label($attribute_name);
                            wp_send_json_error(
                                [
                                    'title' => __("You haven't selected attributes.", 'monamedia') . $attribute_label_name,
                                    'cart-open' => false,
                                    'message'   => __('Please select attributes.', 'monamedia'),
                                    'action'    => [
                                        'title' => __('Retry', 'monamedia'),
                                        'title_close' => __('Close', 'monamedia'),
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
            $variation = [];
            $data_store   = WC_Data_Store::load('product');
            $varid = $data_store->find_matching_product_variation(new \WC_Product($product_id), $mona_attr);
            $product_cart_id     = WC()->cart->generate_cart_id($product_root_id, $varid, $mona_attr, ['mona_data' => $cart_item_data]);
            $product_item_key    = WC()->cart->find_product_in_cart($product_cart_id);
            $cart_item_data['role'] = 'root';
            $cart_item_data['type'] = 'combo';
            $product_root_id = $varid;
            $product_item_key = WC()->cart->add_to_cart($product_id, $quantity, $varid, $mona_attr, ['mona_data' => $cart_item_data]);
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
                                    'title' => __("You haven't selected attributes.", 'monamedia') . $attribute_label_name,
                                    'cart-open' => false,
                                    'message'   => __('Please select attributes.', 'monamedia'),
                                    'action'    => [
                                        'title' => __('Retry', 'monamedia'),
                                        'title_close' => __('Close', 'monamedia'),
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
            $product_cart_id     = WC()->cart->generate_cart_id($product_id, false, $mona_attr, ['mona_data' => $cart_item_data]);
            $product_item_key    = WC()->cart->find_product_in_cart($product_cart_id);
            $cart_item_data['role'] = 'root';
            $cart_item_data['type'] = 'combo';
            $product_item_key = WC()->cart->add_to_cart($product_id, $quantity, false, $mona_attr, ['mona_data' => $cart_item_data]);
        }

        //ADD COMBO;
        if (!empty($combo_items)) {

            // print_r( $combo_items );
            $combo_i = 0;
            foreach ($combo_items as $key => $combo_item) {
                if (!is_array($combo_item)) {
                    continue;
                }

                if (!empty($combo_item['combo_id'])) {
                    $combo_id       = absint($combo_item['combo_id']);
                    $combo_quantity = !empty($combo_item['combo_quantity']) ? absint($combo_item['combo_quantity']) : 1;
                    $combo_price    = isset($combo_item['combo_price']) ? floatval($combo_item['combo_price']) : 0;

                    $combo_item_data   = array(
                        'role'                  => 'leaf',
                        'combo_id'              => $combo_id,
                        'combo_price'           => $combo_price,
                        'combo_parent_id'       => $product_root_id,
                        'combo_parent_key'      => $product_item_key,
                    );

                    $mona_combo_attr = [];
                    $combo_product_by_combo_id = wc_get_product($combo_id);

                    if ($combo_product_by_combo_id && $combo_product_by_combo_id->is_type('variation')) {

                        $product_parent = $combo_product_by_combo_id->get_parent_id();
                        $product_parent_obj = wc_get_product($product_parent);

                        if (is_array($product_parent_obj->get_attributes())) {
                            foreach ($product_parent_obj->get_attributes() as $attribute_name => $attribute) {
                                if ($attribute['visible'] || $attribute['variation']) {
                                    $combo_attributes = isset($combo_item['attributes']) && is_array($combo_item['attributes']) ? $combo_item['attributes'] : [];
                                    if (empty($combo_attributes[$attribute_name])) {
                                        $attribute_label_name = wc_attribute_label($attribute_name);
                                        wp_send_json_error(
                                            [
                                                'title' => __("You haven't selected attributes.", 'monamedia') . $attribute_label_name,
                                                'cart-open' => false,
                                                'message'   => __('Please select attributes.', 'monamedia'),
                                                'action'    => [
                                                    'title' => __('Retry', 'monamedia'),
                                                    'title_close' => __('Close', 'monamedia'),
                                                ],
                                            ]
                                        );
                                        wp_die();
                                    }
                                }
                            }
                        }
                        if (!empty($combo_item['attributes']) && is_array($combo_item['attributes'])) {
                            foreach ($combo_item['attributes'] as $attribute_name => $attribute) {

                                $attribute_value = sanitize_title($attribute);
                                $term = get_term_by('slug', $attribute_value, $attribute_name);
                                if (!empty($term)) {
                                    $mona_combo_attr['attribute_' . $attribute_name] = $term->slug;
                                    $combo_item_data['attributes']['attribute_' . $attribute_name] = $term->slug;
                                } else {
                                    $raw_value = sanitize_text_field($attribute);
                                    $mona_combo_attr['attribute_' . $attribute_name] = $raw_value;
                                    $combo_item_data['attributes']['attribute_' . $attribute_name] = $raw_value;
                                }
                            }
                        }
                        // $combo_cart_id     = WC()->cart->generate_cart_id( $product_parent, $combo_id, $mona_combo_attr, $combo_item_data );
                        // $combo_item_key    = WC()->cart->find_product_in_cart( $combo_cart_id );
                        $combo_item_key    = WC()->cart->add_to_cart($product_parent, $combo_quantity, $combo_id, $mona_combo_attr, ['mona_data' => $combo_item_data]);
                    } else {

                        // $combo_cart_id     = WC()->cart->generate_cart_id( $combo_id, false, $mona_combo_attr, $combo_item_data );
                        // $combo_item_key    = WC()->cart->find_product_in_cart( $combo_cart_id );
                        $combo_item_key    = WC()->cart->add_to_cart($combo_id, $combo_quantity, false, $mona_combo_attr, ['mona_data' => $combo_item_data]);
                    }

                    // // add keys
                    if (
                        !empty($combo_item_key) &&
                        !empty(WC()->cart->cart_contents[$product_item_key]['combo_item_keys']) &&
                        is_array(WC()->cart->cart_contents[$product_item_key]['combo_item_keys']) &&
                        !in_array($combo_item_key, WC()->cart->cart_contents[$product_item_key]['combo_item_keys'])
                    ) {

                        WC()->cart->cart_contents[$product_item_key]['combo_item_keys'][] = $combo_item_key;
                    } elseif (!empty($combo_item_key) && empty(WC()->cart->cart_contents[$product_item_key]['combo_item_keys'])) {

                        WC()->cart->cart_contents[$product_item_key]['combo_item_keys'][] = $combo_item_key;
                    }
                    $combo_i++;
                }
            }
        }

        WC()->cart->set_session();

        if (!empty($product_item_key)) {
            wp_send_json_success(
                [
                    'title'     => __('Notification!', 'monamedia'),
                    'message'   => __('Compo successfully added to the cart', 'monamedia'),
                    'title_btn' =>  __('Added to cart', 'monamedia'),
                    // 'action'    => [
                    //     'title' => get_the_title(MONA_WC_CART),
                    //     'url'   => get_the_permalink(MONA_WC_CART),
                    //     'title_close' => __('Đóng', 'monamedia'),
                    // ],
                    'cart_data' => [
                        'count' => WC()->cart->get_cart_contents_count(),
                        'total' => WC()->cart->get_cart_total(),
                    ],
                ]
            );
            wp_die();
        } else {

            wp_send_json_error(
                [
                    'title'     => __('Notification!', 'monamedia'),
                    'message'   => __('The product is currently out of stock or an error occurred! Please contact us directly for assistance.', 'monamedia'),
                    'action'    => [
                        'title' => __('Try again', 'monamedia'),
                        'title_close' => __('Close', 'monamedia'),
                    ],
                ]
            );
            wp_die();
        }
    }
    wp_die();
}

add_action('wp_ajax_mona_product_popup_attr', 'mona_product_popup_attr');
add_action('wp_ajax_nopriv_mona_product_popup_attr', 'mona_product_popup_attr');

function mona_product_popup_attr()
{
    check_ajax_referer('mona_ajax_nonce', 'nonce');

    $product_id = isset($_POST['product_id']) ? absint($_POST['product_id']) : 0;

    if (!empty($product_id)) {
        ob_start();

        get_template_part('partials/popup/PopupAttri', '', array("data" => $product_id));

        $item_content = ob_get_clean();
        wp_send_json_success(
            [

                'mess'   => __(' thành công', 'monamedia'),
                'html' =>  $item_content
            ]
        );
        wp_die();
    }
}
