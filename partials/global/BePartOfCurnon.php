<?php
$sc_6_group_global = get_field('sc_6_group_global', MONA_PAGE_HOME);
$tieu_de = $sc_6_group_global['tieu_de'];
$noi_dung = $sc_6_group_global['noi_dung'];
$gallery = $sc_6_group_global['gallery'];
if (isset($sc_6_group_global) || !empty($sc_6_group_global)) :
?>

    <div class="spart">
        <div class="spart-wrap">
            <div class="spart-top">
                <div class="container">
                    <h2 class="title fw-7 t-center f-title" data-aos="fade-up"><?php echo $tieu_de; ?></h2>
                    <p class="text fw-5 c-grey t-center" data-aos="fade-up"><?php echo $noi_dung; ?></p>
                </div>
            </div>

            <?php if (isset($gallery) || !empty($gallery)) : ?>

                <div class="spart-inner" data-aos="fade-up">
                    <div class="spart-slide">
                        <div class="swiper spartSwiper">
                            <div class="swiper-wrapper">

                                <?php foreach ($gallery as $key => $item) { ?>

                                    <div class="swiper-slide">
                                        <div class="spart-img">
                                            <?php echo wp_get_attachment_image($item, 'full'); ?>
                                        </div>
                                    </div>

                                <?php } ?>

                            </div>
                        </div>
                    </div>
                </div>

            <?php endif; ?>

        </div>
    </div>

<?php endif; ?>