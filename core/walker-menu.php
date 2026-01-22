<?php
class Mona_Walker_Nav_Menu extends Walker_Nav_Menu
{

    function start_lvl(&$output, $depth = 0, $args = array())
    {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<ul class='menu-list'>\n";
    }

    function end_lvl(&$output, $depth = 0, $args = array())
    {
        $indent = str_repeat("\t", $depth);
        $output .= "$indent</ul>\n";
    }

    function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0)
    {
        $object = $item->object;
        $type = $item->type;
        $title = $item->title;
        $description = $item->description;
        $permalink = $item->url;

        $output .= "<li class='" .  implode(" ", $item->classes) . "'>";

        //Add SPAN if no Permalink
        if ($permalink && $permalink != '#') {
            $output .= '<a class="menu-link" href="' . $permalink . '">';
        } else {
            $output .= '<a class="menu-link" href="javascript:;">';
        }

        $output .= $title;

        if ($permalink && $permalink != '#') {
            $output .= '</a>';
        } else {
            $output .= '</a>';
        }

        if (is_page_template('page-template/policy-template.php')) {
            $output .= '<i class="fas fa-chevron-right"></i>';
        }

        // if ( $args->walker->has_children ) {
        //     $output .= '<i class="bx bxs-chevron-down"></i>';
        // }

    }
}

class Mona_Walker_Nav_Menu_Frimary extends Walker_Nav_Menu
{

    function start_lvl(&$output, $depth = 0, $args = array())
    {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<ul class='menu-list'>\n";
    }

    function end_lvl(&$output, $depth = 0, $args = array())
    {
        $indent = str_repeat("\t", $depth);
        $output .= "$indent</ul>\n";
    }

    function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0)
    {
        $object = $item->object;
        $type = $item->type;
        $title = $item->title;
        $description = $item->description;
        $permalink = $item->url;

        $mona_select_megamenu = get_field('mona_select_megamenu', $item);

        $output .= "<li class='dropdown " .  implode(" ", $item->classes) . "'>";

        //Add SPAN if no Permalink
        if ($permalink && $permalink != '#') {
            $output .= '<a class="menu-link" href="' . $permalink . '">';
        } else {
            $output .= '<a class="menu-link" href="javascript:;">';
        }

        $output .= $title;

        if ($permalink && $permalink != '#') {
            $output .= '</a>';
        } else {
            $output .= '</a>';
        }

        if (is_page_template('page-template/policy-template.php')) {
            $output .= '<i class="fas fa-chevron-right"></i>';
        }

        // if ( $args->walker->has_children ) {
        //     $output .= '<i class="bx bxs-chevron-down"></i>';
        // }

        if ($mona_select_megamenu == '2') {
            $output .= self::MenuMegaContent($item);
        }
        if ($mona_select_megamenu == '3') {
            $output .= self::MenuMegaContent_3($item);
        }
        if ($mona_select_megamenu == '4') {
            $output .= self::MenuMegaContent_4($item);
        }
    }


    function MenuMegaContent($item)
    {
        ob_start();
        $mona_tax_nam_gioi          = get_field('mona_tax_nam_gioi', $item);
        $parent_cat_dong_ho_nam     = get_term_by('slug', 'dong-ho-nam', 'product_cat');
        $parent_cat_trang_suc_nam   = get_term_by('slug', 'trang-suc-nam', 'product_cat');
        $parent_cat_day_dong_ho     = get_term_by('slug', 'day-dong-ho-nam', 'product_cat');
        $parent_cat_best_sellers    = get_term_by('slug', 'best-sellers', 'product_cat');
        $link_2_best_sellers        = get_field('link_2_best_sellers', MONA_PAGE_HOME);
?>

        <div class="mega-menu">
            <div class="container">
                <div class="mega-menu-flex">

                    <?php if ($mona_tax_nam_gioi) : ?>

                        <div class="mega-menu-left">
                            <ul class="menu-list" id="MenuFrimary">

                                <?php foreach ($mona_tax_nam_gioi as $key => $item) {
                                    $link_item = get_term_link($item);
                                ?>

                                    <li class="menu-item">
                                        <!-- actived -->
                                        <a class="menu-link" href="<?php echo esc_url($link_item); ?>">
                                            <?php echo $item->name; ?>
                                        </a>
                                    </li>


                                <?php  } ?>

                            </ul>
                            <div class="mega-menu-left-btn">
                                <a class="link" href="<?php echo site_url('dong-ho/dong-ho-nam/'); ?>"><?php _e('SHOP ALL PRODUCTS', 'monamedia') ?></a>
                            </div>
                        </div>



                        <div class="mega-menu-right">

                            <!-- đồng hồ nam  -->
                            <?php if ($parent_cat_dong_ho_nam && is_object($parent_cat_dong_ho_nam)) {
                                $child_cats = get_terms([
                                    'taxonomy'   => 'product_cat',
                                    'parent'     => $parent_cat_dong_ho_nam->term_id,
                                    'hide_empty' => false,
                                ]);
                                if (!empty($child_cats) || isset($child_cats)) {  ?>

                                    <div class="mega-menu-hover showed">
                                        <div class="mega-dh">
                                            <div class="mega-dh-top">
                                                <p class="t16 fw-5">

                                                    <?php if ($parent_cat_dong_ho_nam->count > 0) : ?>
                                                        <span class="c-second">
                                                            <?php echo $parent_cat_dong_ho_nam->count; ?>
                                                        </span>
                                                        <?php _e(' sản phẩm đồng hồ nam', 'monamedia') ?>
                                                    <?php endif; ?>

                                                </p>

                                                <a class="mega-dh-top-link" href="<?php echo site_url('dong-ho/dong-ho-nam/'); ?>"><?php _e('SHOP ALL', 'monamedia') ?></a>

                                            </div>
                                            <div class="mega-dh-list">

                                                <?php foreach ($child_cats as $child_cat) {
                                                    $link_child_cat = get_term_link($child_cat);
                                                    $image_product_cat = get_term_meta($child_cat->term_id, 'thumbnail_id', true); ?>

                                                    <a class="mega-dh-item" href="<?php echo esc_url($link_child_cat); ?>">
                                                        <span class="mega-dh-img">
                                                            <?php echo wp_get_attachment_image($image_product_cat, 'full'); ?>
                                                        </span>
                                                        <span class="mega-dh-name">
                                                            <?php echo $child_cat->name; ?>
                                                        </span>
                                                    </a>

                                                <?php } ?>

                                            </div>
                                        </div>
                                    </div>

                            <?php }
                            } ?>


                            <?php if ($parent_cat_trang_suc_nam && is_object($parent_cat_trang_suc_nam)) {
                                $child_cats = get_terms([
                                    'taxonomy'   => 'product_cat',
                                    'parent'     => $parent_cat_trang_suc_nam->term_id,
                                    'hide_empty' => false,
                                ]);
                                if (!empty($child_cats) || isset($child_cats)) {  ?>

                                    <!-- trang sức nam  -->
                                    <div class="mega-menu-hover">
                                        <div class="mega-ts">
                                            <div class="mega-ts-list">

                                                <?php foreach ($child_cats as $child_cat) {
                                                    $link_child_cat = get_term_link($child_cat);
                                                    $image_child_cat = get_term_meta($child_cat->term_id, 'thumbnail_id', true)
                                                ?>

                                                    <div class="mega-ts-item">
                                                        <div class="mega-ts-img">
                                                            <a class="box" href="<?php echo esc_url($link_child_cat); ?>">
                                                                <?php echo wp_get_attachment_image($image_child_cat, 'full'); ?>
                                                            </a>
                                                        </div>
                                                        <a class="mega-ts-name" href="<?php echo esc_url($link_child_cat); ?>"><?php echo $child_cat->name; ?></a>
                                                    </div>

                                                <?php } ?>


                                            </div>
                                        </div>
                                    </div>

                            <?php }
                            } ?>


                            <?php if ($parent_cat_day_dong_ho && is_object($parent_cat_day_dong_ho)) {
                                $child_cats = get_terms([
                                    'taxonomy'   => 'product_cat',
                                    'parent'     => $parent_cat_day_dong_ho->term_id,
                                    'hide_empty' => false,
                                ]);
                                if (!empty($child_cats) || isset($child_cats)) {  ?>

                                    <!-- dây đồng hồ   -->
                                    <div class="mega-menu-hover">
                                        <div class="mega-ddh">
                                            <div class="mega-dh-top">
                                                <p class="t16 fw-5">
                                                    <?php if ($parent_cat_day_dong_ho->count > 0) : ?>
                                                        <span class="c-second">
                                                            <?php echo $parent_cat_day_dong_ho->count; ?>
                                                        </span>
                                                        <?php _e(' sản phẩm dây đồng hồ nam', 'monamedia') ?>
                                                    <?php endif; ?>
                                                </p>

                                                <a class="mega-dh-top-link" href="<?php echo site_url('dong-ho/day-dong-ho-nam'); ?>"><?php _e('SHOP ALL', 'monamedia') ?></a>
                                            </div>
                                            <div class="swiper megaddhSwiper">
                                                <div class="swiper-wrapper">

                                                    <?php foreach ($child_cats as $child_cat) {
                                                        $link_child_cat = get_term_link($child_cat);
                                                        $image_child_cat = get_term_meta($child_cat->term_id, 'thumbnail_id', true)
                                                    ?>

                                                        <div class="swiper-slide">
                                                            <div class="mega-ddh-item">
                                                                <div class="mega-ddh-img">
                                                                    <a class="box" href="<?php echo esc_url($link_child_cat); ?>">
                                                                        <?php echo wp_get_attachment_image($image_child_cat, 'full'); ?>
                                                                    </a>
                                                                </div>
                                                                <a class="mega-ddh-name" href="<?php echo esc_url($link_child_cat); ?>"><?php echo $child_cat->name; ?></a>
                                                            </div>
                                                        </div>

                                                    <?php } ?>

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                            <?php }
                            } ?>

                            <?php if ($parent_cat_best_sellers && is_object($parent_cat_best_sellers)) {
                                $mona_sc1_group_bestsellers_nam = get_field('mona_sc1_group_bestsellers_nam', MONA_PAGE_HOME);
                                $mona_hinh_anh_1_best_sellers = $mona_sc1_group_bestsellers_nam['mona_hinh_anh_1_best_sellers'];
                                $tieu_de_1_best_sellers = $mona_sc1_group_bestsellers_nam['tieu_de_1_best_sellers'];
                                $link_best_sellers = $mona_sc1_group_bestsellers_nam['link_best_sellers'];
                                $mona_hinh_anh_2_best_sellers = $mona_sc1_group_bestsellers_nam['mona_hinh_anh_2_best_sellers'];
                                $tieu_de_2_best_sellers = $mona_sc1_group_bestsellers_nam['tieu_de_2_best_sellers'];
                                $link_2_best_sellers = $mona_sc1_group_bestsellers_nam['link_2_best_sellers'];
                            ?>

                                <!-- best sellers   -->
                                <div class="mega-menu-hover">
                                    <div class="mega-bs">
                                        <div class="mega-bs-flex">
                                            <div class="mega-bs-left">
                                                <div class="mega-bs-img">
                                                    <div class="box">
                                                    <a href="<?php echo $link_best_sellers; ?>"><?php echo wp_get_attachment_image($mona_hinh_anh_1_best_sellers, 'full'); ?></a>
                                                    </div>
                                                    <span class="text">
                                                        <?php echo $tieu_de_1_best_sellers; ?>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="mega-bs-right">
                                                <div class="mega-bs-simg">
                                                    <div class="box">
                                                        <?php echo wp_get_attachment_image($mona_hinh_anh_2_best_sellers, 'full'); ?>
                                                    </div>
                                                </div>
                                                <div class="mega-bs-desc">
                                                    <span class="text"><?php echo $tieu_de_2_best_sellers; ?></span><a class="mega-bs-link" href="<?php echo $link_2_best_sellers; ?>"><?php _e('SHOP NOW', 'monamedia') ?></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            <?php  } ?>

                            <?php
                            $count = 4;

                            $args = array(
                                'post_type'      => 'product',
                                'post_status'    => 'publish',
                                'order' => 'DESC',
                                'posts_per_page' => $count,
                                'tax_query'     => array(
                                    array(
                                        'taxonomy' => 'product_visibility',
                                        'field'    => 'name',
                                        'terms'    => 'featured',
                                        'operator' => 'IN',
                                    ),
                                ),
                            );

                            $Query_Feature  = new WP_Query($args);
                            $number         = $Query_Feature->post_count;

                            if ($Query_Feature->have_posts()) {
                            ?>

                                <div class="mega-menu-hover">
                                    <div class="mega-new">
                                        <div class="mega-dh-top">
                                            <p class="t16 fw-5">
                                                <span class="c-second"><?php echo $number; ?>
                                                </span><?php _e('sản phẩm mới nhất', 'monamedia'); ?>
                                            </p>
                                            <a class="mega-dh-top-link" href="<?php echo esc_url($link_2_best_sellers); ?>"><?php _e('SHOP ALL', 'monamedia'); ?></a>
                                        </div>

                                        <div class="swiper megaNewSwiper">
                                            <div class="swiper-wrapper">

                                                <?php
                                                while ($Query_Feature->have_posts()) :
                                                    $Query_Feature->the_post();
                                                ?>

                                                    <div class="swiper-slide">
                                                        <div class="pro-item">

                                                            <?php get_template_part('partials/product/item');  ?>

                                                        </div>
                                                    </div>

                                                <?php
                                                endwhile;
                                                wp_reset_postdata();
                                                ?>

                                            </div>
                                        </div>

                                    </div>
                                </div>

                            <?php } else { ?>

                                <div class="mega-menu-hover">
                                    <div class="mega-new">
                                        <div class="container">
                                            <div class="empty-product">
                                                <a class="image-empty-product" href="<?php echo home_url(); ?>">
                                                    <img src="<?php get_site_url(); ?>/template/assets/images/empty-cart-curnon.png" alt="this is a image of empty product">
                                                </a>
                                                <p class="text">
                                                    <?php _e('Hiện tại, sản phẩm bạn tìm kiếm hiện đang cập nhật. Vui lòng quay lại sau hoặc liên hệ với chúng tôi.', 'monamedia'); ?>
                                                </p>
                                                <?php if (is_cart()) : ?>
                                                    <a class="btn btn-pri" href="<?php echo home_url(); ?>">
                                                        <span class="text"> <?php _e('TIẾP TỤC MUA SẮM', 'monamedia') ?></span>
                                                    </a>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            <?php } ?>

                        </div>

                    <?php endif; ?>

                </div>
            </div>
        </div>

    <?php
        return ob_get_clean();
    }

    // Nữ giới 
    function MenuMegaContent_3($item)
    {
        ob_start();
        $mona_tax_nu_gioi = get_field('mona_tax_nu_gioi', $item);
        $parent_cat_dong_ho_nu = get_term_by('slug', 'dong-ho-nu', 'product_cat');
        $parent_cat_trang_suc_nu = get_term_by('slug', 'trang-suc-nu', 'product_cat');
        $parent_cat_day_dong_ho_nu = get_term_by('slug', 'day-dong-ho-nu', 'product_cat');
        $parent_cat_best_sellers = get_term_by('slug', 'best-sellers', 'product_cat');
        $link_2_best_sellers = get_field('link_2_best_sellers', MONA_PAGE_HOME);

    ?>

        <div class="mega-menu">
            <div class="container">
                <div class="mega-menu-flex">

                    <?php if ($mona_tax_nu_gioi) : ?>

                        <div class="mega-menu-left">
                            <ul class="menu-list">

                                <?php foreach ($mona_tax_nu_gioi as $key => $item) {
                                    $link_item = get_term_link($item);
                                ?>

                                    <li class="menu-item">
                                        <!-- actived -->
                                        <a class="menu-link" href="<?php echo esc_url($link_item); ?>">
                                            <?php echo $item->name; ?>
                                        </a>
                                    </li>


                                <?php  } ?>

                            </ul>
                            <div class="mega-menu-left-btn">
                                <a class="link" href="<?php echo site_url('dong-ho/dong-ho-nu'); ?>"><?php _e('SHOP ALL PRODUCTS', 'monamedia') ?></a>
                            </div>
                        </div>

                        <div class="mega-menu-right">

                            <!-- đồng hồ nữ  -->
                            <?php if ($parent_cat_dong_ho_nu && is_object($parent_cat_dong_ho_nu)) {
                                $child_cats = get_terms([
                                    'taxonomy'   => 'product_cat',
                                    'parent'     => $parent_cat_dong_ho_nu->term_id,
                                    'hide_empty' => false,
                                ]);
                                if (!empty($child_cats) || isset($child_cats)) {  ?>

                                    <div class="mega-menu-hover showed">
                                        <div class="mega-dh">
                                            <div class="mega-dh-top">
                                                <p class="t16 fw-5">

                                                    <?php if ($parent_cat_dong_ho_nu->count > 0) : ?>
                                                        <span class="c-second">
                                                            <?php echo $parent_cat_dong_ho_nu->count; ?>
                                                        </span>
                                                        <?php _e(' sản phẩm đồng hồ nữ', 'monamedia') ?>
                                                    <?php endif; ?>

                                                </p>
                                                <a class="mega-dh-top-link" href="<?php echo site_url('dong-ho/dong-ho-nu'); ?>"><?php _e('SHOP ALL', 'monamedia') ?></a>
                                            </div>
                                            <div class="mega-dh-list">

                                                <?php foreach ($child_cats as $child_cat) {
                                                    $link_child_cat = get_term_link($child_cat);
                                                    $image_product_cat = get_term_meta($child_cat->term_id, 'thumbnail_id', true); ?>

                                                    <a class="mega-dh-item" href="<?php echo esc_url($link_child_cat); ?>">
                                                        <span class="mega-dh-img">
                                                            <?php echo wp_get_attachment_image($image_product_cat, 'full'); ?>
                                                        </span>
                                                        <span class="mega-dh-name">
                                                            <?php echo $child_cat->name; ?>
                                                        </span>
                                                    </a>

                                                <?php } ?>

                                            </div>
                                        </div>
                                    </div>

                            <?php }
                            } ?>


                            <?php if ($parent_cat_trang_suc_nu && is_object($parent_cat_trang_suc_nu)) {
                                $child_cats = get_terms([
                                    'taxonomy'   => 'product_cat',
                                    'parent'     => $parent_cat_trang_suc_nu->term_id,
                                    'hide_empty' => false,
                                ]);
                                if (!empty($child_cats) || isset($child_cats)) {  ?>
                                    <!-- trang sức nu  -->
                                    <div class="mega-menu-hover">
                                        <div class="mega-ts">
                                            <div class="mega-ts-list">

                                                <?php foreach ($child_cats as $child_cat) {
                                                    $link_child_cat = get_term_link($child_cat);
                                                    $image_child_cat = get_term_meta($child_cat->term_id, 'thumbnail_id', true)
                                                ?>

                                                    <div class="mega-ts-item">
                                                        <div class="mega-ts-img">
                                                            <a class="box" href="<?php echo esc_url($link_child_cat); ?>">
                                                                <?php echo wp_get_attachment_image($image_child_cat, 'full'); ?>
                                                            </a>
                                                        </div>
                                                        <a class="mega-ts-name" href="<?php echo esc_url($link_child_cat); ?>"><?php echo $child_cat->name; ?></a>
                                                    </div>

                                                <?php } ?>


                                            </div>
                                        </div>
                                    </div>

                            <?php }
                            } ?>


                            <?php if ($parent_cat_day_dong_ho_nu && is_object($parent_cat_day_dong_ho_nu)) {
                                $child_cats = get_terms([
                                    'taxonomy'   => 'product_cat',
                                    'parent'     => $parent_cat_day_dong_ho_nu->term_id,
                                    'hide_empty' => false,
                                ]);
                                if (!empty($child_cats) || isset($child_cats)) {  ?>
                                    <!-- dây đồng hồ nữ  -->
                                    <div class="mega-menu-hover">
                                        <div class="mega-ddh">
                                            <div class="mega-dh-top">
                                                <p class="t16 fw-5">
                                                    <?php if ($parent_cat_day_dong_ho_nu->count > 0) : ?>
                                                        <span class="c-second">
                                                            <?php echo $parent_cat_day_dong_ho_nu->count; ?>
                                                        </span>
                                                        <?php _e(' sản phẩm dây đồng hồ nữ', 'monamedia') ?>
                                                    <?php endif; ?>
                                                </p>

                                                <a class="mega-dh-top-link" href="<?php echo site_url('dong-ho/day-dong-ho-nu'); ?>"><?php _e('SHOP ALL', 'monamedia') ?></a>
                                            </div>
                                            <div class="swiper megaddhSwiper">
                                                <div class="swiper-wrapper">

                                                    <?php foreach ($child_cats as $child_cat) {
                                                        $link_child_cat = get_term_link($child_cat);
                                                        $image_child_cat = get_term_meta($child_cat->term_id, 'thumbnail_id', true)
                                                    ?>

                                                        <div class="swiper-slide">
                                                            <div class="mega-ddh-item">
                                                                <div class="mega-ddh-img">
                                                                    <a class="box" href="<?php echo esc_url($link_child_cat); ?>">
                                                                        <?php echo wp_get_attachment_image($image_child_cat, 'full'); ?>
                                                                    </a>
                                                                </div>
                                                                <a class="mega-ddh-name" href="<?php echo esc_url($link_child_cat); ?>"><?php echo $child_cat->name; ?></a>
                                                            </div>
                                                        </div>

                                                    <?php } ?>

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                            <?php }
                            } ?>

                            <?php if ($parent_cat_best_sellers && is_object($parent_cat_best_sellers)) {
                                $mona_sc2_group_bestsellers_nu = get_field('mona_sc2_group_bestsellers_nu', MONA_PAGE_HOME);
                                $mona_hinh_anh_1_best_sellers = $mona_sc2_group_bestsellers_nu['mona_hinh_anh_1_best_sellers'];
                                $tieu_de_1_best_sellers = $mona_sc2_group_bestsellers_nu['tieu_de_1_best_sellers'];
                                $link_best_sellers = $mona_sc2_group_bestsellers_nu['link_best_sellers'];
                                $mona_hinh_anh_2_best_sellers = $mona_sc2_group_bestsellers_nu['mona_hinh_anh_2_best_sellers'];
                                $tieu_de_2_best_sellers = $mona_sc2_group_bestsellers_nu['tieu_de_2_best_sellers'];
                                $link_2_best_sellers = $mona_sc2_group_bestsellers_nu['link_2_best_sellers'];

                            ?>
                                <!-- best sellers   -->
                                <div class="mega-menu-hover">
                                    <div class="mega-bs">
                                        <div class="mega-bs-flex">
                                            <div class="mega-bs-left">
                                                <div class="mega-bs-img">
                                                    <div class="box">
                                                    <a href="<?php echo $link_best_sellers; ?>"> <?php echo wp_get_attachment_image($mona_hinh_anh_1_best_sellers, 'full'); ?></a>
                                                    </div>
                                                    <span class="text">
                                                        <?php echo $tieu_de_1_best_sellers; ?>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="mega-bs-right">
                                                <div class="mega-bs-simg">
                                                    <div class="box">
                                                        <?php echo wp_get_attachment_image($mona_hinh_anh_2_best_sellers, 'full'); ?>
                                                    </div>
                                                </div>
                                                <div class="mega-bs-desc">
                                                    <span class="text"><?php echo $tieu_de_2_best_sellers; ?></span><a class="mega-bs-link" href="<?php echo $link_2_best_sellers; ?>"><?php _e('SHOP NOW', 'monamedia') ?></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            <?php  } ?>

                            <?php
                            $count = 4;

                            $args = array(
                                'post_type'      => 'product',
                                'post_status'    => 'publish',
                                'order' => 'DESC',
                                'posts_per_page' => $count,
                                'tax_query'     => array(
                                    array(
                                        'taxonomy' => 'product_visibility',
                                        'field'    => 'name',
                                        'terms'    => 'featured',
                                        'operator' => 'IN',
                                    ),
                                ),
                            );



                            $Query_Feature = new WP_Query($args);
                            $number = $Query_Feature->post_count;

                            if ($Query_Feature->have_posts()) {
                            ?>

                                <div class="mega-menu-hover">
                                    <div class="mega-new">
                                        <div class="mega-dh-top">
                                            <p class="t16 fw-5">
                                                <span class="c-second"><?php echo $number; ?>
                                                </span><?php _e('sản phẩm mới nhất', 'monamedia'); ?>
                                            </p>
                                            <a class="mega-dh-top-link" href="<?php echo site_url('dong-ho'); ?>"><?php _e('SHOP ALL', 'monamedia'); ?></a>
                                        </div>

                                        <div class="swiper megaNewSwiper">
                                            <div class="swiper-wrapper">

                                                <?php
                                                while ($Query_Feature->have_posts()) :
                                                    $Query_Feature->the_post();
                                                ?>

                                                    <div class="swiper-slide">
                                                        <div class="pro-item">

                                                            <?php get_template_part('partials/product/item');  ?>

                                                        </div>
                                                    </div>

                                                <?php
                                                endwhile;
                                                wp_reset_postdata();
                                                ?>

                                            </div>
                                        </div>

                                    </div>
                                </div>

                            <?php } else { ?>

                                <div class="mega-menu-hover">
                                    <div class="mega-new">
                                        <div class="container">
                                            <div class="empty-product">
                                                <a class="image-empty-product" href="<?php echo home_url(); ?>">
                                                    <img src="<?php get_site_url(); ?>/template/assets/images/empty-cart-curnon.png" alt="this is a image of empty product">
                                                </a>
                                                <p class="text">
                                                    <?php _e('Hiện tại, sản phẩm bạn tìm kiếm hiện đang cập nhật. Vui lòng quay lại sau hoặc liên hệ với chúng tôi.', 'monamedia'); ?>
                                                </p>
                                                <?php if (is_cart()) : ?>
                                                    <a class="btn btn-pri" href="<?php echo home_url(); ?>">
                                                        <span class="text"> <?php _e('TIẾP TỤC MUA SẮM', 'monamedia') ?></span>
                                                    </a>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            <?php } ?>

                        </div>

                    <?php endif; ?>

                </div>
            </div>
        </div>

    <?php
        return ob_get_clean();
    }

    // quà tặng 
    function MenuMegaContent_4($item)
    {
        ob_start();
        $mona_tax_qua_tang = get_field('mona_tax_qua_tang', $item);

    ?>

        <?php if ($mona_tax_qua_tang) : ?>

            <div class="mega-menu mega-qt">
                <div class="container">
                    <div class="mega-qt-list">

                        <?php foreach ($mona_tax_qua_tang as $key => $item) {
                            $link_item = get_term_link($item);
                            $image_product_cat = get_term_meta($item->term_id, 'thumbnail_id', true);
                        ?>

                            <div class="mega-qt-item">
                                <div class="mega-qt-box">
                                    <a class="mega-qt-img" href="<?php echo esc_url($link_item); ?>">
                                        <?php echo wp_get_attachment_image($image_product_cat, 'full'); ?>
                                    </a>
                                    <a class="mega-qt-name fw-5"><?php echo $item->name; ?></a>
                                </div>
                            </div>

                        <?php } ?>

                    </div>
                </div>
            </div>

        <?php endif; ?>

    <?php
        return ob_get_clean();
    }
}
// mobile version
class Mona_Walker_Nav_Menu_Mobile extends Walker_Nav_Menu
{

    function start_lvl(&$output, $depth = 0, $args = array())
    {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<ul class='menu-list'>\n";
    }

    function end_lvl(&$output, $depth = 0, $args = array())
    {
        $indent = str_repeat("\t", $depth);
        $output .= "$indent</ul>\n";
    }

    function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0)
    {
        $object = $item->object;
        $type = $item->type;
        $title = $item->title;
        $description = $item->description;
        $permalink = $item->url;

        $mona_select_megamenu = get_field('mona_select_megamenu', $item);

        $output .= "<li class='dropdown " .  implode(" ", $item->classes) . "'>";

        //Add SPAN if no Permalink
        if ($permalink && $permalink != '#') {
            $output .= '<a class="menu-link" href="' . $permalink . '">';
        } else {
            $output .= '<a class="menu-link" href="javascript:;">';
        }

        $output .= $title;

        if ($permalink && $permalink != '#') {
            $output .= '</a>';
            $output .= ' <span class="show-sub-menu-js icon"> <i class="fa-solid fa-chevron-right"></i></span>';
        } else {
            $output .= '</a>';
            $output .= ' <span class="show-sub-menu-js icon"> <i class="fa-solid fa-chevron-right"></i></span>';
        }

        if (is_page_template('page-template/policy-template.php')) {
            $output .= '<i class="fas fa-chevron-right"></i>';
        }

        // if ( $args->walker->has_children ) {
        //     $output .= '<i class="bx bxs-chevron-down"></i>';
        // }

        if ($mona_select_megamenu == '2') {
            // $output .= self::MenuMegaContent($item);
        }
        if ($mona_select_megamenu == '3') {
            // $output .= self::MenuMegaContent_3($item);
        }
        if ($mona_select_megamenu == '4') {
            // $output .= self::MenuMegaContent_4($item);
        }
    }

    // code ở dưới là đập source xây lại không liên quan gì hết có thể bỏ qua nha sợ 
    // khách quay lại giao diện cũ nên mới để code cũ lại <3 
    function MenuMegaContent($item)
    {
        ob_start();
        // $mona_tax_nam_gioi = get_field('mona_tax_nam_gioi', $item);
        $parent_cat_dong_ho_nam = get_term_by('slug', 'dong-ho-nam', 'product_cat');
        $parent_cat_trang_suc_nam = get_term_by('slug', 'trang-suc-nam', 'product_cat');
        $parent_cat_day_dong_ho = get_term_by('slug', 'day-dong-ho', 'product_cat');
        $parent_cat_best_sellers = get_term_by('slug', 'best-sellers', 'product_cat');
        $link_2_best_sellers = get_field('link_2_best_sellers', MONA_PAGE_HOME);
    ?>

        <!-- <div class="mobile-sub mobile-sub-js"><a class="mobile-sub-pre"> <span class="icon"> <i class="fa-solid fa-arrow-left"></i></span><span class="text f-title">NAM</span></a>
            <div class="mobile-sub-ctn">
                <div class="mobile-sub-item">
                    <div class="mobile-sub-item-top tech-item-head"><span class="text">ĐỒNG HỒ NAM</span><a class="mobile-sub-link">SHOP ALL</a></div>
                    <div class="mobile-sub-main tech-body">
                        <div class="mega-dh-list"> <a class="mega-dh-item"> <span class="mega-dh-img"> <img src="<?php get_site_url(); ?>/template/assets/images/megadh.png" alt="" /></span><span class="mega-dh-name">KASHMIR</span></a><a class="mega-dh-item"> <span class="mega-dh-img">
                                    <img src="<?php get_site_url(); ?>/template/assets/images/megadh.png" alt="" /></span><span class="mega-dh-name">KASHMIR</span></a><a class="mega-dh-item"> <span class="mega-dh-img">
                                    <img src="<?php get_site_url(); ?>/template/assets/images/megadh.png" alt="" /></span><span class="mega-dh-name">KASHMIR</span></a><a class="mega-dh-item"> <span class="mega-dh-img">
                                    <img src="<?php get_site_url(); ?>/template/assets/images/megadh.png" alt="" /></span><span class="mega-dh-name">KASHMIR</span></a><a class="mega-dh-item"> <span class="mega-dh-img">
                                    <img src="<?php get_site_url(); ?>/template/assets/images/megadh.png" alt="" /></span><span class="mega-dh-name">KASHMIR</span></a><a class="mega-dh-item"> <span class="mega-dh-img">
                                    <img src="<?php get_site_url(); ?>/template/assets/images/megadh.png" alt="" /></span><span class="mega-dh-name">KASHMIR</span></a><a class="mega-dh-item"> <span class="mega-dh-img">
                                    <img src="<?php get_site_url(); ?>/template/assets/images/megadh.png" alt="" /></span><span class="mega-dh-name">KASHMIR</span></a><a class="mega-dh-item"> <span class="mega-dh-img">
                                    <img src="<?php get_site_url(); ?>/template/assets/images/megadh.png" alt="" /></span><span class="mega-dh-name">KASHMIR</span></a>
                        </div>
                    </div>
                </div>
                <div class="mobile-sub-item">
                    <div class="mobile-sub-item-top tech-item-head"><span class="text">TRANG SỨC
                            NAM</span><a class="mobile-sub-link">SHOP ALL</a></div>
                    <div class="mobile-sub-main tech-body">
                        <div class="mega-ts-list">
                            <div class="mega-ts-item">
                                <div class="mega-ts-img"> <a class="box"><img src="<?php get_site_url(); ?>/template/assets/images/ts1.jpg" alt="" /></a></div><a class="mega-ts-name">VÒNG TAY</a>
                            </div>
                            <div class="mega-ts-item">
                                <div class="mega-ts-img"> <a class="box"><img src="<?php get_site_url(); ?>/template/assets/images/ts2.jpg" alt="" /></a></div><a class="mega-ts-name">DÂY CHUYỀN</a>
                            </div>
                            <div class="mega-ts-item">
                                <div class="mega-ts-img"> <a class="box"><img src="<?php get_site_url(); ?>/template/assets/images/ts3.jpg" alt="" /></a></div><a class="mega-ts-name">NHẪN</a>
                            </div>
                            <div class="mega-ts-item">
                                <div class="mega-ts-img"> <a class="box"><img src="<?php get_site_url(); ?>/template/assets/images/ts4.jpg" alt="" /></a></div><a class="mega-ts-name">BÔNG TAI</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mobile-sub-item">
                    <div class="mobile-sub-item-top tech-item-head"><span class="text">DÂY ĐỒNG HỒ</span><a class="mobile-sub-link">SHOP ALL</a></div>
                    <div class="mobile-sub-main tech-body">
                        <div class="swiper megaddhSwiper">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <div class="mega-ddh-item">
                                        <div class="mega-ddh-img"> <a class="box"><img src="<?php get_site_url(); ?>/template/assets/images/ddh (1).png" alt="" /></a></div><a class="mega-ddh-name">DÂY VẢI</a>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="mega-ddh-item">
                                        <div class="mega-ddh-img"> <a class="box"><img src="<?php get_site_url(); ?>/template/assets/images/ddh (2).png" alt="" /></a></div><a class="mega-ddh-name">DÂY VẢI</a>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="mega-ddh-item">
                                        <div class="mega-ddh-img"> <a class="box"><img src="<?php get_site_url(); ?>/template/assets/images/ddh (3).png" alt="" /></a></div><a class="mega-ddh-name">DÂY VẢI</a>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="mega-ddh-item">
                                        <div class="mega-ddh-img"> <a class="box"><img src="<?php get_site_url(); ?>/template/assets/images/ddh (4).png" alt="" /></a></div><a class="mega-ddh-name">DÂY VẢI</a>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="mega-ddh-item">
                                        <div class="mega-ddh-img"> <a class="box"><img src="<?php get_site_url(); ?>/template/assets/images/ddh (5).png" alt="" /></a></div><a class="mega-ddh-name">DÂY VẢI</a>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="mega-ddh-item">
                                        <div class="mega-ddh-img"> <a class="box"><img src="<?php get_site_url(); ?>/template/assets/images/ddh (6).png" alt="" /></a></div><a class="mega-ddh-name">DÂY VẢI</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mobile-sub-item">
                    <div class="mobile-sub-item-top tech-item-head"><span class="text">BEST SELLERS</span><a class="mobile-sub-link">SHOP ALL</a></div>
                    <div class="mobile-sub-main tech-body">
                        <div class="mega-bs-flex">
                            <div class="mega-bs-left">
                                <div class="mega-bs-img">
                                    <div class="box"> <img src="<?php get_site_url(); ?>/template/assets/images/bs1.jpg" alt="" />
                                    </div><span class="text">Best sellers</span>
                                </div>
                            </div>
                            <div class="mega-bs-right">
                                <div class="mega-bs-simg">
                                    <div class="box"> <img src="<?php get_site_url(); ?>/template/assets/images/bs2.jpg" alt="" />
                                    </div>
                                </div>
                                <div class="mega-bs-desc"> <span class="text">Tổng hợp các sản phẩm bán chạy
                                        nhất của CURNON!</span><a class="mega-bs-link">SHOP NOW</a></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mobile-sub-item">
                    <div class="mobile-sub-item-top tech-item-head"><span class="text">BEST SELLERS</span><a class="mobile-sub-link">SHOP ALL</a></div>
                    <div class="mobile-sub-main tech-body">
                        <div class="swiper megaNewSwiper">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <div class="pro-item">
                                        <div class="pro-box">
                                            <div class="pro-img">
                                                <div class="box box-pc"><img src="<?php get_site_url(); ?>/template/assets/images/pro1.jpg " alt="" /></div>
                                                <div class="box box-pc"><img src="<?php get_site_url(); ?>/template/assets/images/pro2.jpg " alt="" /></div>
                                                <div class="swiper proSwiper">
                                                    <div class="swiper-wrapper">
                                                        <div class="swiper-slide">
                                                            <div class="box"> <img src="<?php get_site_url(); ?>/template/assets/images/pro1.jpg " alt="" /></div>
                                                        </div>
                                                        <div class="swiper-slide">
                                                            <div class="box"> <img src="<?php get_site_url(); ?>/template/assets/images/pro1.jpg " alt="" /></div>
                                                        </div>
                                                    </div>
                                                    <div class="swiper-pagination"></div>
                                                </div><a class="pro-add pro-add-pc popup-open" data-popup="popup-attri"><span class="text">Thêm vào giỏ
                                                        hàng</span><span class="icon"> <img src="<?php get_site_url(); ?>/template/assets/images/pro-cart.png" alt="" /></span></a><span class="pro-tag">
                                                    -11%</span>
                                            </div>
                                            <div class="pro-desc"> <a class="pro-name" href="">GALLANT</a>
                                                <p class="pro-price">2.069.000 ₫
                                                </p>
                                                <div class="pro-desc-op">
                                                    <div class="recheck">
                                                        <div class="recheck-block">
                                                            <div class="recheck-item">
                                                                <input class="recheck-input" type="radio" name="" hidden="" />
                                                                <div class="recheck-checkbox"><img src="<?php get_site_url(); ?>/template/assets/images/img1.png" alt="" />
                                                                </div>
                                                            </div>
                                                            <div class="recheck-item">
                                                                <input class="recheck-input" type="radio" name="" hidden="" />
                                                                <div class="recheck-checkbox"><img src="<?php get_site_url(); ?>/template/assets/images/img2.png" alt="" />
                                                                </div>
                                                            </div>
                                                            <div class="recheck-item">
                                                                <input class="recheck-input" type="radio" name="" hidden="" />
                                                                <div class="recheck-checkbox"><img src="<?php get_site_url(); ?>/template/assets/images/img3.png" alt="" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div><a class="pro-add pro-add-mb popup-open" data-popup="popup-attri"><span class="text">Thêm</span><span class="icon"> <img src="<?php get_site_url(); ?>/template/assets/images/pro-cart.png" alt="" /></span></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="pro-item">
                                        <div class="pro-box">
                                            <div class="pro-img">
                                                <div class="box box-pc"><img src="<?php get_site_url(); ?>/template/assets/images/pro1.jpg " alt="" /></div>
                                                <div class="box box-pc"><img src="<?php get_site_url(); ?>/template/assets/images/pro2.jpg " alt="" /></div>
                                                <div class="swiper proSwiper">
                                                    <div class="swiper-wrapper">
                                                        <div class="swiper-slide">
                                                            <div class="box"> <img src="<?php get_site_url(); ?>/template/assets/images/pro1.jpg " alt="" /></div>
                                                        </div>
                                                        <div class="swiper-slide">
                                                            <div class="box"> <img src="<?php get_site_url(); ?>/template/assets/images/pro1.jpg " alt="" /></div>
                                                        </div>
                                                    </div>
                                                    <div class="swiper-pagination"></div>
                                                </div><a class="pro-add pro-add-pc popup-open" data-popup="popup-attri"><span class="text">Thêm vào giỏ
                                                        hàng</span><span class="icon"> <img src="<?php get_site_url(); ?>/template/assets/images/pro-cart.png" alt="" /></span></a><span class="pro-tag">
                                                    -11%</span>
                                            </div>
                                            <div class="pro-desc"> <a class="pro-name" href="">GALLANT</a>
                                                <p class="pro-price">2.069.000 ₫
                                                </p>
                                                <div class="pro-desc-op">
                                                    <div class="recheck">
                                                        <div class="recheck-block">
                                                            <div class="recheck-item">
                                                                <input class="recheck-input" type="radio" name="" hidden="" />
                                                                <div class="recheck-checkbox"><img src="<?php get_site_url(); ?>/template/assets/images/img1.png" alt="" />
                                                                </div>
                                                            </div>
                                                            <div class="recheck-item">
                                                                <input class="recheck-input" type="radio" name="" hidden="" />
                                                                <div class="recheck-checkbox"><img src="<?php get_site_url(); ?>/template/assets/images/img2.png" alt="" />
                                                                </div>
                                                            </div>
                                                            <div class="recheck-item">
                                                                <input class="recheck-input" type="radio" name="" hidden="" />
                                                                <div class="recheck-checkbox"><img src="<?php get_site_url(); ?>/template/assets/images/img3.png" alt="" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div><a class="pro-add pro-add-mb popup-open" data-popup="popup-attri"><span class="text">Thêm</span><span class="icon"> <img src="<?php get_site_url(); ?>/template/assets/images/pro-cart.png" alt="" /></span></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="pro-item">
                                        <div class="pro-box">
                                            <div class="pro-img">
                                                <div class="box box-pc"><img src="<?php get_site_url(); ?>/template/assets/images/pro1.jpg " alt="" /></div>
                                                <div class="box box-pc"><img src="<?php get_site_url(); ?>/template/assets/images/pro2.jpg " alt="" /></div>
                                                <div class="swiper proSwiper">
                                                    <div class="swiper-wrapper">
                                                        <div class="swiper-slide">
                                                            <div class="box"> <img src="<?php get_site_url(); ?>/template/assets/images/pro1.jpg " alt="" /></div>
                                                        </div>
                                                        <div class="swiper-slide">
                                                            <div class="box"> <img src="<?php get_site_url(); ?>/template/assets/images/pro1.jpg " alt="" /></div>
                                                        </div>
                                                    </div>
                                                    <div class="swiper-pagination"></div>
                                                </div><a class="pro-add pro-add-pc popup-open" data-popup="popup-attri"><span class="text">Thêm vào giỏ
                                                        hàng</span><span class="icon"> <img src="<?php get_site_url(); ?>/template/assets/images/pro-cart.png" alt="" /></span></a><span class="pro-tag">
                                                    -11%</span>
                                            </div>
                                            <div class="pro-desc"> <a class="pro-name" href="">GALLANT</a>
                                                <p class="pro-price">2.069.000 ₫
                                                </p>
                                                <div class="pro-desc-op">
                                                    <div class="recheck">
                                                        <div class="recheck-block">
                                                            <div class="recheck-item">
                                                                <input class="recheck-input" type="radio" name="" hidden="" />
                                                                <div class="recheck-checkbox"><img src="<?php get_site_url(); ?>/template/assets/images/img1.png" alt="" />
                                                                </div>
                                                            </div>
                                                            <div class="recheck-item">
                                                                <input class="recheck-input" type="radio" name="" hidden="" />
                                                                <div class="recheck-checkbox"><img src="<?php get_site_url(); ?>/template/assets/images/img2.png" alt="" />
                                                                </div>
                                                            </div>
                                                            <div class="recheck-item">
                                                                <input class="recheck-input" type="radio" name="" hidden="" />
                                                                <div class="recheck-checkbox"><img src="<?php get_site_url(); ?>/template/assets/images/img3.png" alt="" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div><a class="pro-add pro-add-mb popup-open" data-popup="popup-attri"><span class="text">Thêm</span><span class="icon"> <img src="<?php get_site_url(); ?>/template/assets/images/pro-cart.png" alt="" /></span></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="pro-item">
                                        <div class="pro-box">
                                            <div class="pro-img">
                                                <div class="box box-pc"><img src="<?php get_site_url(); ?>/template/assets/images/pro1.jpg " alt="" /></div>
                                                <div class="box box-pc"><img src="<?php get_site_url(); ?>/template/assets/images/pro2.jpg " alt="" /></div>
                                                <div class="swiper proSwiper">
                                                    <div class="swiper-wrapper">
                                                        <div class="swiper-slide">
                                                            <div class="box"> <img src="<?php get_site_url(); ?>/template/assets/images/pro1.jpg " alt="" /></div>
                                                        </div>
                                                        <div class="swiper-slide">
                                                            <div class="box"> <img src="<?php get_site_url(); ?>/template/assets/images/pro1.jpg " alt="" /></div>
                                                        </div>
                                                    </div>
                                                    <div class="swiper-pagination"></div>
                                                </div><a class="pro-add pro-add-pc popup-open" data-popup="popup-attri"><span class="text">Thêm vào giỏ
                                                        hàng</span><span class="icon"> <img src="<?php get_site_url(); ?>/template/assets/images/pro-cart.png" alt="" /></span></a><span class="pro-tag">
                                                    -11%</span>
                                            </div>
                                            <div class="pro-desc"> <a class="pro-name" href="">GALLANT</a>
                                                <p class="pro-price">2.069.000 ₫
                                                </p>
                                                <div class="pro-desc-op">
                                                    <div class="recheck">
                                                        <div class="recheck-block">
                                                            <div class="recheck-item">
                                                                <input class="recheck-input" type="radio" name="" hidden="" />
                                                                <div class="recheck-checkbox"><img src="<?php get_site_url(); ?>/template/assets/images/img1.png" alt="" />
                                                                </div>
                                                            </div>
                                                            <div class="recheck-item">
                                                                <input class="recheck-input" type="radio" name="" hidden="" />
                                                                <div class="recheck-checkbox"><img src="<?php get_site_url(); ?>/template/assets/images/img2.png" alt="" />
                                                                </div>
                                                            </div>
                                                            <div class="recheck-item">
                                                                <input class="recheck-input" type="radio" name="" hidden="" />
                                                                <div class="recheck-checkbox"><img src="<?php get_site_url(); ?>/template/assets/images/img3.png" alt="" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div><a class="pro-add pro-add-mb popup-open" data-popup="popup-attri"><span class="text">Thêm</span><span class="icon"> <img src="<?php get_site_url(); ?>/template/assets/images/pro-cart.png" alt="" /></span></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
    <?php
        return ob_get_clean();
    }

    // Nữ giới 
    function MenuMegaContent_3($item)
    {
        ob_start();
        $mona_tax_nu_gioi = get_field('mona_tax_nu_gioi', $item);
        $parent_cat_dong_ho_nu = get_term_by('slug', 'dong-ho-nu', 'product_cat');
        $parent_cat_trang_suc_nu = get_term_by('slug', 'trang-suc-nu', 'product_cat');
        $parent_cat_day_dong_ho_nu = get_term_by('slug', 'day-dong-ho-nu', 'product_cat');
        $parent_cat_best_sellers = get_term_by('slug', 'best-sellers', 'product_cat');
        $link_2_best_sellers = get_field('link_2_best_sellers', MONA_PAGE_HOME);

    ?>

        <div class="mega-menu">
            <div class="container">
                <div class="mega-menu-flex">

                    <?php if ($mona_tax_nu_gioi) : ?>

                        <div class="mega-menu-left">
                            <ul class="menu-list">

                                <?php foreach ($mona_tax_nu_gioi as $key => $item) {
                                    $link_item = get_term_link($item);
                                ?>

                                    <li class="menu-item">
                                        <!-- actived -->
                                        <a class="menu-link" href="<?php echo esc_url($link_item); ?>">
                                            <?php echo $item->name; ?>
                                        </a>
                                    </li>


                                <?php  } ?>

                            </ul>
                            <div class="mega-menu-left-btn">
                                <a class="link" href="<?php echo site_url('dong-ho/dong-ho-nu'); ?>"><?php _e('SHOP ALL PRODUCTS', 'monamedia') ?></a>
                            </div>
                        </div>



                        <div class="mega-menu-right">

                            <!-- đồng hồ nữ  -->
                            <?php if ($parent_cat_dong_ho_nu && is_object($parent_cat_dong_ho_nu)) {
                                $child_cats = get_terms([
                                    'taxonomy'   => 'product_cat',
                                    'parent'     => $parent_cat_dong_ho_nu->term_id,
                                    'hide_empty' => false,
                                ]);
                                if (!empty($child_cats) || isset($child_cats)) {  ?>

                                    <div class="mega-menu-hover showed">
                                        <div class="mega-dh">
                                            <div class="mega-dh-top">
                                                <p class="t16 fw-5">

                                                    <?php if ($parent_cat_dong_ho_nu->count > 0) : ?>
                                                        <span class="c-second">
                                                            <?php echo $parent_cat_dong_ho_nu->count; ?>
                                                        </span>
                                                        <?php _e(' sản phẩm đồng hồ nữ', 'monamedia') ?>
                                                    <?php endif; ?>

                                                </p>
                                                <a class="mega-dh-top-link" href="<?php echo site_url('dong-ho/dong-ho-nu'); ?>"><?php _e('SHOP ALL', 'monamedia') ?></a>
                                            </div>
                                            <div class="mega-dh-list">

                                                <?php foreach ($child_cats as $child_cat) {
                                                    $link_child_cat = get_term_link($child_cat);
                                                    $image_product_cat = get_term_meta($child_cat->term_id, 'thumbnail_id', true); ?>

                                                    <a class="mega-dh-item" href="<?php echo esc_url($link_child_cat); ?>">
                                                        <span class="mega-dh-img">
                                                            <?php echo wp_get_attachment_image($image_product_cat, 'full'); ?>
                                                        </span>
                                                        <span class="mega-dh-name">
                                                            <?php echo $child_cat->name; ?>
                                                        </span>
                                                    </a>

                                                <?php } ?>

                                            </div>
                                        </div>
                                    </div>

                            <?php }
                            } ?>


                            <?php if ($parent_cat_trang_suc_nu && is_object($parent_cat_trang_suc_nu)) {
                                $child_cats = get_terms([
                                    'taxonomy'   => 'product_cat',
                                    'parent'     => $parent_cat_trang_suc_nu->term_id,
                                    'hide_empty' => false,
                                ]);
                                if (!empty($child_cats) || isset($child_cats)) {  ?>
                                    <!-- trang sức nu  -->
                                    <div class="mega-menu-hover">
                                        <div class="mega-ts">
                                            <div class="mega-ts-list">

                                                <?php foreach ($child_cats as $child_cat) {
                                                    $link_child_cat = get_term_link($child_cat);
                                                    $image_child_cat = get_term_meta($child_cat->term_id, 'thumbnail_id', true)
                                                ?>

                                                    <div class="mega-ts-item">
                                                        <div class="mega-ts-img">
                                                            <a class="box" href="<?php echo esc_url($link_child_cat); ?>">
                                                                <?php echo wp_get_attachment_image($image_child_cat, 'full'); ?>
                                                            </a>
                                                        </div>
                                                        <a class="mega-ts-name" href="<?php echo esc_url($link_child_cat); ?>"><?php echo $child_cat->name; ?></a>
                                                    </div>

                                                <?php } ?>


                                            </div>
                                        </div>
                                    </div>

                            <?php }
                            } ?>


                            <?php if ($parent_cat_day_dong_ho_nu && is_object($parent_cat_day_dong_ho_nu)) {
                                $child_cats = get_terms([
                                    'taxonomy'   => 'product_cat',
                                    'parent'     => $parent_cat_day_dong_ho_nu->term_id,
                                    'hide_empty' => false,
                                ]);
                                if (!empty($child_cats) || isset($child_cats)) {  ?>
                                    <!-- dây đồng hồ nữ  -->
                                    <div class="mega-menu-hover">
                                        <div class="mega-ddh">
                                            <div class="mega-dh-top">
                                                <p class="t16 fw-5">
                                                    <?php if ($parent_cat_day_dong_ho_nu->count > 0) : ?>
                                                        <span class="c-second">
                                                            <?php echo $parent_cat_day_dong_ho_nu->count; ?>
                                                        </span>
                                                        <?php _e(' sản phẩm đồng hồ nữ', 'monamedia') ?>
                                                    <?php endif; ?>
                                                </p>

                                                <a class="mega-dh-top-link" href="<?php echo esc_url($link_2_best_sellers); ?>"><?php _e('SHOP ALL', 'monamedia') ?></a>
                                            </div>
                                            <div class="swiper megaddhSwiper">
                                                <div class="swiper-wrapper">

                                                    <?php foreach ($child_cats as $child_cat) {
                                                        $link_child_cat = get_term_link($child_cat);
                                                        $image_child_cat = get_term_meta($child_cat->term_id, 'thumbnail_id', true)
                                                    ?>

                                                        <div class="swiper-slide">
                                                            <div class="mega-ddh-item">
                                                                <div class="mega-ddh-img">
                                                                    <a class="box" href="<?php echo esc_url($link_child_cat); ?>">
                                                                        <?php echo wp_get_attachment_image($image_child_cat, 'full'); ?>
                                                                    </a>
                                                                </div>
                                                                <a class="mega-ddh-name" href="<?php echo esc_url($link_child_cat); ?>"><?php echo $child_cat->name; ?></a>
                                                            </div>
                                                        </div>

                                                    <?php } ?>

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                            <?php }
                            } ?>

                            <?php if ($parent_cat_best_sellers && is_object($parent_cat_best_sellers)) {
                                $mona_sc2_group_bestsellers_nu = get_field('mona_sc2_group_bestsellers_nu', MONA_PAGE_HOME);
                                $mona_hinh_anh_1_best_sellers = $mona_sc2_group_bestsellers_nu['mona_hinh_anh_1_best_sellers'];
                                $tieu_de_1_best_sellers = $mona_sc2_group_bestsellers_nu['tieu_de_1_best_sellers'];
                                $link_best_sellers = $mona_sc2_group_bestsellers_nu['link_best_sellers'];
                                $mona_hinh_anh_2_best_sellers = $mona_sc2_group_bestsellers_nu['mona_hinh_anh_2_best_sellers'];
                                $tieu_de_2_best_sellers = $mona_sc2_group_bestsellers_nu['tieu_de_2_best_sellers'];
                                $link_2_best_sellers = $mona_sc2_group_bestsellers_nu['link_2_best_sellers'];
                            ?>
                                <!-- best sellers   -->
                                <div class="mega-menu-hover">
                                    <div class="mega-bs">
                                        <div class="mega-bs-flex">
                                            <div class="mega-bs-left">
                                                <div class="mega-bs-img">
                                                    <div class="box">
                                                    <a href="<?php echo $link_best_sellers; ?>"><?php echo wp_get_attachment_image($mona_hinh_anh_1_best_sellers, 'full'); ?></a>
                                                    </div>
                                                    <span class="text">
                                                        <?php echo $tieu_de_1_best_sellers; ?>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="mega-bs-right">
                                                <div class="mega-bs-simg">
                                                    <div class="box">
                                                        <?php echo wp_get_attachment_image($mona_hinh_anh_2_best_sellers, 'full'); ?>
                                                    </div>
                                                </div>
                                                <div class="mega-bs-desc">
                                                    <span class="text"><?php echo $tieu_de_2_best_sellers; ?></span><a class="mega-bs-link" href="<?php echo $link_2_best_sellers; ?>"><?php _e('SHOP NOW', 'monamedia') ?></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            <?php  } ?>

                            <?php
                            $count = 4;

                            $args = array(
                                'post_type'      => 'product',
                                'post_status'    => 'publish',
                                'order' => 'DESC',
                                'posts_per_page' => $count,
                                'tax_query'     => array(
                                    array(
                                        'taxonomy' => 'product_visibility',
                                        'field'    => 'name',
                                        'terms'    => 'featured',
                                        'operator' => 'IN',
                                    ),
                                ),
                            );

                            $Query_Feature = new WP_Query($args);

                            if ($Query_Feature->have_posts()) {
                            ?>

                                <div class="mega-menu-hover">
                                    <div class="mega-new">
                                        <div class="mega-dh-top">
                                            <p class="t16 fw-5">
                                                <span class="c-second"><?php _e('4 ', 'monamedia'); ?>
                                                </span><?php _e('sản phẩm mới nhất', 'monamedia'); ?>
                                            </p>
                                            <a class="mega-dh-top-link" href="<?php echo esc_url($link_2_best_sellers); ?>"><?php _e('SHOP ALL', 'monamedia'); ?></a>
                                        </div>

                                        <div class="swiper megaNewSwiper">
                                            <div class="swiper-wrapper">

                                                <?php
                                                while ($Query_Feature->have_posts()) :
                                                    $Query_Feature->the_post();
                                                ?>

                                                    <div class="swiper-slide">

                                                        <?php get_template_part('partials/product/item');  ?>

                                                    </div>

                                                <?php
                                                endwhile;
                                                wp_reset_postdata();
                                                ?>

                                            </div>
                                        </div>

                                    </div>
                                </div>

                            <?php } else { ?>

                                <div class="mega-menu-hover">
                                    <div class="mega-new">
                                        <div class="container">
                                            <div class="empty-product">
                                                <a class="image-empty-product" href="<?php echo home_url(); ?>">
                                                    <img src="<?php get_site_url(); ?>/template/assets/images/empty-cart-curnon.png" alt="this is a image of empty product">
                                                </a>
                                                <p class="text">
                                                    <?php _e('Hiện tại, sản phẩm bạn tìm kiếm hiện đang cập nhật. Vui lòng quay lại sau hoặc liên hệ với chúng tôi.', 'monamedia'); ?>
                                                </p>
                                                <?php if (is_cart()) : ?>
                                                    <a class="btn btn-pri" href="<?php echo home_url(); ?>">
                                                        <span class="text"> <?php _e('TIẾP TỤC MUA SẮM', 'monamedia') ?></span>
                                                    </a>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            <?php } ?>

                        </div>

                    <?php endif; ?>

                </div>
            </div>
        </div>

    <?php
        return ob_get_clean();
    }

    // quà tặng 
    function MenuMegaContent_4($item)
    {
        ob_start();
        $mona_tax_qua_tang = get_field('mona_tax_qua_tang', $item);

    ?>

        <?php if ($mona_tax_qua_tang) : ?>

            <div class="mega-menu mega-qt">
                <div class="container">
                    <div class="mega-qt-list">

                        <?php foreach ($mona_tax_qua_tang as $key => $item) {
                            $link_item = get_term_link($item);
                            $image_product_cat = get_term_meta($item->term_id, 'thumbnail_id', true);
                        ?>

                            <div class="mega-qt-item">
                                <div class="mega-qt-box">
                                    <a class="mega-qt-img" href="<?php echo esc_url($link_item); ?>">
                                        <?php echo wp_get_attachment_image($image_product_cat, 'full'); ?>
                                    </a>
                                    <a class="mega-qt-name fw-5"><?php echo $item->name; ?></a>
                                </div>
                            </div>

                        <?php } ?>

                    </div>
                </div>
            </div>

        <?php endif; ?>

<?php
        return ob_get_clean();
    }
}
