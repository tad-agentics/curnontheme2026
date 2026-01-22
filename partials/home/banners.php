<?php

/**
 * Section name: Home Banners
 * Description: 
 * Author: Monamedia
 * Order: 0
 */
$mona_select_home_page = get_field('mona_select_home_page');
$banner_1 = get_field('banner_1');
$banner_2 = get_field('banner_2');
$banner_3 = get_field('banner_3');
$banner_4 = get_field('banner_4');
$banner_5 = get_field('banner_5');
$banner_6 = get_field('banner_6');

if ($mona_select_home_page == 1) : if ($banner_1) :
?>
<!-- banner 1  -->
<div class="hban">
    <div class="hban-wrap">
        <div class="hban1">
            <div class="hban1-flex">
                <div class="hban1-left" data-aos="fade-right">
                    <div class="hban1-top">
                        <p class="t16 text fw-6"><?php echo $banner_1['title']; ?></p>
                        <h2 class="title f-title fw-7"><?php echo $banner_1['des']; ?></h2>
                    </div>
                    <div class="hban1-bot">
                        <div class="text fw-5 mona-content"><?php echo $banner_1['des_2']; ?></div>
                        <a href="<?php echo $banner_1['link']; ?>" class="btn btn-pri" type="submit">
                            <span class="text"><?php _e('SHOP NOW', 'monamedia') ?></span><span class="icon"><i
                                    class="fa-solid fa-link"></i></span>
                        </a>
                    </div>
                </div>
                <div class="hban1-right" data-aos="fade-left">
                    <div class="hban1-img">
                        <a href="<?php echo esc_url( $banner_1['link_view'] ) ?>">
                            <?php echo wp_get_attachment_image($banner_1['image'], 'full') ?>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>
<?php endif; ?>

<!-- banner 2  -->
<?php if ($mona_select_home_page == 2) : if ($banner_2) : if (isset($banner_2['rp']) || !empty($banner_2['rp'])) : ?>

<div class="hban">
    <div class="hban-wrap">
        <div class="hban2">
            <div class="hban2-slide">
                <div class="swiper hban2Swiper">
                    <div class="swiper-wrapper">
                        <?php foreach ($banner_2['rp'] as $key => $item) : ?>
                        <div class="swiper-slide">
                            <div class="hban2-item">
                                <div class="hban2-img">
                                    <?php echo wp_get_attachment_image($item['image'], 'full'); ?>
                                </div>
                                <div class="hban2-ctn" data-aos="zoom-in">
                                    <p class="text"><?php echo $item['title']; ?></p>
                                    <h2 class="title f-title"><?php echo $item['des']; ?></h2><a class="link"
                                        href="<?php echo $item['link']; ?>"><?php _e('SHOP NOW', 'monamedia') ?></a>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>
<?php endif; ?>
<?php endif; ?>

<!-- banner 3  -->
<?php if ($mona_select_home_page == 3) : if ($banner_3) : if (isset($banner_3['rp']) || !empty($banner_3['rp'])) : ?>
<div class="hban">
    <div class="hban-wrap">
        <div class="hban3">
            <div class="hban3-slide">
                <div class="swiper hban3Swiper">
                    <div class="swiper-wrapper">
                        <?php foreach ($banner_3['rp'] as $key => $item) : ?>
                        <div class="swiper-slide">
                            <div class="hban3-item">
                                <div class="hban3-bg">
                                    <?php echo wp_get_attachment_image($item['image'], 'full'); ?>
                                </div>
                                <div class="hban3-ctn">
                                    <a class="cate" href="">
                                        <?php echo $item['title']; ?>
                                    </a>
                                    <h2 class="title f-title"><?php echo $item['des']; ?></h2>
                                    <div class="text mona-content">
                                        <?php echo $item['des_2']; ?>
                                    </div>
                                    <a class="link" href="<?php echo $item['link']; ?>">
                                        <?php _e('SHOP NOW', 'monamedia'); ?>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="hban3-thumb">
                    <div class="swiper hban3ThumbSwiper" thumbsslider="">
                        <div class="swiper-wrapper">
                            <?php foreach ($banner_3['rp'] as $key => $item) : ?>
                            <div class="swiper-slide">
                                <div class="hban3-img">
                                    <?php echo wp_get_attachment_image($item['image'], 'full'); ?>
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
<?php endif; ?>
<?php endif; ?>

<!-- banner 4  -->
<?php if ($mona_select_home_page == 4) :  if ($banner_4) : ?>
<div class="hban">
    <div class="hban-wrap">
        <div class="hban4">
            <div class="hban4-flex">
                <div class="hban4-left" data-aos="fade-right">
                    <div class="hban4-top">
                        <p class="t16 text fw-6"><?php echo $banner_4['title']; ?></p>
                        <h2 class="title f-title fw-7"><?php echo $banner_4['des']; ?></h2>
                    </div>
                    <div class="hban4-bot">
                        <div class="text fw-5 mona-content"><?php echo $banner_4['des_2']; ?></div>
                        <a href="<?php echo $banner_4['link']; ?>" class="btn btn-pri">
                            <span class="text"><?php _e('SHOP NOW', 'monamedia') ?></span><span class="icon"><i
                                    class="fa-solid fa-link"></i></span>
                        </a>
                    </div>
                </div>
                <?php if (isset($banner_4['image']) || !empty($banner_4['image'])) : ?>
                <div class="hban4-right" data-aos="fade-left">
                    <div class="hban4-list">
                        <?php foreach ($banner_4['image'] as $key => $item) : ?>
                        <div class="hban4-img">
                            <?php echo wp_get_attachment_image($item, 'full'); ?>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>
<?php endif; ?>

<!-- banner 5  -->
<?php if ($mona_select_home_page == 5) : if ($banner_5) : if (isset($banner_5['rp']) || !empty($banner_5['rp'])) : ?>
<div class="hban">
    <div class="hban-wrap">
        <div class="hban5">
            <div class="hban5-slide">
                <div class="swiper hban5Swiper">
                    <div class="swiper-wrapper">
                        <?php $count = 1;
                                    foreach ($banner_5['rp'] as $key => $item) : ?>
                        <div class="swiper-slide">
                            <div class="hban5-item">
                                <div class="hban5-img">
                                    <?php echo wp_get_attachment_image($item['image'], 'full'); ?>
                                </div>
                                <div class="hban5-ctn" data-aos="zoom-in">
                                    <p class="text"> <?php echo $item['title']; ?></p>
                                    <h2 class="title f-title"> <?php echo $item['des']; ?></h2>
                                    <a class="btn btn-pri trans" href=" <?php echo $item['link']; ?>"><span
                                            class="text"><?php _e('SHOP NOW', 'monamedia') ?></span></a>
                                </div>
                                <div class="hban5-desc"><?php echo $item['des_2']; ?></div>
                            </div>
                        </div>
                        <?php $count++;
                                    endforeach; ?>
                    </div>
                    <div class="hban5-pagi" data-aos="fade-left"><span
                            class="num f-title current"><?php _e('01', 'monamedia') ?></span>
                        <div class="swiper-pagination hban5Swiper-pagination"> </div><span
                            class="num f-title total"><?php if ($count < 10) {
                                                                                                                                        echo '0' . $count;
                                                                                                                                    } else {
                                                                                                                                        echo $count;
                                                                                                                                    } ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>
<?php endif; ?>
<?php endif; ?>

<!-- banner 6  -->
<?php if ($mona_select_home_page == 6) : if ($banner_6) : ?>
<div class="hban">
    <div class="hban-wrap">
        <div class="hban6">
            <div class="container">
                <div class="hban6-inner">
                    <div class="hban6-flex">
                        <div class="hban6-left" data-aos="fade-right">
                            <div class="hban6-top">
                                <div class="hban6-top-flex">
                                    <div class="hban6-top-left">
                                        <p class="text">
                                            <?php echo $banner_6['des'] ?>
                                        </p>
                                    </div>
                                    <div class="hban6-top-right"> <a class="link"
                                            href="<?php echo $banner_6['des'] ?>"><?php _e('SHOP NOW', 'monamedia') ?></a>
                                    </div>
                                </div>
                            </div>
                            <div class="hban6-bot">
                                <div class="hban6-left-img">
                                    <?php echo wp_get_attachment_image($banner_6['image'], 'full'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="hban6-right" data-aos="fade-left">
                            <div class="hban6-img">
                                <?php echo wp_get_attachment_image($banner_6['image_2'], 'full'); ?>
                            </div>
                        </div>
                    </div>
                    <div class="hban6-bottom" data-aos="zoom-in">
                        <h2 class="title f-title fw-7 t-center">
                            <?php echo $banner_6['des_2'] ?>
                        </h2>
                        <a class="cate" href="<?php echo $banner_6['link_2'] ?>">
                            <?php _e('NEW ARRIVALS', 'monamedia') ?>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>
<?php endif; ?>