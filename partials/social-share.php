<div class="bdban-social">
    <span class="text t12 fw-5"><?php _e('Share:', 'monamedia') ?></span>
    <div class="bdban-social-list">
        <a class="bdban-social-item" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(get_the_permalink()); ?>&t=<?php the_title(); ?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=400,width=500');
                return false;">
            <img src="<?php get_site_url(); ?>/template/assets/images/fb.svg" alt="" />
        </a>
        <a class="bdban-social-item" href="http://www.twitter.com/share?url=<?php echo urlencode(get_the_permalink()); ?>" class="item twitter" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=400,width=500');
                return false;">
            <img src="<?php get_site_url(); ?>/template/assets/images/twitter.svg" alt="" />
        </a>
    </div>
</div>