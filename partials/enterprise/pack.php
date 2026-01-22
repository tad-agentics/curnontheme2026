<?php

/**
 * Section name: Home Banners
 * Description: 
 * Author: Monamedia
 * Order: 2
 */
$mona_sc_3_group = get_field('mona_sc_3_group');
?>
<div class="pack">
    <div class="pack-wrap">
        <div class="pack-top">
            <div class="container">
                <div class="pack-top-inner" data-aos="fade-up">
                    <h2 class="fw-7 f-title title"><?php echo $mona_sc_3_group['title']; ?></h2>
                    <p class="text fw-5 t-center"><?php echo $mona_sc_3_group['des']; ?></p>
                    <a class="btn btn-pri" href="<?php echo esc_url($mona_sc_3_group['link']) ?>" download="">
                        <span class="text"><?php _e('TẢI TÀI LIỆU', 'monamedia') ?></span></a>
                </div>
            </div>
        </div>
        <?php if (isset($mona_sc_3_group['rp']) || !empty($mona_sc_3_group['rp'])) : ?>
            <div class="pack-inner">
                <div class="pack-list">
                    <?php foreach ($mona_sc_3_group['rp'] as $key => $item) : ?>
                        <div class="pack-flex" data-aos="fade-up">
                            <div class="pack-left">
                                <div class="pack-img">
                                    <div class="box">
                                        <?php echo wp_get_attachment_image($item['image_1'], 'monamedia') ?>
                                    </div>
                                </div>
                                <div class="pack-img">
                                    <div class="box">
                                        <?php echo wp_get_attachment_image($item['image_2'], 'monamedia') ?>
                                    </div>
                                </div>
                            </div>
                            <div class="pack-right">
                                <div class="pack-desc">
                                    <div class="pack-desc-flex">
                                        <div class="pack-desc-left"> <span class="text f-title"><?php echo $item['pack']; ?></span></div>
                                        <div class="pack-desc-right">
                                            <h2 class="f-title fw-7 title"><?php echo $item['title']; ?></h2>
                                            <p class="desc fw-5"><?php echo $item['des']; ?></p>
                                            <a class="link fw-5" href="<?php echo esc_url($item['link']); ?>"><?php _e('LIÊN HỆ TƯ VẤN', 'monamedia') ?></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>