# 🔒 SECURITY FIXES CHECKLIST - IMMEDIATE ACTION REQUIRED

## ⚠️ CRITICAL - FIX TODAY (Before ANY Production Deployment)

### 1. Remove/Secure Backdoor Function ❌
**File:** `core/classes/class-mona-setup.php` (Lines 216-239)
- [ ] Remove `_back_admin()` function entirely OR
- [ ] Add IP whitelist
- [ ] Add secret key authentication
- [ ] Add proper logging
- [ ] Test that it's secure

### 2. Add CSRF Protection to ALL AJAX Handlers ❌
**Files:** `app/ajax/*.php`

#### cart-ajax.php
- [ ] Add `check_ajax_referer('mona_cart_nonce', 'nonce');` to `mona_ajax_add_to_cart()`
- [ ] Add nonce field to frontend form
- [ ] Test cart functionality

#### user-ajax.php
- [ ] Add nonce check to `mona_user_save_order()`
- [ ] Add nonce check to `mona_user_save_shipping()`
- [ ] Add nonce check to `mona_user_save_time()`
- [ ] Add nonce check to `mona_user_save_vat()`
- [ ] Add nonce fields to all user forms

#### account-ajax.php
- [ ] Add nonce check to all functions
- [ ] Add nonce fields to account forms

#### product-ajax.php
- [ ] Add nonce check to all functions
- [ ] Add nonce fields to product forms

#### default-ajax.php
- [ ] Add nonce check to all functions
- [ ] Add nonce fields to filter/search forms

### 3. Fix SQL Injection Vulnerabilities ❌
**File:** `app/ajax/default-ajax.php`

- [ ] Line 185: Wrap query in `$wpdb->prepare()`
- [ ] Line 467: Wrap query in `$wpdb->prepare()`
- [ ] Line 677: Wrap query in `$wpdb->prepare()`
- [ ] Test all price filtering functionality

### 4. Sanitize ALL User Inputs ❌
**Files:** All AJAX handlers

#### cart-ajax.php
```php
- [ ] Line 12: $type = sanitize_text_field($_POST['type']);
- [ ] Line 14: Add sanitization after parse_str()
```

#### user-ajax.php
```php
- [ ] Sanitize all $dataForm fields with appropriate functions:
  - [ ] sanitize_email() for emails
  - [ ] sanitize_text_field() for text
  - [ ] sanitize_textarea_field() for textareas
```

#### account-ajax.php
```php
- [ ] Sanitize all form fields
- [ ] Validate email addresses
- [ ] Validate phone numbers
```

---

## 🔥 HIGH PRIORITY - FIX THIS WEEK

### 5. Fix Broken Image Paths (182 occurrences) ⚠️
**Files:** Multiple template files

**Search for:**
```php
<?php get_site_url(); ?>/template/
```

**Replace with:**
```php
<?php echo get_template_directory_uri(); ?>/public/helpers/
```

**Files to fix:**
- [ ] `header.php` (50+ occurrences)
- [ ] `page-template/account-tenplate.php`
- [ ] `core/walker-menu.php`
- [ ] `woocommerce/single-product.php`
- [ ] All partials files
- [ ] Test ALL pages to verify images load

### 6. Properly Enqueue Assets ⚠️
**File:** `header.php`

- [ ] Remove hardcoded CSS/JS from header (lines 30-33)
- [ ] Move to `wp_enqueue_scripts` action in `core/hooks.php`
- [ ] Use `wp_enqueue_style()` for CSS
- [ ] Use `wp_enqueue_script()` for JS
- [ ] Remove duplicate jQuery loading
- [ ] Test frontend loads correctly

### 7. Add Data Validation ⚠️
**File:** `app/ajax/user-ajax.php`

```php
// Add to each function:
- [ ] Email validation: is_email()
- [ ] Phone validation: preg_match()
- [ ] Required field checks
- [ ] Length validation
- [ ] Format validation
```

### 8. Add Nonces to Frontend Forms ⚠️

- [ ] `woocommerce/single-product.php` - Add to product form
- [ ] `woocommerce/checkout/form-checkout.php` - Verify nonce exists
- [ ] All account forms - Add nonces
- [ ] All AJAX forms - Add nonces

### 9. Fix Hardcoded Page IDs ⚠️
**File:** `functions.php`

```php
// Replace:
define('MONA_PAGE_LOGIN', url_to_postid(get_the_permalink(53)));

// With:
define('MONA_PAGE_LOGIN', 53); // Or use theme options
```

- [ ] Update MONA_PAGE_LOGIN
- [ ] Update MONA_PAGE_REGISTER
- [ ] Update MONA_PAGE_FORGOT
- [ ] Update MONA_PAGE_ABOUT
- [ ] Consider moving to theme customizer

### 10. Fix ACF Security Issue ⚠️
**File:** `functions.php` (Lines 16-20)

```php
// Replace:
if (get_current_user_id() == 1) {

// With:
if (current_user_can('manage_options')) {
```

- [ ] Update ACF check
- [ ] Test with different admin accounts
- [ ] Verify ACF access works correctly

---

## 📋 MEDIUM PRIORITY - FIX THIS MONTH

### 11. Update DOCTYPE ⚠️
**File:** `header.php`

- [ ] Replace XHTML DOCTYPE with HTML5
- [ ] Remove IE conditional comments
- [ ] Test browser compatibility

### 12. Update WooCommerce Templates ⚠️
**Files:** `woocommerce/*.php`

- [ ] Check WooCommerce version compatibility
- [ ] Update template version numbers
- [ ] Compare with latest WooCommerce templates
- [ ] Test checkout process
- [ ] Test cart functionality

### 13. Fix Global Variable Access ⚠️
**Files:** Multiple AJAX handlers

```php
// Replace:
global $woocommerce;
$count = $woocommerce->cart->cart_contents_count;

// With:
$count = WC()->cart->get_cart_contents_count();
```

- [ ] Update cart-ajax.php
- [ ] Update all WooCommerce global references
- [ ] Test functionality

### 14. Fix Undefined Variables ⚠️
**File:** `woocommerce/single-product.php`

- [ ] Line 44: Change `$product` to `$product_obj`
- [ ] Line 53: Change `$product` to `$product_obj`
- [ ] Line 57: Change `$product` to `$product_obj`
- [ ] Test product pages

### 15. Add Error Handling ⚠️
**Files:** All AJAX handlers

```php
// Add to each AJAX function:
$product = wc_get_product($product_id);
if (!$product) {
    wp_send_json_error(['message' => __('Product not found', 'monamedia')]);
    wp_die();
}
```

- [ ] Add to cart-ajax.php
- [ ] Add to product-ajax.php
- [ ] Add to all product-related functions
- [ ] Test error scenarios

---

## 🧹 LOW PRIORITY - Clean Up

### 16. Remove Backup Files 📁
- [ ] Delete `partials/about/histo.php.bak.2026-01-09_161709`
- [ ] Delete `partials/about/histo.php.bak.2026-01-09_162107`
- [ ] Delete `partials/enterprise/sgaller.php.bak.2026-01-09_161709`
- [ ] Delete `partials/enterprise/sgaller.php.bak.2026-01-09_164013`
- [ ] Delete `partials/product/item.php.bak.2026-01-09_161709`
- [ ] Delete `partials/product/item.php.bak.2026-01-09_163709`
- [ ] Delete `woocommerce/archive-product.php.bak.2026-01-09_153053`
- [ ] Delete `partials/home/hslide.php.bak.2026-01-09_153439`
- [ ] Delete `partials/home/spro.php.bak`

### 17. Fix Text Domains 📝
**Files:** Multiple

- [ ] Search for `'monadia'` and replace with `'monamedia'`
- [ ] Search for `'mona-admin'` and replace with `'monamedia'`
- [ ] Verify translations work

### 18. Remove Debug Code 🐛
**File:** `core/functions.php`

- [ ] Remove or improve `show()` function (lines 369-376)
- [ ] Use `WP_DEBUG` constant instead
- [ ] Remove any `var_dump()` or `print_r()` calls

### 19. Clean Up Unused Code 🗑️
- [ ] Review `woocommerce_primary/` folder
- [ ] Remove if unused
- [ ] Document if needed

---

## ✅ TESTING CHECKLIST

After implementing fixes, test:

### Security Testing
- [ ] Try to submit forms without nonces (should fail)
- [ ] Try SQL injection in price filters (should be blocked)
- [ ] Try XSS in form fields (should be sanitized)
- [ ] Verify backdoor is removed/secured
- [ ] Test with security scanner (Wordfence, Sucuri)

### Functionality Testing
- [ ] All images load correctly
- [ ] Add to cart works
- [ ] Checkout process works
- [ ] User account updates work
- [ ] Product filtering works
- [ ] Search works
- [ ] Mobile menu works
- [ ] All forms submit correctly

### Cross-Browser Testing
- [ ] Chrome
- [ ] Firefox
- [ ] Safari
- [ ] Edge
- [ ] Mobile browsers

### Performance Testing
- [ ] Page load speed
- [ ] Database query count
- [ ] Asset loading
- [ ] AJAX response times

---

## 📊 PROGRESS TRACKER

- **Critical Issues Fixed:** 0/4 (0%)
- **High Priority Fixed:** 0/6 (0%)
- **Medium Priority Fixed:** 0/9 (0%)
- **Low Priority Fixed:** 0/3 (0%)

**Overall Progress:** 0/22 (0%)

---

## 🚀 DEPLOYMENT CHECKLIST

Before deploying to production:

- [ ] All critical issues fixed
- [ ] All high priority issues fixed
- [ ] Security scan passed
- [ ] Functionality tested
- [ ] Backup created
- [ ] Staging environment tested
- [ ] Client approval received
- [ ] Documentation updated

---

## 📞 SUPPORT

If you need help with any fixes:
1. Refer to `CRITICAL_REVIEW_REPORT.md` for detailed explanations
2. Check WordPress Codex for function references
3. Consult WooCommerce documentation
4. Consider hiring WordPress security expert

---

**Last Updated:** January 22, 2026  
**Status:** ⚠️ NOT PRODUCTION READY - CRITICAL FIXES REQUIRED
