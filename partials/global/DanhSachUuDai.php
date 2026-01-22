<?php
$sc_2_group_global = get_field('sc_2_group_global', MONA_PAGE_HOME);
$rp = $sc_2_group_global['rp'];
if (isset($rp) || !empty($rp)) :
?>

    <div class="pdp-poli">

        <?php foreach ($rp as $key => $item) : ?>

            <div class="pdp-poli-item">
                <span class="icon">
                    <?php echo wp_get_attachment_image($item['icon_rp'], 'full'); ?>
                </span><span class="text fw-5 c-grey t12">
                    <?php echo $item['noi_dung_rp'] ?>
                </span>
            </div>

        <?php endforeach; ?>

    </div>
<?php endif ?>