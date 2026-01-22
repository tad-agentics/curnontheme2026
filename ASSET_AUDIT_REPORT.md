# Asset Audit Report

Date: 2026-01-22

## Summary

- No `/template/` directory exists in the theme repository.
- 271 references to `/template/` asset paths were found across 39 files.
- Many occurrences call `get_site_url()` without `echo`, resulting in empty `src`/`href`.
- Only 12 image files exist in `public/helpers/images/`, which does not match the referenced assets.

## Existing Theme Images

These exist in `public/helpers/images/`:

- `cart-empty.png`
- `cart-empty.png.webp`
- `cube-loading.svg`
- `default-mona.png`
- `default-mona.png.webp`
- `ic-admin-logout.svg`
- `ic-admin-user.svg`
- `icon-fav.svg`
- `icon-loading-ring.svg`
- `loader-2.svg`
- `loader.svg`
- `loading_see_more.svg`

## Referenced `/template/assets/images` (sample)

The following are referenced but **not present** in the theme (partial list):

- `cart.svg`
- `Star.svg`, `Star-fill.svg`
- `user.svg`, `heart.svg`
- `hamburger.svg`, `search.svg`, `location.svg`
- `vnpay.png`, `momo.png`, `fundiin.png`
- `pro1.jpg`, `pro2.jpg`, `ts1.jpg`, `ts2.jpg`, `ts3.jpg`, `ts4.jpg`
- `empty-cart.png`, `empty-cart-curnon.png`, `empty-evaluate.png`

Full raw references are in `ASSET_PATHS_FOUND.txt`.

## Action Required (Before Path Fixes)

1. Identify the real asset source:
   - External `/template/` directory in WordPress root
   - CDN or plugin assets
   - Missing assets that must be sourced
2. Decide on strategy:
   - **External assets** → use correct base URL and `echo get_site_url()`
   - **Move into theme** → relocate into a new `public/assets/images/` and update paths
   - **CDN** → define `MONA_ASSETS_URL` constant and use consistently

## Recommended Next Step

Confirm where `/template/assets/images/` is intended to live. Do not batch-replace paths until this source is confirmed.
