<?php
/**
 * Template name: Contact Page
 * @author : Hy Hý
 */
get_header();
while ( have_posts() ):
    the_post();
    ?>

    <main class="main contact-page">
    </main>

    <?php
endwhile;
get_footer();