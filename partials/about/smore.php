<?php

/**
 * Section name: Home Banners
 * Description: 
 * Author: Monamedia
 * Order: 6
 */
$mona_sc_7_group = get_field('mona_sc_7_group');
if (isset($mona_sc_7_group['rp']) || !empty($mona_sc_7_group['rp'])) :
?>
    <div class="smore">
        <div class="smore-wrap">
            <div class="container">
                <div class="smore-inner">
                    <h2 class="title f-title fw-7" data-aos="zoom-in"><?php echo $mona_sc_7_group['title']; ?></h2>
                </div>
                <div class="smore-list">
                    <?php foreach ($mona_sc_7_group['rp'] as $key => $item) : ?>
                        <div class="smore-item" data-aos="fade-left">
                            <div class="smore-img">
                                <div class="box">
                                    <?php echo wp_get_attachment_image($item['image'], 'full'); ?>
                                </div>
                                <div class="smore-ctn">
                                    <p class="text t20 c-white fw-6">
                                        <?php echo $item['title']; ?>
                                    </p>
                                    <a href="<?php echo esc_url($item['link']) ?>" class="link fw-5 c-white"><?php _e('SHOP NOW', 'monamedia') ?></a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>