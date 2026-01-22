<?php

/**
 * My Account Dashboard
 *
 * Shows the first intro screen on the account dashboard.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/dashboard.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 4.4.0
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}
$userid = get_current_user_id();
$new_user = get_userdata($userid);
$full_name = $new_user->display_name;
$birthday = get_user_meta($userid, 'birthday', true);

$user_address = get_user_meta($userid, '_address', true);
$user_zipcode = get_user_meta($userid, '_zipcode', true);

$phone = get_user_meta($userid, '_phone', true);
$thumb = get_field('avt', 'user_' . $userid);

if ($thumb) {
    $avatar = wp_get_attachment_image($thumb, 'thumbnail', false, ['class' => 'fileImg', 'id' => 'm_id_thumb']);
} else {
    $avatar = '<img src="' . MONA_URL . '" class="fileImg" id="m_id_thumb">';
}

?>
<!-- save info  -->
<div class="acc-mpro">
    <form action="" class="is-loading-group" id="m-edit-account">
        <div class="acc-mpro-flex">
            <div class="acc-mpro-left">
                <p class="text">Preferred Name</p>
            </div>
            <div class="acc-mpro-right">
                <div class="ip-control">
                    <input type="text" name="m-edit-name" required value="<?php echo $new_user->display_name ?>" placeholder="<?php _e('Full Name', 'monamedia') ?>">
                </div>
            </div>
        </div>
        <div class="acc-mpro-flex">
            <div class="acc-mpro-left">
                <p class="text">Email</p>
            </div>
            <div class="acc-mpro-right">
                <div class="ip-control">
                    <input placeholder="Your email" type="email" value="<?php echo $new_user->user_email; ?>" readonly>
                </div>
            </div>
        </div>
        <div class="acc-mpro-flex">
            <div class="acc-mpro-left">
                <p class="text">
                    Birthday
                    <span class="txt c-grey">
                        DD/MM/YYYY
                    </span>
                </p>
            </div>
            <div class="acc-mpro-right">
                <div class="ip-control">
                    <div class="dateTime" data-type="single" data-min="1800">
                        <div class="dateTimeItem">
                            <input class="dateTimeText" type="text" name="birthday">
                            <input class="dateTimeInput" type="text" name="birthday" value="<?php echo $birthday ?>" readonly>
                        </div>
                        <div class="icon"><i class="fa-solid fa-calendar-days"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="acc-mpro-flex">
            <div class="acc-mpro-left">
                <p class="text">Gender </p>
            </div>
            <div class="acc-mpro-right">
                <div class="recheck">
                    <div class="recheck-block">
                        <div class="recheck-item">
                            <input class="recheck-input" type="radio" name="user_gender" value="male" id="male" <?php echo (get_user_meta(get_current_user_id(), 'user_gender', true) === 'male') ? 'checked' : ''; ?> hidden="">
                            <div class="recheck-checkbox"></div>
                            <p class="recheck-text">Nam</p>
                        </div>
                        <div class="recheck-item">
                            <input class="recheck-input" type="radio" name="user_gender" value="female" id="female" <?php echo (get_user_meta(get_current_user_id(), 'user_gender', true) === 'female') ? 'checked' : ''; ?> hidden="">
                            <div class="recheck-checkbox"></div>
                            <p class="recheck-text">Nữ</p>
                        </div>
                        <div class="recheck-item">
                            <input class="recheck-input" type="radio" name="user_gender" value="other" id="other" <?php echo (get_user_meta(get_current_user_id(), 'user_gender', true) === 'other') ? 'checked' : ''; ?> hidden="">
                            <div class="recheck-checkbox"></div>
                            <p class="recheck-text">Khác</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="acc-mpro-flex">
            <div class="acc-mpro-left">
                <p class="text">Password </p>
            </div>
            <div class="acc-mpro-right">
                <div class="ip-control">
                    <input value="12312321321" type="password" readonly=""><span class="text-show change-pass popup-open" data-popup="popup-changepass"><span class="text">CHANGE</span></span>
                </div>
            </div>
        </div>
    </form>
</div>
<!-- change pass  -->
<div class="popup popup-changepass" data-popup-id="popup-changepass">
    <div class="popup-overlay"></div>
    <div class="popup-main">
        <div class="popup-over">
            <p class="t36 fw-6 f-title t-center">CHANGE PASSWORD</p>
            <div class="popup-changepass-form">
                <form action="" id="f-change-password" class="is-loading-group">
                    <div class="ip-control ip-pass">
                        <input type="password" placeholder="Current Password" name="current-password" required>
                        <span class="text-show show-password"><span class="text">Show</span><span class="text">Hide</span></span>
                    </div>
                    <div class="ip-control ip-pass">
                        <input type="password" placeholder="New Password *" name="new-pass" required>
                        <span class="text-show show-password"><span class="text">Show</span><span class="text">Hide</span></span>
                    </div>
                    <div class="ip-control ip-pass">
                        <input type="password" placeholder="Confirm Password *" name="new-repass" required>
                        <span class="text-show show-password"><span class="text">Show</span><span class="text">Hide</span></span>
                    </div>
                    <div class="popup-changepass-link">
                        <!-- Can’t remember your password? <a class="link" href="">Email Verify</a> -->
                    </div>
                    <button class="btn btn-pri full" type="submit"><span class="text">SAVE CHANGE</span>
                    </button>
                </form>
            </div>
        </div>
        <div class="popup-close"><i class="fas fa-times icon"></i></div>
    </div>
</div>