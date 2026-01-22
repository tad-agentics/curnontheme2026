<?php
$sc_3_group_global = get_field('sc_3_group_global', MONA_PAGE_HOME);
$rp = $sc_3_group_global['rp'];
if (isset($rp) || !empty($rp)) :
?>

    <div class="pdp-more tabJS">
        <div class="pdp-more-top">
            <?php foreach ($rp as $key => $item) : ?>
                <div class="pdp-more-item tabBtn"><?php echo $item['tieu_de'] ?></div>
            <?php endforeach; ?>
        </div>
        <div class="pdp-more-ctn">
            <?php foreach ($rp as $key => $item) : ?>
                <div class="pdp-more-tab tabPanel mona-content">
                    <?php echo $item['noi_dung'] ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

<?php endif; ?>