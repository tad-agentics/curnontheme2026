<?php

/**
 * Section name: Home Banners
 * Description: 
 * Author: Monamedia
 * Order: 4
 */
$mona_sc_5_group = get_field('mona_sc_5_group');
?>
<?php if (!empty($mona_sc_5_group['gallery']) && is_array($mona_sc_5_group['gallery'])) : ?>
    <div class="sgaller">
        <div class="sgaller-wrapper">
            <h2 class="title f-title t-center fw-7" data-aos="fade-up"><?php echo $mona_sc_5_group['title']; ?></h2>
            <div class="sgaller-slide" data-aos="fade-up">
                <div class="swiper sgallerSwiper">
                    <div class="swiper-wrapper">
                        <?php foreach ($mona_sc_5_group['gallery'] as $key => $item) : ?>
                            <div class="swiper-slide">
                                <div class="sgaller-img">
                                    <?php echo wp_get_attachment_image($item, 'monamedia') ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
