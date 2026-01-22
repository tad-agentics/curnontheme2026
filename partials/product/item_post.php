<?php
global $post;
$cat_posts = get_the_terms($post->ID, 'category');
$post_expect = get_the_excerpt($post->ID);
$view = mona_get_post_view($post->ID);
?>

<!-- item post  -->
<div class="blog-img"><a class="box" href="<?php echo esc_url(get_the_permalink($post->ID)); ?>">
        <?php echo get_the_post_thumbnail($post->ID, 'full'); ?></a>
</div>
<div class="blog-desc">

    <?php if (!empty($cat_posts) || isset($cat_posts)) {
        foreach ($cat_posts as $cat) {
            $link_cat = get_term_link($cat); ?>
            <a class="blog-cate" href="<?php echo esc_url($link_cat); ?>">
                <?php echo $cat->name; ?>
            </a>
    <?php }
    } ?>

    <a class="blog-name" href="<?php echo esc_url(get_the_permalink($post->ID)); ?>"><?php echo $post->post_title; ?></a>
    <p class="blog-text"><?php echo $post_expect; ?></p>
    <p class="blog-time"> <?php echo date('F j, Y', strtotime($post->post_date)); ?> <?php _e('- ', 'monamedia'); ?>
        <?php echo $view; ?>
        <?php _e('view', 'monamedia'); ?></p>
    </p>
</div>