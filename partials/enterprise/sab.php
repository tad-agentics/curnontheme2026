<?php

/**
 * Section name: Home Banners
 * Description: 
 * Author: Monamedia
 * Order: 5
 */
$mona_sc_6_group = get_field('mona_sc_6_group');
?>
<div class="sab">
    <div class="sab-wrap">
        <div class="sab-flex">
            <div class="sab-col" data-aos="zoom-in">
                <div class="sab-box">
                    <span class="icon">
                        <?php echo wp_get_attachment_image($mona_sc_6_group['icon'], 'full') ?>
                    </span>
                    <h2 class="title f-title fw-7 t-center"><?php echo $mona_sc_6_group['title']; ?></h2>
                </div>
            </div>
            <div class="sab-col" data-aos="zoom-in">
                <div class="sab-img">
                    <?php echo wp_get_attachment_image($mona_sc_6_group['image_1'], 'full') ?>
                </div>
            </div>
            <div class="sab-col" data-aos="zoom-in">
                <div class="sab-img">
                    <?php echo wp_get_attachment_image($mona_sc_6_group['image_2'], 'full') ?>
                </div>
            </div>
            <div class="sab-col" data-aos="zoom-in">
                <div class="sab-img">
                    <?php echo wp_get_attachment_image($mona_sc_6_group['image_3'], 'full') ?>
                </div>
            </div>
            <div class="sab-col" data-aos="zoom-in">
                <div class="sab-desc">
                    <p class="text fw-5 c-white"><?php echo $mona_sc_6_group['des']; ?></p>
                </div>
            </div>
        </div>
    </div>
</div>