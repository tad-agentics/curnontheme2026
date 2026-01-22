<form method="get" id="searchform" class="searchform" action="<?php echo esc_url(home_url('/')); ?>">
    <div class="header-sform">
        <div class="header-sform-close header-sform-close-js"><span class="text">Đóng</span></div>
        <div class="container">
            <div class="header-sform-inner">
                <form action="">
                    <div class="header-sform-input">
                        <input type="text" class="search-field" name="s" value="<?php echo get_search_query(); ?>"
                            id="s"
                            placeholder="<?php echo esc_attr_x('Nhập từ khóa...', 'placeholder', 'monamedia'); ?>" />
                        <button class="btn btn-pri" type="submit"><span class="text">Tìm kiếm</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</form>