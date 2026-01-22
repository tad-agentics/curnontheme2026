<?php

/**
 * Section name: Home Banners
 * Description: 
 * Author: Monamedia
 * Order: 1
 */
$mona_sc_2_group = get_field('mona_sc_2_group');
?>
<div class="about">
    <div class="about-wrap">
        <div class="about-inner">
            <div class="about-flex">
                <div class="about-left" data-aos="zoom-in">
                    <h2 class="title f-title fw-7"><?php echo $mona_sc_2_group['title']; ?></h2>
                    <p class="desc fw-5"><?php echo $mona_sc_2_group['des']; ?></p>
                    <a class="link" href="<?php echo esc_url($mona_sc_2_group['link']); ?>"><?php _e('SEE MORE', 'monamedia') ?></a>
                </div>
                <?php if (isset($mona_sc_2_group['rp']) || !empty($mona_sc_2_group['rp'])) : ?>
                    <div class="about-right">
                        <div class="about-list">
                            <?php foreach ($mona_sc_2_group['rp'] as $key => $item) : ?>
                                <div class="about-item" data-aos="zoom-in">
                                    <div class="about-img">
                                        <div class="box">
                                            <?php echo wp_get_attachment_image($item['image'], 'monamedia') ?>
                                        </div>
                                        <div class="about-ctn">
                                            <p class="c-white fw-7 title f-title"><?php echo $item['title']; ?></p>
                                            <p class="desc fw-6"><?php echo $item['des']; ?></p>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>