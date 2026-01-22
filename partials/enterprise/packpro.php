<?php

/**
 * Section name: Home Banners
 * Description: 
 * Author: Monamedia
 * Order: 3
 */
$mona_sc_4_group = get_field('mona_sc_4_group');
?>
<div class="packpro">
    <div class="packpro-wrap">
        <div class="packpro-top">
            <div class="container">
                <div class="packpro-top-flex">
                    <div class="packpro-top-left" data-aos="fade-right">
                        <h2 class="title f-title fw-7"><?php echo $mona_sc_4_group['title']; ?></h2>
                        <p class="desc fw-5 t16"><?php echo $mona_sc_4_group['des']; ?></p>
                    </div>
                    <div class="packpro-top-right" data-aos="fade-left">
                        <a href="<?php echo esc_url($mona_sc_4_group['link']) ?>" download="" class="btn btn-pri">
                            <span class="text"><?php _e('TẢI TÀI LIỆU', 'monamedia') ?></span>
                        </a>
                        <div class="packpro-btn">
                            <div class="swiper-button-next packpro-btn-next"><i class="fa-solid fa-arrow-right"></i>
                            </div>
                            <div class="swiper-button-prev packpro-btn-prev"><i class="fa-solid fa-arrow-left"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php if (isset($mona_sc_4_group['rp']) || !empty($mona_sc_4_group['rp'])) : ?>
            <div class="packpro-inner" data-aos="fade-up">
                <div class="packpro-slide">
                    <div class="swiper packproSwiper">
                        <div class="swiper-wrapper">
                            <?php foreach ($mona_sc_4_group['rp'] as $key => $item) : ?>
                                <div class="swiper-slide">
                                    <div class="packpro-item">
                                        <div class="packpro-img">
                                            <a class="box" href="<?php echo esc_url($item['link']); ?>">
                                                <?php echo wp_get_attachment_image($item['image'], 'monamedia') ?>
                                            </a>
                                        </div>
                                        <div class="packpro-desc"><a class="name" href="<?php echo esc_url($item['link']); ?>"><?php echo $item['title']; ?></a><a class="desc" href="<?php echo esc_url($item['link']); ?>"><?php echo $item['des']; ?></a>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>