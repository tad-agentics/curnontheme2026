<?php
$taxonomy_Material = get_terms([
    'taxonomy' => 'taxonomy_Material',
    'hide_empty' => false,
]);

$product_cat = get_terms([
    'taxonomy' => 'product_cat',
    'parent'    => 0,
    'hide_empty' => false,
]);

$taxonomy_info = get_taxonomy('taxonomy_Material');
$current_cat = get_queried_object();
?>

<div class="pcollec-fi parent-active-js">
    <div class="pcollec-fi-top add-active-js">
        <span class="icon">
            <img src="<?php echo esc_url(get_site_url()); ?>/template/assets/images/filter-icon.png" alt="" />
        </span>
        <span class="text"><?php _e('Filter', 'monamedia') ?></span>
        <span class="icon-arrow">
            <i class="fa-regular fa-chevron-down"></i>
        </span>
    </div>
    <div class="pcollec-fi-inner">
        <div class="pcollec-fi-mb">
            <div class="pcollec-fi-close left">
                <span class="icon"> <i class="fa-solid fa-arrow-left">

                    </i></span><span class="text fw-6 f-title"><?php _e('BỘ LỌC', 'monamedia') ?></span>
            </div>
            <div class="pcollec-fi-close right"><img src="<?php echo esc_url(get_site_url()); ?>/template/assets/images/close.png"
                    alt="" />
            </div>
        </div>
        <div class="pcollec-fi-flex">

            <!-- color  -->
            <?php $parent_categories = get_terms(array(
                'taxonomy' => 'category_mau_sac',
                'parent' => 0,
                'hide_empty' => false,
            ));
            if ($parent_categories) : ?>
            <div class="pcollec-fi-col">
                <p class="title fw-6"><?php _e('MÀU SẮC', 'monamedia') ?></p>
                <div class="pcollec-fi-ctn">
                    <div class="recheck">
                        <div class="recheck-block">

                            <?php foreach ($parent_categories as $item) {
                                    $category_link_parent_category = get_term_link($item);
                                    $image_color = get_field('mona_cat_color_product', $item);
                                ?>

                            <div class="recheck-item">
                                <input type="checkbox" name="taxonomy_color[<?php echo $item->taxonomy ?>][]"
                                    id="<?php echo $item->slug; ?>" class="recheck-input monaFilterJS"
                                    value="<?php echo $item->slug ?>" hidden>
                                <div class="recheck-checkbox">
                                    <?php echo wp_get_attachment_image($image_color, 'full'); ?>
                                </div>
                            </div>

                            <?php } ?>

                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!-- kích thước   -->
            <?php $parent_categories = get_terms(array(
                'taxonomy' => 'category_kich_thuong_mat',
                'parent' => 0,
                'hide_empty' => false,
            ));
            if ($parent_categories) : ?>

            <div class="pcollec-fi-col pcollec-fi-check">
                <p class="title fw-6"><?php _e('KÍCH THƯỚC MẶT', 'monamedia') ?></p>
                <div class="pcollec-fi-ctn">
                    <div class="recheck">
                        <div class="recheck-block">

                            <?php foreach ($parent_categories as $item) { ?>

                            <div class="recheck-item">
                                <input type="checkbox" name="taxonomy_size[<?php echo $item->taxonomy ?>][]"
                                    id="<?php echo $item->slug; ?>" class="recheck-input monaFilterJS"
                                    value="<?php echo $item->slug ?>" hidden>
                                <div class="recheck-checkbox"></div>
                                <p class="recheck-text"><?php echo $item->name;  ?></p>
                            </div>

                            <?php } ?>

                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!-- chất liệu  -->
            <?php $parent_categories = get_terms(array(
                'taxonomy' => 'category_chat_lieu_day',
                'parent' => 0,
                'hide_empty' => false,
            ));
            if ($parent_categories) : ?>
            <div class="pcollec-fi-col pcollec-fi-check">
                <p class="title fw-6"><?php _e('CHẤT LIỆU DÂY', 'monamedia') ?></p>
                <div class="pcollec-fi-ctn">
                    <div class="recheck">
                        <div class="recheck-block">

                            <?php foreach ($parent_categories as $item) { ?>

                            <div class="recheck-item">
                                <input type="checkbox" name="taxonomy_material[<?php echo $item->taxonomy ?>][]"
                                    id="<?php echo $item->slug; ?>" class="recheck-input monaFilterJS"
                                    value="<?php echo $item->slug ?>" hidden>
                                <div class="recheck-checkbox"></div>
                                <p class="recheck-text"><?php echo $item->name;  ?></p>
                            </div>

                            <?php } ?>

                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>

        </div>
        <div class="pcollec-fi-inner-bot">
            <button class="link c-red fw-5">
                RESET
            </button>
        </div>
    </div>
</div>