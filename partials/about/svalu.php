<?php

/**
 * Section name: Home Banners
 * Description: 
 * Author: Monamedia
 * Order: 3
 */
$mona_sc_4_group = get_field('mona_sc_4_group');
?>
<div class="svalu">
    <div class="svalu-wrap">
        <div class="container">
            <div class="svalu-flex">
                <div class="svalu-left" data-aos="zoom-in">
                    <h2 class="title f-title fw-7 t-center"><?php echo $mona_sc_4_group['title']; ?></h2>
                    <div class="desc fw-5 t20 t-center mona-content"><?php echo $mona_sc_4_group['des']; ?></div>
                    <p class="posi fw-6 t16 t-center"><?php echo $mona_sc_4_group['ceo']; ?></p>
                </div>
                <div class="svalu-right" data-aos="zoom-in">
                    <div class="svalu-img">
                        <div class="box">
                            <?php echo wp_get_attachment_image($mona_sc_4_group['image'], 'full') ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>