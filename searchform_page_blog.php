<form method="get" id="searchform" class="searchform" action="<?php echo esc_url(home_url('/')); ?>">
    <div class="blog-srch-inner">
        <input type="text" class="search-field" name="s" value="<?php echo get_search_query(); ?>" id="s" placeholder="<?php echo esc_attr_x('Nhập từ khóa...', 'placeholder', 'monamedia'); ?>" />
        <button type="submit" class="icon">
            <div class="fa-regular fa-magnifying-glass"></div>
        </button>
    </div>
</form>