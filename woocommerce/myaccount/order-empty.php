<div class="container">
    <div class="cart-emp-wrapper">
        <div class="cart-emp">
            <div class="cart-emp-img">
                <img src="<?php echo get_site_url() ?>/template/assets/images/empty-cart.png" alt="">
            </div>
            <p class="cart-emp-text">
                <?php _e('Chưa có đơn hàng', '') ?>
            </p>
        </div>
        <a href="<?php echo site_url('/danh-sach-san-pham') ?>" class="btn second">
            <span class="inner">
                <span class="text"> <?php _e('Mua hàng ngay', '') ?> </span>
            </span>
        </a>
    </div>
</div>