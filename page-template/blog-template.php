<?php

/**
 * Template name: Blog Page
 * @author : Hy Hý
 */
get_header();
while (have_posts()) :
    the_post();
?>

<main class="main page-template">

    <?php Elements::Group('blog')->Html(); ?>

    <!-- FormBlog  -->
    <?php get_template_part('partials/global/FormBlog');  ?>

</main>

<?php
endwhile;
get_footer();