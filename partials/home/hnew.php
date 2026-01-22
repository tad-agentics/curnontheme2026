<?php

/**
 * Section name: Home Banners
 * Description: 
 * Author: Monamedia
 * Order: 6
 */
$mona_sc_6_group = get_field('mona_sc_6_group');
?>
<div class="hnew">
    <div class="hnew-wrap">
        <div class="hnew-list" data-aos="zoom-in">
            <div class="hnew-col">
                <div class="hnew-title">
                    <h1 class="title f-title fw-7"><?php echo $mona_sc_6_group['title'] ?></h1>
                    <p class="text fw-5"><?php echo $mona_sc_6_group['des'] ?></p>
                </div>
            </div>
            <?php if (isset($mona_sc_6_group['image']) || !empty($mona_sc_6_group['image'])) : ?>
                <?php foreach ($mona_sc_6_group['image'] as $key => $item) : ?>
                    <div class="hnew-col">
                        <div class="hnew-img">
                            <?php echo wp_get_attachment_image($item, 'full') ?>
                        </div>
                    </div>
                <?php endforeach; ?>
                <div class="hnew-col">
                    <div class="hnew-link">
                        <a class="link t16" href="<?php echo $mona_sc_6_group['link'] ?>">
                            <?php _e('SHOW ALL COLLECTION', 'monamedia') ?>
                        </a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>