<?php

/**
 * Section name: Home Banners
 * Description: 
 * Author: Monamedia
 * Order: 2
 */
$mona_sc_3_group = get_field('mona_sc_3_group');
if (isset($mona_sc_3_group['rp']) || !empty($mona_sc_3_group['rp'])) :
?>
    <div class="apart" data-aos="zoom-in">
        <div class="apart-wrap">
            <div class="apart-inner">
                <div class="apart-slide">
                    <div class="swiper apartSwiper">
                        <div class="swiper-wrapper">
                            <?php foreach ($mona_sc_3_group['rp'] as $key => $item) : ?>
                                <div class="swiper-slide">
                                    <div class="apart-text f-title"><?php echo $item['text']; ?></div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>