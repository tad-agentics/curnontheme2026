<?php
$sc_4_group_global = get_field('sc_4_group_global', MONA_PAGE_HOME);
$rp = $sc_4_group_global['rp'];
if (isset($rp) || !empty($rp)) :
?>

    <div class="spo">
        <div class="spo-wrap">
            <div class="swiper spoSwiper">
                <div class="swiper-wrapper">

                    <?php foreach ($rp as $key => $item) : ?>

                        <div class="swiper-slide">
                            <div class="spo-item">
                                <span class="icon">
                                    <?php echo wp_get_attachment_image($item['icon_rp'], 'full') ?>
                                </span>
                                <span class="text">
                                    <?php echo $item['noi_dung_rp']; ?>
                                </span>
                            </div>
                        </div>

                    <?php endforeach; ?>

                </div>
            </div>
        </div>
    </div>

<?php endif; ?>