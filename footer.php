<footer class="footer">
    <div class="footer-wrap">
        <div class="container">
            <div class="footer-inner">
                <div class="footer-flex">
                    <div class="footer-col">

                        <?php $dia_chi_items_1 = mona_get_option('dia_chi_items_1');
                        if (is_array($dia_chi_items_1)) : ?>

                        <div class="footer-info">
                            <div class="footer-info-top">
                                <span class="icon">

                                    <?php $mona_footer_icon = mona_get_option('mona_footer_icon');
                                        if ($mona_footer_icon) { ?>
                                    <img src="<?php echo esc_url($mona_footer_icon); ?>">
                                    <?php } ?>

                                </span>
                                <span class="text">

                                    <?php
                                        $footer_title_1 = mona_get_option('footer_title_1');
                                        if (isset($footer_title_1) || !empty($footer_title_1)) {
                                            echo esc_html($footer_title_1);
                                        }
                                        ?>

                                </span>
                            </div>

                            <?php foreach ($dia_chi_items_1 as $item) { ?>

                            <a class="footer-info-link"
                                href="<?php echo esc_url($item['link']); ?>"><?php echo esc_html($item['content']); ?></a>
                            <?php } ?>

                        </div>

                        <?php endif; ?>

                        <?php $dia_chi_items_2 = mona_get_option('dia_chi_items_2');
                        if (is_array($dia_chi_items_2)) : ?>

                        <div class="footer-info">
                            <div class="footer-info-top">
                                <span class="icon">
                                    <?php $mona_footer_icon = mona_get_option('mona_footer_icon');
                                        if ($mona_footer_icon) { ?>
                                    <img src="<?php echo esc_url($mona_footer_icon); ?>">
                                    <?php } ?>
                                </span>
                                <span class="text">
                                    <?php
                                        $footer_title_2 = mona_get_option('footer_title_2');
                                        if (isset($footer_title_2) || !empty($footer_title_2)) {
                                            echo esc_html($footer_title_2);
                                        }
                                        ?>
                                </span>
                            </div>

                            <?php foreach ($dia_chi_items_2 as $item) { ?>

                            <a class="footer-info-link"
                                href="<?php echo esc_url($item['link']); ?>"><?php echo esc_html($item['content']); ?></a>

                            <?php } ?>

                        </div>

                        <?php endif; ?>

                    </div>
                    <div class="footer-col">
                        <div class="footer-title">
                            <?php
                            $footer_title_3 = mona_get_option('footer_title_3');
                            if (isset($footer_title_3) || !empty($footer_title_3)) {
                                echo esc_html($footer_title_3);
                            }
                            ?>
                        </div>

                        <!-- footer menu -->
                        <?php
                        wp_nav_menu(array(
                            'container' => false,
                            'container_class' => '',
                            'menu_class' => 'menu-list',
                            'theme_location' => 'footer-menu',
                            'walker' => new Mona_Walker_Nav_Menu,
                        ));
                        ?>

                    </div>
                    <div class="footer-col">
                        <div class="footer-title">
                            <?php
                            $footer_title_4 = mona_get_option('footer_title_4');
                            if (isset($footer_title_4) || !empty($footer_title_4)) {
                                echo esc_html($footer_title_4);
                            }
                            ?>
                        </div>

                        <!-- footer menu 2 -->
                        <?php
                        wp_nav_menu(array(
                            'container' => false,
                            'container_class' => '',
                            'menu_class' => 'menu-list',
                            'theme_location' => 'footer-menu-2',
                            'walker' => new Mona_Walker_Nav_Menu,
                        ));
                        ?>

                    </div>
                    <div class="footer-col">
                        <div class="footer-title">
                            <?php
                            $footer_title_5 = mona_get_option('footer_title_5');
                            if (isset($footer_title_5) || !empty($footer_title_5)) {
                                echo esc_html($footer_title_5);
                            }
                            ?>
                        </div>

                        <!-- footer menu 3 -->
                        <?php
                        wp_nav_menu(array(
                            'container' => false,
                            'container_class' => '',
                            'menu_class' => 'menu-list',
                            'theme_location' => 'footer-menu-3',
                            'walker' => new Mona_Walker_Nav_Menu,
                        ));
                        ?>

                    </div>
                    <div class="footer-col">
                        <div class="footer-title">
                            <?php
                            $footer_title_6 = mona_get_option('footer_title_6');
                            if (isset($footer_title_6) || !empty($footer_title_6)) {
                                echo esc_html($footer_title_6);
                            }
                            ?>
                        </div>

                        <!-- footer menu 4 -->
                        <?php
                        wp_nav_menu(array(
                            'container' => false,
                            'container_class' => '',
                            'menu_class' => 'menu-list',
                            'theme_location' => 'footer-menu-4',
                            'walker' => new Mona_Walker_Nav_Menu,
                        ));
                        ?>

                        <?php
                        $social_items_footer = mona_get_option('social_items_footer');
                        if (is_array($social_items_footer)) {
                        ?>
                        <div class="footer-contact">
                            <div class="footer-social">

                                <?php foreach ($social_items_footer as $item) { ?>

                                <a class="footer-social-link" href="<?php echo esc_url($item['link']); ?>">
                                    <?php echo '<img src="' . esc_url($item['icon']) . '">'; ?>
                                </a>

                                <?php } ?>

                            </div>
                        </div>

                        <?php } ?>

                    </div>
                    <div class="footer-col">

                        <?php
                        $footer_shortcode = mona_get_option('footer_shortcode');
                        if (!empty($footer_shortcode) || isset($footer_shortcode)) {
                            echo do_shortcode($footer_shortcode);
                        }
                        ?>

                    </div>
                </div>
                <div class="footer-bot">
                    <div class="footer-bot-flex">
                        <div class="footer-bot-left">
                            <p class="t12">
                                <?php
                                $footer_title_7 = mona_get_option('footer_title_7');
                                if (isset($footer_title_7) || !empty($footer_title_7)) {
                                    echo esc_html($footer_title_7);
                                }
                                ?>
                            </p>
                            <p class="t10">
                                <?php
                                $footer_title_8 = mona_get_option('footer_title_8');
                                if (isset($footer_title_8) || !empty($footer_title_8)) {
                                    echo esc_html($footer_title_8);
                                }
                                ?>
                            </p>
                        </div>
                        <div class="footer-bot-right">
                            <div class="footer-ct">
                                <?php $mona_footer_image = mona_get_option('mona_footer_image');
                                if ($mona_footer_image) { ?>
                                <img src="<?php echo esc_url($mona_footer_image); ?>">
                                <?php } ?>
                            </div>

                            <?php
                            $thanh_toan_items = mona_get_option('thanh_toan_items');
                            if (is_array($thanh_toan_items)) {
                            ?>

                            <div class="footer-mt">

                                <?php foreach ($thanh_toan_items as $item) { ?>

                                <div class="footer-mt-item">
                                    <?php
                                            echo '<img src="' . esc_url($item['image']) . '">';
                                            ?>
                                </div>

                                <?php } ?>

                            </div>

                            <?php } ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<div class="fsocial"></div>
<div class="back-to-top backToTop">
    <i class="fa-light fa-arrow-up"></i>
</div>
<!-- footer -->
<?php wp_footer(); ?>
</body>

</html>