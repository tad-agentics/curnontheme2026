<?php
global $product;
$taxonomy       = 'product_cat';
$primary_cat_id = get_post_meta($product->id, '_yoast_wpseo_primary_' . $taxonomy, true);
if ($primary_cat_id) {
    $sc_5_group_global  = get_field('sc_5_group_global', $taxonomy . '_' . $primary_cat_id);
    $title              = $sc_5_group_global['title'];
    $des                = $sc_5_group_global['des'];
    $content            = $sc_5_group_global['content'];
    $hinh_anh_2_sc_5_group_global = $sc_5_group_global['hinh_anh_2_sc_5_group_global'];
    if (content_exists($sc_5_group_global)) :
?>
        <div class="popup popup-sz" data-popup-id="popup-sizeguide">
            <div class="popup-overlay"></div>
            <div class="popup-main">
                <div class="popup-over">
                    <div class="popup-sz-flex">
                        <div class="popup-sz-left">
                            <div class="popup-sz-title f-title fw-7"><?php echo $title; ?></div>
                            <div class="popup-sz-text fw-6"><?php echo $des; ?></div>
                            <div class="popup-sz-table mona-content">
                                <?php echo $content; ?>
                            </div>
                        </div>
                        <div class="popup-sz-right">
                            <div class="popup-sz-img">
                                <?php echo wp_get_attachment_image($hinh_anh_2_sc_5_group_global, 'full'); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="popup-close"><i class="fas fa-times icon"></i></div>
            </div>
        </div>

<?php endif;
} ?>