<?php

/**
 * Template name: Enterprise Page
 * @author : Hy Hý
 */
get_header();
while (have_posts()) :
    the_post();
?>
    <main class="main page-template">
        <?php Elements::Group('enterprise')->Html(); ?>

        <div class="popup popup-down" data-popup-id="popup-down">
            <div class="popup-overlay"></div>
            <div class="popup-main">
                <div class="popup-over">
                    <p class="fw-6 f-title title t-center"><?php _e('TẢI CLIENT PACKAGE', 'monamedia') ?></p>
                    <div class="popup-down-form">
                        <!-- form   -->
                        <?php
                        $mona_shortcode_popup_doanhnghiep = get_field('mona_shortcode_popup_doanhnghiep');
                        echo do_shortcode($mona_shortcode_popup_doanhnghiep); ?>
                    </div>
                    <div class="popup-close"><i class="fas fa-times icon"></i></div>
                </div>
            </div>
        </div>

    </main>
<?php
endwhile;
get_footer();
