<?php

/**
 * Section name: Home Banners
 * Description: 
 * Author: Monamedia
 * Order: 5
 */
$mona_sc_6_group = get_field('mona_sc_6_group');
if (isset($mona_sc_6_group['rp']) || !empty($mona_sc_6_group['rp'])) :
?>
    <div class="slogan">
        <div class="slogan-wrap">
            <div class="container">
                <div class="slogan-inner">
                    <div class="slogan-list">
                        <?php foreach ($mona_sc_6_group['rp'] as $key => $item) : ?>
                            <div class="slogan-item" data-aos="zoom-in">
                                <span class="icon">
                                    <?php echo wp_get_attachment_image($item['icon'], 'full'); ?>
                                </span>
                                <h2 class="title f-title fw-6"><?php echo $item['title']; ?></h2>
                                <p class="desc fw-5"><?php echo $item['des']; ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>