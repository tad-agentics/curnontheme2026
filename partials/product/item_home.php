<?php
global $post;
$product_id = $post->ID;
$product = wc_get_product($product_id);
$price_html = '';
$check_stock = true;
$mona_product = new MonaProductClass();

if ($product->is_type('variable')) {
    $variation_ids = $product->get_children();
    if (count($variation_ids) > 0) {
        $variation_id = reset($variation_ids);
        $_product = new WC_Product_Variation($variation_id);
        if ($product->get_price() == 0) {
            $price_html = '<p class="price-new">' . __('Liên hệ', 'monamedia') . '</p>';
        } else {
            $price_html = $product->get_price_html();
            $percent_sale = m_get_percent_sale($_product);
        }
    }
} else {
    if ($product->get_price() == 0) {
        $price_html = '<p class="price-new">' . __('Liên hệ', 'monamedia') . '</p>';
    } else {
        $price_html = $product->get_price_html();
        $percent_sale = m_get_percent_sale($product);
    }
}

$status = $product->is_in_stock();
$link = get_the_permalink($product_id);
$title = get_the_title($product_id);
$thumbnail = get_the_post_thumbnail($product_id, 'full');

$args = array(
    'status'      => 'approve',
    'post_type'   => 'product',
    'post_id'     => $product_id,
);
$evaluates = get_comments($args);
$totalEvaluates = count($evaluates);
?>

<!-- item product  -->
<div class="hgift-item">
    <a class="hgift-img" href="<?php echo $link; ?>">
        <?php echo $thumbnail; ?>
    </a>
    <div class="hgift-desc">
        <!-- category of product  -->
        <?php
        $taxonomy = 'product_cat';
        $primary_cat_id = get_post_meta($product->id, '_yoast_wpseo_primary_' . $taxonomy, true);
        if ($primary_cat_id) {
            $primary_cat = get_term($primary_cat_id, $taxonomy);
            $primary_cat_link = get_term_link($primary_cat, $taxonomy);
            if (isset($primary_cat->name)) ?>
        <a class="link" href="<?php echo esc_url($primary_cat_link); ?>"><?php echo $primary_cat->name; ?></a>
        <?php }  ?>

        <div class="pro-price">
            <?php echo $price_html; ?>
        </div>
    </div>
</div>