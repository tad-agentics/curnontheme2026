<?php
/**
 * Undocumented class
 * Create widget
 */
class M_Contact_Information extends WP_Widget {

    public $Mona_Widgets;

    /**
     * Undocumented function
     */
    function __construct() {

        parent::__construct(
            'M_Contact_Information',
            __('Mona - Contacts [footer]', 'monamedia'),
            [
                'description' => __( 'To display contact information', 'monamedia' ),
            ]
        );

        // $this->Mona_Widgets = new Mona_Exs_Widgets();
    }

    /**
     * Undocumented function
     *
     * @param [type] $args
     * @param [type] $instance
     * @return void
     */
    public function widget( $args, $instance ) {

        $widget_id      = $args['widget_id'];
        $title                      = isset( $instance['title'] ) ? $instance['title'] : '';
        $icon                       = isset( $instance['icon'] ) ? $instance['icon'] : '';
        $contact_information_list   = isset( $instance['contact_information_list'] ) ? $instance['contact_information_list'] : '';
        ?>

        <?php if( is_array( $contact_information_list ) && !empty( $contact_information_list ) ){ ?>
        <p class="footer-title">
            <?php echo $title; ?>
        </p>
        <div class="footer-ct-content">
            <?php if( !empty( $icon ) ){ ?>
            <img src="<?php echo $icon; ?>" alt="">
            <?php } ?>
            <div class="footer-ct-phone">
                <?php 
                $countContactInformation = count( $contact_information_list );
                $countTemp = 1;
                foreach ($contact_information_list as $key => $contact) { ?>
                    <?php if( empty( $contact['url'] ) ){ ?>
                    <p class="text">
                        <?php echo $contact['content']; ?>
                    </p>
                    <?php }else{ ?>
                    <a href="<?php echo $contact['url']; ?>" target="<?php echo $contact['target'] == 'yes' ? 1 : 0; ?>"  class="text">
                        <?php echo $contact['content']; ?>
                    </a>
                    <?php } ?>
                    <?php if( $countTemp < $countContactInformation ){ ?>
                        <span>|</span>
                    <?php } ?>
                <?php 
                    $countTemp++;
                } ?>
            </div>
        </div>
        <?php } ?>

        <?php
    }

    /**
     * Undocumented function
     *
     * Widget Backend
     * @param [type] $instance
     * @return void
     */
    public function form( $instance ) {

        if ( isset( $instance[ 'title' ] ) ) {
            $title = $instance[ 'title' ];
        } else {
            $title = '';
        }

        Mona_Widgets::create_field(
            [
                'type'        => 'text',
                'name'        => $this->get_field_name( 'title' ),
                'id'          => $this->get_field_id( 'title' ),
                'value'       => $title,
                'title'       => __( 'Tiêu đề', 'monamedia' ),
                'placeholder' => __( 'Nhập nội dung văn bản', 'monamedia' ),
                'docs'        => false,
            ]
        );

        if ( isset( $instance[ 'icon' ] ) ) {
            $icon = $instance[ 'icon' ];
        } else {
            $icon = '';
        }

        Mona_Widgets::create_field(
            [
                'type'        => 'image',
                'name'        => $this->get_field_name( 'icon' ),
                'id'          => $this->get_field_id( 'icon' ),
                'value'       => $icon,
                'title'       => __( 'Icon', 'monamedia' ),
                'docs'        => false,
            ]
        );

        if ( isset( $instance[ 'contact_information_list' ] ) ) {
            $contact_information_list = $instance[ 'contact_information_list' ];
        } else {
            $contact_information_list = '';
        }

        Mona_Widgets::create_field(
            [
                'type'        => 'repeater',
                'name'        => $this->get_field_name( 'contact_information_list' ),
                'id'          => $this->get_field_id( 'contact_information_list' ),
                'value'       => $contact_information_list,
                'title'       => __( 'Danh sách thông tin liên lạc', 'monamedia' ),
                'fields' => [
                    'content' => [
                        'type'              => 'textarea',
                        'title'             => __( 'Content', 'monamedia' ),
                    ],
                    'url' => [
                        'type'              => 'textarea',
                        'title'             => __( 'Attachment Link', 'monamedia' ),
                    ],
                    'target' => [
                        'type'              => 'radio',
                        'title'             => __( 'Target', 'monamedia' ),
                        'radio' => [
                            'no'  => __( 'Không', 'monamedia' ),
                            'yes'  => __( 'Có', 'monamedia' ),
                        ],
                    ],
                ],
                'docs'   => false,
            ]
        );

    }

    /**
     * Undocumented function
     *
     * Updating widget replacing old instances with new
     * @param [type] $new_instance
     * @param [type] $old_instance
     * @return void
     */
    public function update( $new_instance, $old_instance ) {

        $instance = [];
        $instance['title'] = Mona_Widgets::update_field( $new_instance['title'] );
        $instance['icon'] = Mona_Widgets::update_field( $new_instance['icon'] );
        $instance['contact_information_list'] = Mona_Widgets::update_field( $new_instance['contact_information_list'] );

        return $instance;

    }

}

/**
 * Undocumented function
 *
 * Register and load the widget
 * @return void
 */
function M_Contact_Information() {
    register_widget( 'M_Contact_Information' );
}
add_action( 'widgets_init', 'M_Contact_Information' );