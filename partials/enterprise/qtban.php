<?php

/**
 * Section name: Home Banners
 * Description: 
 * Author: Monamedia
 * Order: 0
 */
$mona_sc_1_group = get_field('mona_sc_1_group');
?>
<div class="qtban">
    <div class="qtban-wrap">
        <div class="qtban-bg">
            <?php echo wp_get_attachment_image($mona_sc_1_group['image'], 'full') ?>
        </div>
        <div class="container">
            <div class="qtban-inner">
                <div class="qtban-ctn" data-aos="zoom-in">
                    <h1 class="title c-white fw-7 f-title t-center"><?php echo $mona_sc_1_group['title']; ?></h1>
                    <p class="desc fw-5 c-white t-center"><?php echo $mona_sc_1_group['des']; ?></p>
                    <div class="qtban-btn">
                        <button class="btn-second trans popup-open" data-popup="popup-down"><span class="text"><?php _e('TẢI TÀI LIỆU', 'monamedia') ?></span></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>