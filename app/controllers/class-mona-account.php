<?php
require_once get_template_directory() . "/app/controllers/upload/upload.class.php";

class Account
{

    private $id;
    private static $accountObject;
    private static $metaType;
    private static $currentMeta;

    public function __construct()
    {
        if (is_user_logged_in()) {
            $this->id = get_current_user_id();
            self::$accountObject = get_userdata($this->id);
        }
    }

    public function __init()
    {
        add_action('init', [$this, 'register_endpoint']);
        #update user 
        add_action('wp_ajax_m_a_edit_account', [$this, 'm_a_edit_account']);

        // remove menu
        add_filter('woocommerce_account_menu_items', [$this, 'remove_my_account_links']);

        // my acount change passsword
        add_action('woocommerce_account_change-password_endpoint', [$this, 'route_page_customer_support']);
        add_action('init', [$this, 'register_endpoint']);

        //wishlist
        // add_action('woocommerce_account_wish-list_endpoint', 'woocommerce_wishlist_content');
        add_action('woocommerce_account_wish-list_endpoint', [$this, 'woocommerce_wishlist_content']);
        add_action('init', [$this, 'primer_add_wishlist_endpoint']);

        //hang-the
        // add_action('woocommerce_account_wish-list_endpoint', 'woocommerce_wishlist_content');
        add_action('woocommerce_account_hang-the_endpoint', [$this, 'woocommerce_hang_the_content']);
        add_action('init', [$this, 'primer_add_hang_the_endpoint']);

        //shipping - address
        // add_action('woocommerce_account_wish-list_endpoint', 'woocommerce_wishlist_content');
        add_action('woocommerce_account_shipping-address_endpoint', [$this, 'woocommerce_shipping_address_content']);
        add_action('init', [$this, 'primer_add_shipping_address_endpoint']);

        //vi - voucher
        // add_action('woocommerce_account_wish-list_endpoint', 'woocommerce_wishlist_content');
        add_action('woocommerce_account_vi-voucher_endpoint', [$this, 'woocommerce_vi_voucher_content']);
        add_action('init', [$this, 'primer_add_vi_voucher_endpoint']);

        # up image 
        add_action('wp_ajax_mona_ajax_upload_post_img', [$this, 'mona_ajax_upload_post_img']); // co dang nhap 
    }
    public function error($code)
    {
        return http_response_code($code);
    }


    public static function userMeta($metaName = '')
    {
        if (!empty($metaName)) {
            self::$currentMeta = esc_attr($metaName);
            self::$metaType    = 'user_meta';
        }
        return new self;
    }

    public static function userCustomField($metaName = '')
    {
        if (!empty($metaName)) {
            self::$currentMeta = esc_attr($metaName);
            self::$metaType    = 'custom_field';
        }
        return new self;
    }

    public function get()
    {
        $currentMeta = self::$currentMeta;
        $metaType    = self::$metaType;
        switch ($metaType) {
            case 'user_meta';
                global $Supports;
                $supportAccount = isset($Supports['account']) ? $Supports['account'] : '';
                if (!empty($supportAccount)) {
                    $accountFields = isset($supportAccount['fields']) ? $supportAccount['fields'] : [];
                    if (!empty($accountFields) && in_array(self::$currentMeta, $accountFields)) {
                        return self::$accountObject->$currentMeta;
                    } else {
                        return [
                            'message' => __('Trường thông tin không tồn tại!', 'monamedia'),
                            'status'  => '404'
                        ];
                    }
                }
                break;
            case 'custom_field';
                break;
        }
    }

    public function display()
    {
        $currentMeta = self::$currentMeta;
        $metaType    = self::$metaType;
        switch ($metaType) {
            case 'user_meta';
                global $Supports;
                $supportAccount = isset($Supports['account']) ? $Supports['account'] : '';
                if (!empty($supportAccount)) {
                    $accountFields = isset($supportAccount['fields']) ? $supportAccount['fields'] : [];
                    if (!empty($accountFields) && in_array(self::$currentMeta, $accountFields)) {
                        echo self::$accountObject->$currentMeta;
                    } else {
                        return [
                            'message' => __('Trường thông tin không tồn tại!', 'monamedia'),
                            'status'  => '404'
                        ];
                    }
                }
                break;
            case 'custom_field';
                break;
        }
    }

    // icon dashboard 
    public function icon_item_menu($endpoint)
    {
        $arr = [
            'dashboard' => [
                'icon' => 'pf-usr.svg',
            ],
            'orders' => [
                'icon' => 'pf-docs.svg',
            ],
            'wish-list' => [
                'icon' => 'pf-heart.svg',
            ],
            'change-password' => [
                'icon' => 'pf-lock.svg',
            ],

        ];
        if (isset($arr[$endpoint])) {
            $icon = get_site_url() . '/template/assets/images/' . $arr[$endpoint]['icon'];
            return $icon;
        }
        return false;
    }

    // unset and change name off dashboarh
    function remove_my_account_links($menu_links)
    {

        unset($menu_links['downloads']);
        unset($menu_links['customer-logout']);
        unset($menu_links['edit-account']);
        unset($menu_links['edit-address']);

        $menu_links['dashboard']  = __('MY PROFILE', 'monamedia');
        // $menu_links['change-password']  = __('Change Password', 'monamedia');
        // $menu_links['orders']  = __('billing-history', 'monamedia');

        return $menu_links;
    }

    public function register_endpoint()
    {
        add_rewrite_endpoint('change-password', EP_ROOT | EP_PAGES);
        flush_rewrite_rules();
    }

    public function route_page_customer_support()
    {
        wc_get_template('myaccount/change-password.php');
    }

    public function primer_add_wishlist_endpoint()
    {
        add_rewrite_endpoint('wish-list', EP_ROOT | EP_PAGES);
    }


    public function woocommerce_wishlist_content()
    {
        wc_get_template('myaccount/wish-list.php');
    }

    public function primer_add_hang_the_endpoint()
    {
        add_rewrite_endpoint('hang-the', EP_ROOT | EP_PAGES);
    }


    public function woocommerce_hang_the_content()
    {
        wc_get_template('myaccount/hang-the.php');
    }

    // shipping address 
    public function primer_add_shipping_address_endpoint()
    {
        add_rewrite_endpoint('shipping-address', EP_ROOT | EP_PAGES);
    }


    public function woocommerce_shipping_address_content()
    {
        wc_get_template('myaccount/shipping-address.php');
    }

    //vi-voucher
    public function primer_add_vi_voucher_endpoint()
    {
        add_rewrite_endpoint('vi-voucher', EP_ROOT | EP_PAGES);
    }


    public function woocommerce_vi_voucher_content()
    {
        wc_get_template('myaccount/vi-voucher.php');
    }

    public function mona_ajax_upload_post_img()
    {
        $f =  $_POST['data'];

        $data = getimagesize($f);
        // $data = base64_decode($f);
        // var_dump($data);



        $file = array(
            'name' => 'user-upload-' . rand() . '.' . explode('/', $data['mime'])[1],
            'base' => $f,
            'type' =>  $data['mime'],
            'size' => $data['bits'],
        );
        // var_dump($file);

        $up = (new Mona_upload())->mona_upload_image_base64($file);
        // var_dump($up);

        $output = array('file_id' => $up, 'url' => wp_get_attachment_image_url($up, 'full'), 'status' => 'success', 'messenger' => __('Successfully Updated Profile Picture', 'monamedia'));
        if ($up != '') {
            update_user_meta(get_current_user_id(), '_thumb', $up);
        }
        echo json_encode($output);
        wp_die();
    }
}

(new Account())->__init();
