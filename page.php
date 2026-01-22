<?php

/**
 * The template for displaying page template.
 *
 * @package Monamedia
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

get_header();
while (have_posts()) :
    the_post();
?>

<main class="main page-template">
    <?php the_content(); ?>
</main>

<?php
endwhile;
get_footer();