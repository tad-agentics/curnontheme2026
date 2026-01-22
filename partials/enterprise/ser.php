<?php

/**
 * Section name: Home Banners
 * Description: 
 * Author: Monamedia
 * Order: 6
 */
$mona_sc_7_group = get_field('mona_sc_7_group');
?>
<?php if (isset($mona_sc_7_group['rp']) || !empty($mona_sc_7_group['rp'])) : ?>
    <div class="ser">
        <div class="ser-wrap">
            <div class="container">
                <div class="ser-inner">
                    <div class="ser-flex">
                        <div class="ser-left" data-aos="fade-right">
                            <div class="ser-ctn">
                                <p class="desc fw-6 t20"><?php echo $mona_sc_7_group['title']; ?></p>
                                <h2 class="title fw-7 f-title"><?php echo $mona_sc_7_group['des']; ?></h2>
                                <a class="btn btn-pri" href="<?php echo esc_url($mona_sc_7_group['link']) ?>"><span class="text"><?php _e('LIÊN HỆ NGAY', 'monamedia') ?></span></a>
                            </div>
                        </div>
                        <div class="ser-right" data-aos="fade-left">
                            <div class="ser-list">
                                <?php foreach ($mona_sc_7_group['rp'] as $key => $item) : ?>
                                    <div class="ser-item">
                                        <h2 class="fw-7 f-title title"><?php echo $item['title'] ?></h2>
                                        <div class="ser-desc">
                                            <p class="text"><?php echo $item['des'] ?></p><span class="icon">
                                                <?php echo wp_get_attachment_image($item['icon'], 'monamedia') ?>
                                            </span>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>