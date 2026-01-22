<?php

/**
 * Template name: Account Page
 * @author : Hy Hý
 */
if (is_user_logged_in()) {
    get_header();
    while (have_posts()) :
        the_post();
        $itemMenu = wc_get_account_menu_items();
        $account = new Account();
?>

        <main class="main page-template">
            <div class="acc">
                <div class="acc-wrap">
                    <div class="container">
                        <div class="acc-inner" data-aos="fade-up">
                            <div class="acc-title">
                                <h1 class="title f-title fw-7">
                                    MY ACCOUNT
                                </h1>
                                <?php
                                $user_id = get_current_user_id();
                                $orders = wc_get_orders(array(
                                    'customer' => $user_id,
                                    'status'   => array('completed', 'processing'),
                                ));

                                $total_order_amount = 0;

                                foreach ($orders as $order) {
                                    $total_order_amount += $order->get_total();
                                }
                                // echo wc_price($total_order_amount);
                                $percent = $total_order_amount / 5000000 * 100;
                                ?>
                                <?php
                                if ($total_order_amount > 5000000) { ?>

                                    <div class="acc-rank"> <span class="text fw-7">
                                            CURNON + </span><span class="icon">
                                            <img src="<?php echo esc_url(get_site_url()); ?>/template/assets/images/kimcuong.svg" alt="" /></span>
                                    </div>

                                <?php } elseif ($total_order_amount < 5000000 && $total_order_amount > 2000000) { ?>

                                    <div class="acc-rank"> <span class="text fw-7">
                                            CURNON + </span><span class="icon">
                                            <img src="<?php echo esc_url(get_site_url()); ?>/template/assets/images/vang.svg" alt="" /></span>
                                    </div>

                                <?php } elseif ($total_order_amount < 2000000 && $total_order_amount > 500000) { ?>

                                    <div class="acc-rank"> <span class="text fw-7">
                                            CURNON + </span><span class="icon">
                                            <img src="<?php echo esc_url(get_site_url()); ?>/template/assets/images/bac.svg" alt="" /></span>
                                    </div>

                                <?php } else { ?>

                                    <div class="acc-rank"> <span class="text fw-7">
                                            CURNON + </span><span class="icon">
                                            <img src="<?php echo esc_url(get_site_url()); ?>/template/assets/images/dong.svg" alt="" /></span>
                                    </div>

                                <?php } ?>
                            </div>
                            <!-- <div class="acc-add">
                            <p class="text fw-5">
                                Chi tiêu thêm
                                <span class="fw-6 c-red">
                                    200.000đ
                                </span>
                                để lên hạng
                                <span class="text-str si">
                                    SILVER
                                </span>
                            </p>
                        </div> -->
                            <div class="acc-pro">
                                <div class="acc-pro-list">
                                    <div class="acc-pro-line" style="width: <?php echo $percent; ?>%; min-width: 1%; max-width: 100%;">
                                        <span class="icon">
                                            <img src="<?php echo esc_url(get_site_url()); ?>/template/assets/images/brown.svg" alt="" />
                                        </span>
                                    </div>
                                    <div class="acc-pro-item x1">
                                        <div class="acc-pro-desc">
                                            <span class="text">CURNON +
                                            </span>
                                            <span class="icon">
                                                <img src="<?php echo esc_url(get_site_url()); ?>/template/assets/images/dong.svg" alt="" />
                                            </span>
                                        </div>
                                    </div>
                                    <div class="acc-pro-item x2 active active-2">
                                        <div class="acc-pro-desc">
                                            <span class="text text-str si">
                                                SILVER
                                            </span>
                                            <span class="icon">
                                                <img src="<?php echo esc_url(get_site_url()); ?>/template/assets/images/bac.svg" alt="" />
                                            </span>
                                        </div>
                                        <div class="acc-pro-desc">
                                            <span class="text text-str go">
                                                GOLD
                                            </span>
                                            <span class="icon">
                                                <img src="<?php echo esc_url(get_site_url()); ?>/template/assets/images/vang.svg" alt="" />
                                            </span>
                                        </div>
                                    </div>
                                    <div class="acc-pro-item active">
                                        <div class="acc-pro-desc">
                                            <span class="text">
                                                DIAMOND
                                            </span><span class="icon">
                                                <img src="<?php echo esc_url(get_site_url()); ?>/template/assets/images/kimcuong.svg" alt="" /></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="acc-ctn">
                                <div class="acc-list">

                                    <?php foreach ($itemMenu as $key => $value) {
                                        $current = "";
                                        $url = esc_url(wc_get_account_endpoint_url($key));
                                        $name = $value;
                                        $icon = $account->icon_item_menu($key);
                                        if ('dashboard' === $key && (isset($wp->query_vars['page']) or empty($wp->query_vars)) or array_key_exists($key, (array) $wp->query_vars)) {
                                            $current = 'active';
                                        }
                                        if ($key == 'change-password' && array_key_exists($key, (array) $wp->query_vars)) {
                                            $current = 'active';
                                            $class = 'changepass';
                                        }
                                        if ($key == 'orders' && array_key_exists($key, (array) $wp->query_vars)) {
                                            $current = 'active';
                                            $class = 'm-orders';
                                            $clas_main = 'pfcus-his-fix';
                                        }
                                    ?>

                                        <a class="acc-item <?php echo $current; ?>" href="<?php echo $url; ?>">
                                            <?php echo $name; ?></a>

                                    <?php } ?>

                                    <!-- <a class="acc-item">HẠNG THẺ</a>
                                <a class="acc-item">SHIPPING ADDRESS</a>
                                <a class="acc-item">VÍ VOUCHER</a>
                                <a class="acc-item">BILLING HISTORY</a>
                                <a class="acc-item">WISHLIST </a> -->
                                </div>

                                <div class="acc-main">
                                    <?php the_content() ?>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <div class="popup popup-acc" data-popup-id="popup-acc" id="popup-acc">
            <div class="popup-overlay"></div>
            <div class="popup-main">
                <div class="popup-over">
                    <div class="popup-acc-flex">
                        <div class="popup-acc-left">
                            <h2 class="title fw-7 f-title"><?php _e('WELCOME TO CURNON, ', 'monamedia') ?> <br><?php $user_data = get_userdata(get_current_user_id());
                                                                                                                echo $user_data->display_name;
                                                                                                                ?></h2>
                            <p class="txt fw-5">
                                <?php _e('Chúng tôi biến sản phẩm phụ kiện không thể thiếu trở thành những biểu tượng tinh thần đầy cảm hứng, để thúc đẩy thế hệ trẻ Việt Nam không ngừng tiến lên phía trước', 'monamedia') ?>
                            </p><a class="link" href="https://curnonwatch.monamedia.net/"><?php _e('CONTINUE SHOPPING', 'monamedia') ?></a>
                        </div>
                        <div class="popup-acc-right">
                            <div class="popup-acc-img"> <img src="<?php echo esc_url(get_site_url()); ?>/template/assets/images/dblog-loca.jpg" alt="" />
                            </div>
                        </div>
                    </div>
                </div>
                <daciv class="popup-close"><i class="fas fa-times icon"></i></daciv>
            </div>
        </div>

<?php
    endwhile;
    get_footer();
} else {
    wp_redirect(site_url(''));
}
