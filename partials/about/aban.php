<?php

/**
 * Section name: Home Banners
 * Description: 
 * Author: Monamedia
 * Order: 0
 */

$mona_sc_1_group = get_field('mona_sc_1_group');
?>
<div class="aban">
    <div class="aban-wrap">
        <div class="aban-bg">
            <?php echo wp_get_attachment_image($mona_sc_1_group['banner'], 'full') ?>
        </div>
        <div class="container">
            <div class="aban-inner">
                <div class="aban-ctn" data-aos="zoom-in"><span class="text c-white fw-6"><?php echo $mona_sc_1_group['title_1']; ?></span>
                    <h1 class="title c-white fw-7 f-title"><?php echo $mona_sc_1_group['title_2']; ?></h1>
                    <p class="desc fw-5 c-white t-center"><?php echo $mona_sc_1_group['des']; ?></p>
                </div>
            </div>
        </div>
    </div>
</div>