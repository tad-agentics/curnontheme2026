<?php

/**
 * Output a single payment method
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/payment-method.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     3.5.0
 */

if (!defined('ABSPATH')) {
    exit;
}
$total_amount = WC()->cart->total;
?>
 <?php if ($gateway->id !== 'fundiin' || $total_amount >= 1000000): ?>
<div
    class="mcart-block-item collapse-item c-form-method-item recheck-item <?php echo ($gateway->id === 'cod') ? 'active' : ''; ?>">
    <!-- <input hidden type="radio" class="recheck-input" id="payment_method_<?php echo esc_attr($gateway->id); ?>" name="payment_method" value="<?php echo esc_attr($gateway->id); ?>" <?php checked($gateway->chosen, true); ?> data-order_button_text="<?php echo esc_attr($gateway->order_button_text); ?>"> -->
    <input hidden type="radio" class="recheck-input" id="payment_method_<?php echo esc_attr($gateway->id); ?>"
        name="payment_method" value="<?php echo esc_attr($gateway->id); ?>"
        <?php echo ( $gateway->id === 'cod' ) ? 'checked="checked"' : ''; ?>
        data-order_button_text="<?php echo esc_attr($gateway->order_button_text); ?>">

    <div class="recheck-dot"></div>

    <div class="recheck-text">
        <div class="recheck-text-img">
            <?php if( $gateway->id === 'cod' ){ ?>
            <div class="img">
                <img src="<?php echo esc_url(get_site_url()); ?>/template/assets/images/cod.png" alt="" />
            </div>
            <?php }else if( $gateway->id === 'fundiin' ){ ?> 
            <div class="img">
                <img src="<?php echo esc_url(get_site_url()); ?>/template/assets/images/fundiin.png" alt="" />
            </div>
            <?php }else if( $gateway->id === 'momo' ){ ?> 
            <div class="img">
                <img src="<?php echo esc_url(get_site_url()); ?>/template/assets/images/momo.png" alt="" />
            </div>
            <?php }else if( $gateway->id === 'vnpay' ){ ?> 
            <div class="img">
                <img src="<?php echo esc_url(get_site_url()); ?>/template/assets/images/vnpay.png" alt="" />
            </div>
            <?php } ?>
            <p class="txt fw-5">
                <?php echo $gateway->get_title(); ?><br>
                <span class="fw-4"><?php echo $gateway->get_description(); ?></span></p>
        </div>
    </div>

</div>
<?php endif; ?>