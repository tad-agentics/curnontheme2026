<?php

add_action('wp_ajax_mona_user_save_order',  'mona_user_save_order'); // login
function mona_user_save_order()
{
    $dataForm = [];
    parse_str($_POST['form'], $dataForm);

    try {
        if (!is_user_logged_in()) {
            throw new Exception(__('Vui lòng đăng nhập tài khoản', 'monamedia'));
        }
        $user_id = get_current_user_id();
        update_user_meta($user_id, 'billing_last_name', $dataForm['billing_last_name']);
        update_user_meta($user_id, 'billing_email', $dataForm['billing_email']);
        update_user_meta($user_id, 'billing_phone',  $dataForm['billing_phone']);
        update_user_meta($user_id, 'billing_state', $dataForm['billing_state']);
        update_user_meta($user_id, 'billing_city', $dataForm['billing_city']);
        update_user_meta($user_id, 'billing_address_1', $dataForm['billing_address_1']);
        update_user_meta($user_id, 'billing_address_2', $dataForm['billing_address_2']);

        echo wp_send_json_success(
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
    parse_str($_POST['form'], $dataForm);

    try {
        if (!is_user_logged_in()) {
            throw new Exception(__('Vui lòng đăng nhập tài khoản', 'monamedia'));
        }
        $user_id = get_current_user_id();
        update_user_meta($user_id, 'shipping_last_name', $dataForm['shipping_last_name']);
        update_user_meta($user_id, 'shipping_email', $dataForm['shipping_email']);
        update_user_meta($user_id, 'shipping_phone',  $dataForm['shipping_phone']);
        update_user_meta($user_id, 'shipping_state', $dataForm['shipping_state']);
        update_user_meta($user_id, 'shipping_city', $dataForm['shipping_city']);
        update_user_meta($user_id, 'shipping_address_1', $dataForm['shipping_address_1']);
        update_user_meta($user_id, 'shipping_address_2', $dataForm['shipping_address_2']);

        echo wp_send_json_success(
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
    parse_str($_POST['form'], $dataForm);

    try {
        if (!is_user_logged_in()) {
            throw new Exception(__('Vui lòng đăng nhập tài khoản', 'monamedia'));
        }
        $user_id = get_current_user_id();

        update_user_meta($user_id, 'shipping_date', $dataForm['shipping_date']);
        update_user_meta($user_id, 'shipping_time', $dataForm['shipping_time']);
        echo wp_send_json_success(
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
    parse_str($_POST['form'], $dataForm);

    try {
        if (!is_user_logged_in()) {
            throw new Exception(__('Vui lòng đăng nhập tài khoản', 'monamedia'));
        }
        $user_id = get_current_user_id();

        update_user_meta($user_id, 'exp_order_cty', $dataForm['exp_order_cty']);
        update_user_meta($user_id, 'exp_order_mst', $dataForm['exp_order_mst']);
        update_user_meta($user_id, 'exp_order_phone', $dataForm['exp_order_phone']);
        update_user_meta($user_id, 'exp_order_addess', $dataForm['exp_order_addess']);
        update_user_meta($user_id, 'exp_order_stk', $dataForm['exp_order_stk']);
        echo wp_send_json_success(
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
