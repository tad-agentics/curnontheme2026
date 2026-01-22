<?php

/**
 * Section name: Home Banners
 * Description: 
 * Author: Monamedia
 * Order: 1 
 */
$mona_sc_2_group = get_field('mona_sc_2_group');
if (isset($mona_sc_2_group['tax']) || !empty($mona_sc_2_group['tax'])) :
?>

    <div class="hcollec">
        <div class="hcollec-wrap">
            <div class="hcollec-list" data-aos="fade-up">
                <?php foreach ($mona_sc_2_group['tax'] as $key => $item) :
                    $link = get_term_link($item);
                    $image = get_term_meta($item->term_id, 'thumbnail_id', true);
                ?>
                    <div class="hcollec-item">
                        <div class="hcollec-img">
                            <a class="box" href="<?php echo $link; ?>">
                                <?php echo wp_get_attachment_image($image, 'full'); ?>
                            </a>
                        </div>
                        <div class="hcollec-link"><?php echo $item->name; ?></div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php if (isset($mona_sc_2_group['rp']) || !empty($mona_sc_2_group['rp'])) : ?>
            <div class="hcollec-bot">
                <div class="hcollec-flex">
                    <?php foreach ($mona_sc_2_group['rp'] as $key => $item) : ?>
                        <div class="hcollec-bot-item" data-aos="fade-right">
                            <div class="hcollec-bot-img">
                                <?php echo wp_get_attachment_image($item['image'], 'full'); ?>
                            </div>
                            <div class="hcollec-desc">
                                <h2 class="title f-title c-white fw-7"><?php echo $item['title']; ?></h2><a class="link" href="<?php echo $item['link']; ?>"><?php _e('SHOP NOW', 'monamedia') ?></a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

    </div>
<?php endif; ?>