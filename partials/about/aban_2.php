<?php

/**
 * Section name: Home Banners
 * Description: 
 * Author: Monamedia
 * Order: 1
 */
$mona_sc_2_group = get_field('mona_sc_2_group');
if (isset($mona_sc_2_group['rp']) || !empty($mona_sc_2_group['rp'])) :
?>
<div class="aban">
    <?php foreach ($mona_sc_2_group['rp'] as $key => $item) : ?>
    <div class="aban-flex">
        <div class="aban-left">
            <div class="aban-desc" data-aos="fade-up">
                <h2 class="title f-title fw-7 t-center"><?php echo $item['title']; ?></h2>
                <div class="desc fw-5 t16 t-center mona-content"><?php echo $item['des']; ?></div>
            </div>
        </div>
        <div class="aban-right">
            <div class="aban-img" data-aos="zoom-in">
                <div class="box">
                    <?php echo wp_get_attachment_image($item['image'], 'full') ?>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>
<?php endif; ?>