<?php

/**
 * Section name: Home Banners
 * Description: 
 * Author: Monamedia
 * Order: 7
 */
$mona_slogan_homepage = get_field('mona_slogan_homepage');
?>
<div class="hslo">
    <div class="hslo-wrap">
        <div class="container">
            <div class="hslo-inner" data-aos="zoom-in">
                <p class="text fw-5">
                    <?php echo $mona_slogan_homepage; ?>
                </p>
            </div>
        </div>
    </div>
</div>