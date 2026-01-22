<?php

/**
 * Template name: About History Page
 * @author : Hy Hý
 */
get_header();
while (have_posts()) :
    the_post();
?>

    <main class="main page-template">
        <?php Elements::Group('about')->Html(); ?>
    </main>

<?php
endwhile;
get_footer();
