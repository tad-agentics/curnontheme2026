<?php
$productId = $args['data'];
$product_obj  = wc_get_product($productId);
$repeater_pre_peeled = get_field('repeater_pre_peeled', $productId);
$stock_quantity = get_post_meta($productId, '_stock', true);
if ($product_obj->get_price() == 0) {
    $price_html == __('Liên hệ', 'monamedia');
} else {
    $price_html = $product_obj->get_price_html();
}
?>


<div class="popup popup-cart popup-attri" data-popup-id="popup-attri" id="monaAttriColor">
    <div class="popup-overlay"></div>
    <div class="popup-main">

        <form id="frmAddProduct">
            <input type="hidden" name="product_id" value="<?php echo $productId ?>">

            <div class="popup-over">
                <p class="fw-6 f-title title"><?php _e('Chọn thuộc tính', 'monamedia') ?></p>
                <div class="popup-attri-inner">

                    <?php if ($product_obj->get_type() == 'variable') { ?>
                        <?php echo (new MonaProductVariations())->Variations_html_archive($productId); ?>
                    <?php } ?>

                </div>

                <div class="popup-cart-bot mona-add-to-cart-detail" data-cookie="<?php echo $product_id ?>">
                    <a class="btn btn-pri is-loading-group" href="#">
                        <span class="text"><?php _e('THÊM GIỎ HÀNG', 'monamedia') ?></span>
                    </a>
                </div>

            </div>

        </form>

        <div class="popup-close"><i class="fas fa-times icon"></i></div>
    </div>
</div>