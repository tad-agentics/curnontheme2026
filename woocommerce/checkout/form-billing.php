<?php

/**
 * Checkout billing information form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-billing.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 * @global WC_Checkout $checkout
 */

defined('ABSPATH') || exit;
$userid = get_current_user_id();

$firt_name = get_user_meta($userid, 'shipping_first_name', true);
$last_name = get_user_meta($userid, 'shipping_last_name', true);
$address_1 = get_user_meta($userid, 'shipping_address_1', true);
$city = get_user_meta($userid, 'shipping_city', true);
$state = get_user_meta($userid, 'shipping_state', true);
$shipping_phone = get_user_meta($userid, 'shipping_phone', true);
?>


<div class="cartod-form">

    <?php do_action('woocommerce_before_checkout_billing_form', $checkout); ?>

    <h1 class="title fw-6 f-title"><?php _e('THÔNG TIN VẬN CHUYỂN', 'monamedia') ?></h1>

    <div class="woocommerce-billing-fields__field-wrapper form-list row">
        <?php
        // var_dump($dataUser);
        $fields = $checkout->get_checkout_fields('billing');
        foreach ($fields as $key => $field) {
            $value = $checkout->get_value($key);
            $value = $value == 'N/A' ? '' : $value;
            woocommerce_form_field($key, $field, $value);
        }
        $fields = $checkout->get_checkout_fields('order');
        foreach ($fields as $key => $field) {
            $value = $checkout->get_value($key);
            $value = $value == 'N/A' ? '' : $value;
            woocommerce_form_field($key, $field, $value);
        }
        ?>
    </div>

    <?php do_action('woocommerce_after_checkout_billing_form', $checkout); ?>


    <?php if (!is_user_logged_in() && $checkout->is_registration_enabled()) : ?>
        <div class="woocommerce-account-fields">
            <?php if (!$checkout->is_registration_required()) : ?>

                <p class="form-row form-row-wide create-account">
                    <label class="woocommerce-form__label woocommerce-form__label-for-checkbox checkbox">
                        <input class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox" id="createaccount" <?php checked((true === $checkout->get_value('createaccount') || (true === apply_filters('woocommerce_create_account_default_checked', false))), true); ?> type="checkbox" name="createaccount" value="1" />
                        <span><?php esc_html_e('Create an account?', 'woocommerce'); ?></span>
                    </label>
                </p>

            <?php endif; ?>

            <?php do_action('woocommerce_before_checkout_registration_form', $checkout); ?>

            <?php if ($checkout->get_checkout_fields('account')) : ?>

                <div class="create-account">
                    <?php foreach ($checkout->get_checkout_fields('account') as $key => $field) : ?>
                        <?php woocommerce_form_field($key, $field, $checkout->get_value($key)); ?>
                    <?php endforeach; ?>
                    <div class="clear"></div>
                </div>

            <?php endif; ?>

            <?php do_action('woocommerce_after_checkout_registration_form', $checkout); ?>
        </div>
    <?php endif; ?>
</div>