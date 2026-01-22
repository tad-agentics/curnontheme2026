<?php

add_action('wp_ajax_mona_user_save_order',  'mona_user_save_order'); // login
function mona_user_save_order()
{
    $dataForm = [];
    $formdata = isset($_POST['form']) ? wp_unslash($_POST['form']) : '';
    if (!empty($formdata)) {
        parse_str($formdata, $dataForm);
    }
    if (!is_array($dataForm)) {
        $dataForm = [];
    }

    try {
        check_ajax_referer('mona_ajax_nonce', 'nonce');

        if (!is_user_logged_in()) {
            throw new Exception(__('Vui lòng đăng nhập tài khoản', 'monamedia'));
        }
        $user_id = get_current_user_id();
        $billing_last_name = isset($dataForm['billing_last_name']) ? sanitize_text_field($dataForm['billing_last_name']) : '';
        $billing_email = isset($dataForm['billing_email']) ? sanitize_email($dataForm['billing_email']) : '';
        $billing_phone = isset($dataForm['billing_phone']) ? sanitize_text_field($dataForm['billing_phone']) : '';
        $billing_state = isset($dataForm['billing_state']) ? sanitize_text_field($dataForm['billing_state']) : '';
        $billing_city = isset($dataForm['billing_city']) ? sanitize_text_field($dataForm['billing_city']) : '';
        $billing_address_1 = isset($dataForm['billing_address_1']) ? sanitize_text_field($dataForm['billing_address_1']) : '';
        $billing_address_2 = isset($dataForm['billing_address_2']) ? sanitize_text_field($dataForm['billing_address_2']) : '';

        if (!is_email($billing_email)) {
            throw new Exception(__('Email không hợp lệ', 'monamedia'));
        }
        if (!preg_match('/^[0-9]{9,11}$/', $billing_phone)) {
            throw new Exception(__('Số điện thoại không hợp lệ', 'monamedia'));
        }

        update_user_meta($user_id, 'billing_last_name', $billing_last_name);
        update_user_meta($user_id, 'billing_email', $billing_email);
        update_user_meta($user_id, 'billing_phone', $billing_phone);
        update_user_meta($user_id, 'billing_state', $billing_state);
        update_user_meta($user_id, 'billing_city', $billing_city);
        update_user_meta($user_id, 'billing_address_1', $billing_address_1);
        update_user_meta($user_id, 'billing_address_2', $billing_address_2);

        wp_send_json_success(
            [

                'mess' => 'Lưu thông tin thành công '
            ]
        );
        wp_die();
    } catch (Exception $e) {

        wp_send_json_error(
            [
                'title' => __('Thông báo!', 'monamedia'),
                'message' => $e->getMessage(),
                'title_close' => __('Thử lại', 'monamedia'),
            ]
        );
    }
    wp_die();
}



add_action('wp_ajax_mona_user_save_shipping',  'mona_user_save_shipping'); // login
function mona_user_save_shipping()
{
    $dataForm = [];
    $formdata = isset($_POST['form']) ? wp_unslash($_POST['form']) : '';
    if (!empty($formdata)) {
        parse_str($formdata, $dataForm);
    }
    if (!is_array($dataForm)) {
        $dataForm = [];
    }

    try {
        check_ajax_referer('mona_ajax_nonce', 'nonce');

        if (!is_user_logged_in()) {
            throw new Exception(__('Vui lòng đăng nhập tài khoản', 'monamedia'));
        }
        $user_id = get_current_user_id();
        $shipping_last_name = isset($dataForm['shipping_last_name']) ? sanitize_text_field($dataForm['shipping_last_name']) : '';
        $shipping_email = isset($dataForm['shipping_email']) ? sanitize_email($dataForm['shipping_email']) : '';
        $shipping_phone = isset($dataForm['shipping_phone']) ? sanitize_text_field($dataForm['shipping_phone']) : '';
        $shipping_state = isset($dataForm['shipping_state']) ? sanitize_text_field($dataForm['shipping_state']) : '';
        $shipping_city = isset($dataForm['shipping_city']) ? sanitize_text_field($dataForm['shipping_city']) : '';
        $shipping_address_1 = isset($dataForm['shipping_address_1']) ? sanitize_text_field($dataForm['shipping_address_1']) : '';
        $shipping_address_2 = isset($dataForm['shipping_address_2']) ? sanitize_text_field($dataForm['shipping_address_2']) : '';

        if (!is_email($shipping_email)) {
            throw new Exception(__('Email không hợp lệ', 'monamedia'));
        }
        if (!preg_match('/^[0-9]{9,11}$/', $shipping_phone)) {
            throw new Exception(__('Số điện thoại không hợp lệ', 'monamedia'));
        }

        update_user_meta($user_id, 'shipping_last_name', $shipping_last_name);
        update_user_meta($user_id, 'shipping_email', $shipping_email);
        update_user_meta($user_id, 'shipping_phone', $shipping_phone);
        update_user_meta($user_id, 'shipping_state', $shipping_state);
        update_user_meta($user_id, 'shipping_city', $shipping_city);
        update_user_meta($user_id, 'shipping_address_1', $shipping_address_1);
        update_user_meta($user_id, 'shipping_address_2', $shipping_address_2);

        wp_send_json_success(
            [
                'mess' => 'Lưu thông tin thành công '
            ]
        );
        wp_die();
    } catch (Exception $e) {

        wp_send_json_error(
            [
                'title' => __('Thông báo!', 'monamedia'),
                'message' => $e->getMessage(),
                'title_close' => __('Thử lại', 'monamedia'),
            ]
        );
    }
    wp_die();
}



add_action('wp_ajax_mona_user_save_time',  'mona_user_save_time'); // login
function mona_user_save_time()
{
    $dataForm = [];
    $formdata = isset($_POST['form']) ? wp_unslash($_POST['form']) : '';
    if (!empty($formdata)) {
        parse_str($formdata, $dataForm);
    }
    if (!is_array($dataForm)) {
        $dataForm = [];
    }

    try {
        check_ajax_referer('mona_ajax_nonce', 'nonce');

        if (!is_user_logged_in()) {
            throw new Exception(__('Vui lòng đăng nhập tài khoản', 'monamedia'));
        }
        $user_id = get_current_user_id();

        $shipping_date = isset($dataForm['shipping_date']) ? sanitize_text_field($dataForm['shipping_date']) : '';
        $shipping_time = isset($dataForm['shipping_time']) ? sanitize_text_field($dataForm['shipping_time']) : '';

        update_user_meta($user_id, 'shipping_date', $shipping_date);
        update_user_meta($user_id, 'shipping_time', $shipping_time);
        wp_send_json_success(
            [
                'mess' => 'Lưu thông tin thành công '
            ]
        );
        wp_die();
    } catch (Exception $e) {

        wp_send_json_error(
            [
                'title' => __('Thông báo!', 'monamedia'),
                'message' => $e->getMessage(),
                'title_close' => __('Thử lại', 'monamedia'),
            ]
        );
    }
    wp_die();
}




add_action('wp_ajax_mona_user_save_vat',  'mona_user_save_vat'); // login
function mona_user_save_vat()
{
    $dataForm = [];
    $formdata = isset($_POST['form']) ? wp_unslash($_POST['form']) : '';
    if (!empty($formdata)) {
        parse_str($formdata, $dataForm);
    }
    if (!is_array($dataForm)) {
        $dataForm = [];
    }

    try {
        check_ajax_referer('mona_ajax_nonce', 'nonce');

        if (!is_user_logged_in()) {
            throw new Exception(__('Vui lòng đăng nhập tài khoản', 'monamedia'));
        }
        $user_id = get_current_user_id();

        $exp_order_cty = isset($dataForm['exp_order_cty']) ? sanitize_text_field($dataForm['exp_order_cty']) : '';
        $exp_order_mst = isset($dataForm['exp_order_mst']) ? sanitize_text_field($dataForm['exp_order_mst']) : '';
        $exp_order_phone = isset($dataForm['exp_order_phone']) ? sanitize_text_field($dataForm['exp_order_phone']) : '';
        $exp_order_addess = isset($dataForm['exp_order_addess']) ? sanitize_text_field($dataForm['exp_order_addess']) : '';
        $exp_order_stk = isset($dataForm['exp_order_stk']) ? sanitize_text_field($dataForm['exp_order_stk']) : '';

        if (!empty($exp_order_phone) && !preg_match('/^[0-9]{9,11}$/', $exp_order_phone)) {
            throw new Exception(__('Số điện thoại không hợp lệ', 'monamedia'));
        }

        update_user_meta($user_id, 'exp_order_cty', $exp_order_cty);
        update_user_meta($user_id, 'exp_order_mst', $exp_order_mst);
        update_user_meta($user_id, 'exp_order_phone', $exp_order_phone);
        update_user_meta($user_id, 'exp_order_addess', $exp_order_addess);
        update_user_meta($user_id, 'exp_order_stk', $exp_order_stk);
        wp_send_json_success(
            [
                'mess' => 'Lưu thông tin thành công '
            ]
        );
        wp_die();
    } catch (Exception $e) {

        wp_send_json_error(
            [
                'title' => __('Thông báo!', 'monamedia'),
                'message' => $e->getMessage(),
                'title_close' => __('Thử lại', 'monamedia'),
            ]
        );
    }
    wp_die();
}
