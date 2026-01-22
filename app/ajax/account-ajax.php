<?php
add_action('wp_ajax_m_a_change_password', 'm_a_change_password');
function check_password($old_pass, $id_user)
{
    $hash = get_userdata($id_user)->user_pass;
    $check = wp_check_password($old_pass, $hash, $id_user);
    return $check;
}
function check_verify($pass1, $pass2)
{
    return $pass1 === $pass2;
}
function m_a_change_password()
{
    $form = array();
    check_ajax_referer('mona_ajax_nonce', 'nonce');

    if (!is_user_logged_in()) {
        wp_send_json_error(
            [
                'mess'   => __('Unauthorized', 'monamedia'),
            ]
        );
        wp_die();
    }

    $formdata = isset($_POST['formData']) ? wp_unslash($_POST['formData']) : '';
    if (!empty($formdata)) {
        parse_str($formdata, $form);
    }
    if (!is_array($form)) {
        $form = [];
    }
    $currentPass = isset($form['current-password']) ? sanitize_text_field($form['current-password']) : '';
    $newPass = isset($form['new-pass']) ? sanitize_text_field($form['new-pass']) : '';
    $id_user = get_current_user_id();
    $newRepass = isset($form['new-repass']) ? sanitize_text_field($form['new-repass']) : '';
    if ($currentPass != '' && $newPass != '') {
        if (check_password($currentPass, $id_user)) {
            if (check_verify($newPass, $newRepass)) {
                $user_data = get_userdata($id_user);
                wp_set_password($newPass, $id_user);
                $args = array(
                    'user_login' => $user_data->user_login,
                    'user_password' => $newPass,
                );
                $on = wp_signon($args);
                if ($on) {
                    wp_send_json_success(
                        [
                            'mess' => 'Password changed successfully.'
                        ]
                    );
                    wp_die();
                }
            } else {

                wp_send_json_error(
                    [
                        'mess'   => __('Incorrect password. Please try again.', 'monamedia'),
                    ]
                );
                wp_die();
            }
        } else {

            wp_send_json_error(
                [
                    'mess'   => __('The old password is incorrect.', 'monamedia'),
                ]
            );
            wp_die();
        };
    } else {
        wp_send_json_error(
            [
                'mess'   => __('Do not leave it blank.', 'monamedia'),
            ]
        );
        wp_die();
    }
}


add_action('wp_ajax_mona_update_ajax_shipping', 'mona_update_ajax_shipping');
function mona_update_ajax_shipping()
{
    $form = array();
    check_ajax_referer('mona_ajax_nonce', 'nonce');

    if (!is_user_logged_in()) {
        wp_send_json_error(
            [
                'mess'   => __('Unauthorized', 'monamedia'),
            ]
        );
        wp_die();
    }

    $id_user = get_current_user_id();
    $formdata = isset($_POST['formData']) ? wp_unslash($_POST['formData']) : '';
    if (!empty($formdata)) {
        parse_str($formdata, $form);
    }
    if (!is_array($form)) {
        $form = [];
    }

    $shipping_first_name = isset($form['shipping_first_name']) ? sanitize_text_field($form['shipping_first_name']) : '';
    $shipping_last_name = isset($form['shipping_last_name']) ? sanitize_text_field($form['shipping_last_name']) : '';
    $shipping_address_1 = isset($form['shipping_address_1']) ? sanitize_text_field($form['shipping_address_1']) : '';
    $shipping_city = isset($form['shipping_city']) ? sanitize_text_field($form['shipping_city']) : '';
    $shipping_state = isset($form['shipping_state']) ? sanitize_text_field($form['shipping_state']) : '';
    $shipping_phone = isset($form['shipping_phone']) ? sanitize_text_field($form['shipping_phone']) : '';

    if (!empty($shipping_phone) && !preg_match('/^[0-9]{9,11}$/', $shipping_phone)) {
        wp_send_json_error(
            [
                'mess'   => __('Số điện thoại không hợp lệ', 'monamedia'),
            ]
        );
        wp_die();
    }


    $user_info = get_userdata($id_user);

    if ($user_info) {
        // Cập nhật thông tin địa chỉ giao hàng
        update_user_meta($id_user, 'shipping_first_name', $shipping_first_name);
        update_user_meta($id_user, 'shipping_last_name', $shipping_last_name);
        update_user_meta($id_user, 'shipping_address_1', $shipping_address_1);
        update_user_meta($id_user, 'shipping_city', $shipping_city);
        update_user_meta($id_user, 'shipping_state', $shipping_state);
        update_user_meta($id_user, 'shipping_phone', $shipping_phone);
        wp_send_json_success(
            [
                'mess' => __('Cập nhật thành công', 'monamedia')
            ]
        );
        wp_die();
    } else {
        wp_send_json_error(
            [
                'mess'   => __('Cập nhật thất bại', 'monamedia'),
            ]
        );
        wp_die();
    }
}


add_action('wp_ajax_m_a_edit_account', 'm_a_edit_account');
function m_a_edit_account()
{
    $form = array();
    check_ajax_referer('mona_ajax_nonce', 'nonce');

    if (!is_user_logged_in()) {
        wp_send_json_error(
            [
                'mess'   => __('Unauthorized', 'monamedia'),
            ]
        );
        wp_die();
    }

    $id_user = get_current_user_id();
    $formdata = isset($_POST['formData']) ? wp_unslash($_POST['formData']) : '';
    if (!empty($formdata)) {
        parse_str($formdata, $form);
    }
    if (!is_array($form)) {
        $form = [];
    }
    $DisplayName = isset($form['m-edit-name']) ? sanitize_text_field($form['m-edit-name']) : '';
    $UserPhone = isset($form['m-edit-phone']) ? sanitize_text_field($form['m-edit-phone']) : '';
    $birthday = isset($form['birthday']) ? sanitize_text_field($form['birthday']) : '';
    $user_address = isset($form['m-edit-address']) ? sanitize_text_field($form['m-edit-address']) : '';
    $user_zipcode = isset($form['m-edit-zipcode']) ? sanitize_text_field($form['m-edit-zipcode']) : '';

    // New code to handle gender
    $user_gender = isset($form['user_gender']) ? sanitize_text_field($form['user_gender']) : '';

    if (!empty($UserPhone) && !preg_match('/^[0-9]{9,11}$/', $UserPhone)) {
        wp_send_json_error(
            [
                'mess'   => __('Số điện thoại không hợp lệ', 'monamedia'),
            ]
        );
        wp_die();
    }

    $dateObj = DateTime::createFromFormat('d/m/Y', $birthday);

    unset($form['display_name']);
    unset($form['user-email']);

    $args = array(
        'ID' => $id_user,
        'display_name' => $DisplayName,
    );

    $update = wp_update_user($args);

    if (is_wp_error($update)) {
        wp_send_json_error(
            [
                'mess' => __('Update failed', 'monamedia'),
            ]
        );
        wp_die();
    }

    if ($dateObj && $dateObj->format('d/m/Y') === $birthday) {
        update_user_meta($id_user, '_address', $user_address);
        update_user_meta($id_user, '_zipcode', $user_zipcode);

        $date = $dateObj->format('d/m/Y');
        update_user_meta($id_user, 'birthday', $date);

        update_user_meta($id_user, '_phone', $UserPhone);

        // Update gender information
        update_user_meta($id_user, 'user_gender', $user_gender);

        wp_send_json_success(
            [
                'mess' => 'Update successful'
            ]
        );
        wp_die();
    } else {
        wp_send_json_error(
            [
                'mess' => __('Please enter the correct date of birth format', 'monamedia'),
            ]
        );
        wp_die();
    }
}
