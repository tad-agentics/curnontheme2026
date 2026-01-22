<?php
$mona_shortcode = get_field('mona_shortcode', MONA_PAGE_HOME);
?>
<div class="support" data-aos="fade-up">
    <?php
    if (!empty($mona_shortcode)) {
        echo do_shortcode($mona_shortcode);
    }
    ?>
</div>