<?php

/**
 * Section name: Home Banners
 * Description: 
 * Author: Monamedia
 * Order: 9
 */
$mona_sc_8_mona = get_field('mona_sc_8_mona');
if (isset($mona_sc_8_mona['rp']) || !empty($mona_sc_8_mona['rp'])) :
?>
    <div class="hab">
        <div class="hab-wrap">
            <div class="hab-flex">
                <div class="hab-left">
                    <div class="hab-slide">
                        <div class="swiper habSwiper">
                            <div class="swiper-wrapper">
                                <?php foreach ($mona_sc_8_mona['rp'] as $key => $item) : ?>
                                    <div class="swiper-slide">
                                        <div class="hab-item">
                                            <a class="hab-img" href="<?php echo $item['link'] ?>">
                                                <?php echo wp_get_attachment_image($item['image'], 'full') ?>
                                            </a>
                                            <p class="hab-text">
                                                <?php echo $item['address'] ?>
                                            </p>
                                            <a class="hab-link" href="<?php echo $item['link'] ?>">
                                                <span class="icon">
                                                    <i class="fa-light fa-arrow-right-long"></i>
                                                </span>
                                            </a>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="hab-right">
                    <div class="hab-ctn">
                        <h2 class="f-title title fw-7"><?php echo $mona_sc_8_mona['title'] ?></h2>
                        <p class="text fw-5 t16"><?php echo $mona_sc_8_mona['des'] ?></p>
                        <a class="btn btn-pri" href="<?php echo $mona_sc_8_mona['link'] ?>"><span class="text"><?php _e('READ MORE', 'monamedia'); ?></span></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>