<?php
class MonaProductVariations
{
    public static function Variations_html_archive($productId = '',  $attribute_primary_taxonomy = '',  $attribute_primary_first_slug = '')
    {
        if (empty($productId)) {
            $productId = get_the_ID();
        }

        ob_start();

        $product    = wc_get_product($productId);
        $variations = self::Variations($productId);
        $variation_first_attributes = self::Variation_first_attributes($productId);

        if (!empty($variations) && empty($attribute_primary_taxonomy) && empty($attribute_primary_first_slug)) {
            $first = true;
            foreach ($variations as $variation_attributes => $attributes_array) {
                foreach ($attributes_array as $key_attribute_slug => $attribute_item) {
                    if (!empty($attribute_item['parent']) && $first) {
                        $attribute_primary_taxonomy = $variation_attributes;
                        $attribute_primary_first_slug = $key_attribute_slug;
                        $first = false;
                    }
                }
            }
        }

        if (!empty($variations) && !empty($attribute_primary_taxonomy) && !empty($attribute_primary_first_slug)) {
            if (!empty($variations[$attribute_primary_taxonomy])) {
                $taxonomy_primary = str_replace('attribute_', '', $attribute_primary_taxonomy);
                $first = true;
?>
                <div class="popup-attri-item size form_data taxonomy-<?php echo $taxonomy_primary; ?>" id="taxonomy-<?php echo $taxonomy_primary ?>">

                    <p class="fw-5 c-grey"> <?php $attribute_label_name = wc_attribute_label($taxonomy_primary);
                                            if (!empty($attribute_label_name)) {
                                                echo $attribute_label_name;
                                            } ?></p>

                    <div class="recheck">
                        <div class="recheck-block">
                            <?php
                            foreach ($variations[$attribute_primary_taxonomy] as $attribute_primary_slug => $attribute_primary_item) {
                                $term_item = get_term_by('slug', $attribute_primary_slug, $taxonomy_primary);
                                $flagChecked = false;
                                if ($attribute_primary_item['default']) {
                                    $flagChecked = true;
                                }
                            ?>
                                <div class="recheck-item mona-variation-item-popup mona-name-attr <?php echo $flagChecked ? 'active' : ''; ?> is-loading-group" data-taxonomy="<?php echo $taxonomy_primary; ?>" data-slug="<?php echo $term_item->slug; ?>" data-product_id="<?php echo $productId; ?>">
                                    <input class="recheck-input" type="radio" value="<?php echo $term_item->slug; ?>" name="<?php echo $taxonomy_primary; ?>" <?php echo $flagChecked ? 'checked' : ''; ?> hidden />
                                    <p class="recheck-text"><?php echo $term_item->name; ?></p>
                                </div>
                            <?php
                            } ?>

                        </div>
                    </div>

                </div>

        <?php }
        } ?>
        <?php
        if (!empty($variations[$attribute_primary_taxonomy][$attribute_primary_first_slug]['relationship'])) {
            foreach ($variations[$attribute_primary_taxonomy][$attribute_primary_first_slug]['relationship'] as $attribute_relationship_name => $attribute_relationship_array) {
                $taxonomy_primary = str_replace('attribute_', '', $attribute_relationship_name);
        ?>


                <div class="popup-attri-item size form_data taxonomy-<?php echo $taxonomy_primary; ?>" id="taxonomy-<?php echo $taxonomy_primary ?>">

                    <p class="fw-5 c-grey"> <?php $attribute_label_name = wc_attribute_label($taxonomy_primary);
                                            if (!empty($attribute_label_name)) {
                                                echo $attribute_label_name;
                                            } ?></p>

                    <div class="recheck">

                        <div class="recheck-block <?php echo $first ? 'hasChecked' : ''; ?>">
                            <?php
                            foreach ($attribute_relationship_array as $attribute_relationship_slug => $attribute_relationship_item) {
                                $term_item = get_term_by('slug', $attribute_relationship_slug, $taxonomy_primary);
                                // $mona_taxonomy_color_avatar = get_field('mona_taxonomy_color_avatar', $term_item);
                                $mona_color_attribute = get_field('mona_color_attribute', $term_item);
                                $flagChecked = false;
                                // check default attribute
                                $default_attributes = $product->get_default_attributes();
                                if (!empty($default_attributes)) {
                                    if ($default_attributes[$taxonomy_primary] === $attribute_relationship_slug) {
                                        $flagChecked = true;
                                    }
                                }
                                if (!empty($mona_color_attribute)) {
                            ?>

                                    <div class="recheck-item checkbox_item recheck-item mona-variation-item-popup <?php echo $flagChecked ? 'active' : ''; ?>" data-taxonomy="<?php echo $taxonomy_primary; ?>" data-slug="<?php echo $term_item->slug; ?>" data-product_id="<?php echo $productId; ?>">
                                        <input class="recheck-input" type="radio" value="<?php echo $term_item->slug; ?>" name="<?php echo $taxonomy_primary; ?>" <?php echo $flagChecked ? 'checked' : ''; ?> hidden />
                                        <div class="recheck-checkbox">
                                            <?php echo wp_get_attachment_image($mona_color_attribute, 'full'); ?>
                                        </div>
                                    </div>

                                <?php } else { ?>

                                    <div class="recheck-item mona-variation-item-popup mona-name-attr <?php echo $flagChecked ? 'active' : ''; ?> is-loading-group" data-taxonomy="<?php echo $taxonomy_primary; ?>" data-slug="<?php echo $term_item->slug; ?>" data-product_id="<?php echo $productId; ?>">
                                        <input class="recheck-input" type="radio" value="<?php echo $term_item->slug; ?>" name="<?php echo $taxonomy_primary; ?>" <?php echo $flagChecked ? 'checked' : ''; ?> hidden />
                                        <p class="recheck-text"><?php echo $term_item->name; ?></p>
                                    </div>

                            <?php }
                            } ?>
                        </div>

                    </div>
                </div>


            <?php }
        }

        return ob_get_clean();
    }

    public static function Variations_html($productId = '',  $attribute_primary_taxonomy = '',  $attribute_primary_first_slug = '')
    {
        if (empty($productId)) {
            $productId = get_the_ID();
        }

        ob_start();

        $product    = wc_get_product($productId);
        $variations = self::Variations($productId);
        $variation_first_attributes = self::Variation_first_attributes($productId);

        if (!empty($variations) && empty($attribute_primary_taxonomy) && empty($attribute_primary_first_slug)) {
            $first = true;
            foreach ($variations as $variation_attributes => $attributes_array) {
                foreach ($attributes_array as $key_attribute_slug => $attribute_item) {
                    if (!empty($attribute_item['parent']) && $first) {
                        $attribute_primary_taxonomy = $variation_attributes;
                        $attribute_primary_first_slug = $key_attribute_slug;
                        $first = false;
                    }
                }
            }
        }

        if (!empty($variations) && !empty($attribute_primary_taxonomy) && !empty($attribute_primary_first_slug)) {
            if (!empty($variations[$attribute_primary_taxonomy])) {
                $taxonomy_primary = str_replace('attribute_', '', $attribute_primary_taxonomy);
                $first = true;
            ?>
                <div class="pdp-op-item kt form_data taxonomy-<?php echo $taxonomy_primary; ?>" id="taxonomy-<?php echo $taxonomy_primary ?>">
                    <div class="pdp-op-flex">

                        <div class="pdp-op-left">
                            <span class="text fw-5">
                                <?php $attribute_label_name = wc_attribute_label($taxonomy_primary);
                                if (!empty($attribute_label_name)) {
                                    echo $attribute_label_name;
                                } ?>
                            </span>
                        </div>

                        <div class="pdp-op-right">
                            <div class="recheck">
                                <div class="recheck-block">
                                    <?php
                                    foreach ($variations[$attribute_primary_taxonomy] as $attribute_primary_slug => $attribute_primary_item) {
                                        $term_item = get_term_by('slug', $attribute_primary_slug, $taxonomy_primary);
                                        $flagChecked = false;
                                        if ($attribute_primary_item['default']) {
                                            $flagChecked = true;
                                        }
                                    ?>
                                        <div class="recheck-item mona-variation-item-popup mona-name-attr <?php echo $flagChecked ? 'active' : ''; ?> is-loading-group" data-taxonomy="<?php echo $taxonomy_primary; ?>" data-slug="<?php echo $term_item->slug; ?>" data-product_id="<?php echo $productId; ?>">
                                            <input class="recheck-input" type="radio" value="<?php echo $term_item->slug; ?>" name="<?php echo $taxonomy_primary; ?>" <?php echo $flagChecked ? 'checked' : ''; ?> hidden />
                                            <p class="recheck-text"><?php echo $term_item->name; ?></p>
                                        </div>
                                    <?php
                                    } ?>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
        <?php }
        } ?>
        <?php
        if (!empty($variations[$attribute_primary_taxonomy][$attribute_primary_first_slug]['relationship'])) {
            foreach ($variations[$attribute_primary_taxonomy][$attribute_primary_first_slug]['relationship'] as $attribute_relationship_name => $attribute_relationship_array) {
                $taxonomy_primary = str_replace('attribute_', '', $attribute_relationship_name);
        ?>
                <div id="taxonomy-<?php echo $taxonomy_primary ?>" class="pdp-op-item sz product-attributes taxonomy-<?php echo $taxonomy_primary; ?>">

                    <div class="pdp-op-flex form_data">

                        <div class="pdp-op-left">
                            <span class="text fw-5">
                                <?php $attribute_label_name = wc_attribute_label($taxonomy_primary);
                                if (!empty($attribute_label_name)) {
                                    echo $attribute_label_name;
                                } ?></span>
                        </div>

                        <div class="pdp-op-right">
                            <div class="recheck">
                                <div class="recheck-block">
                                    <?php
                                    foreach ($attribute_relationship_array as $attribute_relationship_slug => $attribute_relationship_item) {
                                        $term_item = get_term_by('slug', $attribute_relationship_slug, $taxonomy_primary);
                                        $mona_color_attribute = get_field('mona_color_attribute', $term_item);

                                        $flagChecked = false;
                                        // check default attribute
                                        $default_attributes = $product->get_default_attributes();
                                        if (!empty($default_attributes)) {
                                            if ($default_attributes[$taxonomy_primary] === $attribute_relationship_slug) {
                                                $flagChecked = true;
                                            }
                                        }
                                    ?>
                                        <div class="recheck-item checkbox_item recheck-item mona-variation-item-popup <?php echo $flagChecked ? 'checked' : ''; ?>" data-taxonomy="<?php echo $taxonomy_primary; ?>" data-slug="<?php echo $term_item->slug; ?>" data-product_id="<?php echo $productId; ?>">
                                            <input class="recheck-input" type="radio" value="<?php echo $term_item->slug; ?>" name="<?php echo $taxonomy_primary; ?>" <?php echo $flagChecked ? 'checked' : ''; ?> hidden />
                                            <div class="recheck-checkbox">
                                                <?php echo wp_get_attachment_image($mona_color_attribute, 'full'); ?>
                                            </div>
                                        </div>

                                    <?php } ?>
                                </div>
                            </div>
                        </div>


                    </div>

                </div>

<?php }
        }

        return ob_get_clean();
    }

    public static function Variation_first_id($productId = '')
    {
        if (empty($productId)) {
            $productId = get_the_ID();
        }
        $variation_first_attributes = self::Variation_first_attributes($productId);
        $data_store  = WC_Data_Store::load('product');
        $variation_first_id = $data_store->find_matching_product_variation(new \WC_Product($productId), $variation_first_attributes);
        return  $variation_first_id;
    }

    public static function Variation_first_attributes($productId = '')
    {
        if (empty($productId)) {
            $productId = get_the_ID();
        }
        $variation_first_attributes = [];
        $product              = wc_get_product($productId);
        $product_type = '';
        $product_type = $product->get_type();
        if ($product_type == 'variable') {
            $variations           = self::Variations($productId);
            $typeVariation = count($product->get_attributes()) > 1 ? 'multiple' : 'single';
            if ($typeVariation == 'single') {
                if (!empty($variations)) {
                    $first = true;
                    foreach ($variations as $attribute_name => $items) {
                        foreach ($items as $item_slug => $item) {
                            if ($first) {
                                if (!empty($item['slug'])) {
                                    $variation_first_attributes[$attribute_name] = $item['slug'];
                                    $first = false;
                                }
                            }
                        }
                    }
                }
            } elseif ($typeVariation == 'multiple') {
                if (!empty($variations)) {
                    $first = true;
                    foreach ($variations as $variation_attributes => $attributes_array) {
                        foreach ($attributes_array as $key_attribute_slug => $attribute_item) {
                            if (!empty($attribute_item['parent']) && $first) {
                                if (!empty($attribute_item['relationship'])) {
                                    foreach ($attribute_item['relationship'] as $key_relationship_slug => $relationship_items) {
                                        if (!empty($relationship_items)) {
                                            foreach ($relationship_items as $relationship_item_slug => $relationship_item) {
                                                if ($first && $relationship_item['disabled'] == 'no' && $relationship_item['variation_id'] != 0 && $relationship_item['variation_id'] > 0) {
                                                    $variation_first_attributes = $relationship_item['variation_attributes'];
                                                    $first = false;
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        return  $variation_first_attributes;
    }

    public static function Variations($productId = '')
    {
        if (empty($productId)) {
            $productId = get_the_ID();
        }
        $variation_attributes = [];
        $product              = wc_get_product($productId);
        $product_type = '';
        $product_type = $product->get_type();
        if ($product_type == 'variable') {
            $variations           = $product->get_available_variations();
            $count                = 0;
            foreach ($product->get_attributes() as $attribute_name  => $attribute) {
                if ($attribute['variation']) {
                    if (!empty($product->get_variation_attributes()[$attribute_name])) {
                        $childItemVariations = $product->get_variation_attributes()[$attribute_name];
                        if (!empty($childItemVariations)) {
                            foreach ($childItemVariations as $varChildKey => $varChildValue) {
                                $varChildTerm = get_term_by('slug', $varChildValue, str_replace('attribute_', '', $attribute_name));
                                if (!empty($varChildTerm)) {
                                    $variation_attributes['attribute_' . $attribute_name][$varChildValue] = [
                                        'term_id' => $varChildTerm->term_id,
                                        'name'    => $varChildTerm->name,
                                        'slug'    => $varChildTerm->slug,
                                    ];
                                    if ($count == 0) {
                                        $variation_attributes['attribute_' . $attribute_name][$varChildValue]['parent'] = true;
                                    }
                                    // check default attribute
                                    $variation_attributes['attribute_' . $attribute_name][$varChildValue]['default'] = 0;
                                    $default_attributes = $product->get_default_attributes();
                                    if (!empty($default_attributes)) {
                                        if ($default_attributes[$attribute_name] === $varChildTerm->slug) {
                                            $variation_attributes['attribute_' . $attribute_name][$varChildValue]['default'] = 1;
                                        }
                                    }
                                    // relation
                                    $listAttributeRelations = self::getAttributeRelation($productId, $attribute_name, $varChildValue);
                                    if (!empty($listAttributeRelations)) {
                                        $variation_attributes['attribute_' . $attribute_name][$varChildValue]['relationship'] = $listAttributeRelations;
                                    } else {
                                        $variation_attributes['attribute_' . $attribute_name][$varChildValue]['variation_id'] = self::findVariationId($productId, ['attribute_' . $attribute_name => $varChildTerm->slug]);
                                    }
                                }
                            }
                        }
                        $count++;
                    }
                }
            }
        }
        return  $variation_attributes;
    }

    public static function getAttributeRelation($productId = '', $attributUnset = '', $attributValue = '')
    {
        if (empty($attributUnset) || empty($attributValue)) {
            return false;
        }
        if (empty($productId)) {
            $productId = get_the_ID();
        }
        $findAttributes       = [];
        $variation_attributes = [];
        $product              = wc_get_product($productId);
        $variations           = $product->get_available_variations();
        foreach ($product->get_attributes() as $attribute_name  => $attribute) {
            if ($attribute['variation']) {
                $childItemVariations = $product->get_variation_attributes()[$attribute_name];
                if (!empty($childItemVariations) && $attribute_name != $attributUnset) {
                    foreach ($childItemVariations as $varChildKey => $varChildValue) {
                        $varChildTerm = get_term_by('slug', $varChildValue, str_replace('attribute_', '', $attribute_name));
                        if (!empty($varChildTerm)) {
                            $variation_attributes['attribute_' . $attribute_name][$varChildValue] = [
                                'term_id' => $varChildTerm->term_id,
                                'name'    => $varChildTerm->name,
                            ];
                            // array
                            $totalCheck     = 0;
                            $listCheckItems = self::checkAttributeRelation($product, $attributUnset, $attributValue);
                            if (!empty($listCheckItems)) {
                                $totalCheck = count($listCheckItems);
                                if (count($listCheckItems) >= 2) {
                                    unset($listCheckItems['attribute_' . $attribute_name]);
                                }
                                // check
                                if ($totalCheck <= 1) {
                                    foreach ($listCheckItems as $checkkey => $subCheckItems) {
                                        if (!empty($subCheckItems)) {
                                            $count = 0;
                                            foreach ($subCheckItems as $subCheckKey => $subCheckValue) {
                                                $variation_attributes['attribute_' . $attribute_name][$varChildValue]['compare'][$count]['attribute_' . $attributUnset] = $attributValue;
                                                $variation_attributes['attribute_' . $attribute_name][$varChildValue]['compare'][$count]['attribute_' . $attribute_name] = $varChildValue;
                                                $count++;
                                            }
                                        }
                                    }
                                } else {
                                    foreach ($listCheckItems as $checkkey => $subCheckItems) {
                                        if (!empty($subCheckItems)) {
                                            $count = 0;
                                            foreach ($subCheckItems as $subCheckKey => $subCheckValue) {
                                                $variation_attributes['attribute_' . $attribute_name][$varChildValue]['compare'][$count]['attribute_' . $attributUnset] = $attributValue;
                                                $variation_attributes['attribute_' . $attribute_name][$varChildValue]['compare'][$count]['attribute_' . $attribute_name] = $varChildValue;
                                                $variation_attributes['attribute_' . $attribute_name][$varChildValue]['compare'][$count][$checkkey] = $subCheckValue['slug'];
                                                $count++;
                                            }
                                        }
                                    }
                                }
                            } else {
                                $variation_attributes['attribute_' . $attribute_name][$varChildValue]['compare'] = [];
                            }
                            //check disabled
                            $disabled     = 'yes';
                            $variation_id = 0;
                            $checkListCompare = $variation_attributes['attribute_' . $attribute_name][$varChildValue]['compare'];
                            if (!empty($checkListCompare)) {
                                foreach ($checkListCompare as $comKey => $comAttrbutes) {
                                    $findVariationId = self::findVariationId($productId, $comAttrbutes);
                                    if (!empty($findVariationId) && $findVariationId > 0) {
                                        $disabled     = 'no';
                                        $variation_id = $findVariationId;
                                        $variation_attributes['attribute_' . $attribute_name][$varChildValue]['variation_attributes'] = $comAttrbutes;
                                        continue;
                                    }
                                }
                            }
                            // result status 
                            $variation_attributes['attribute_' . $attribute_name][$varChildValue]['disabled'] = $disabled;
                            $variation_attributes['attribute_' . $attribute_name][$varChildValue]['variation_id'] = $variation_id;
                            // unset 
                            unset($variation_attributes['attribute_' . $attribute_name][$varChildValue]['compare']);
                        }
                    }
                }
            }
        }
        return  $variation_attributes;
    }

    public static function checkAttributeRelation($productId = '', $attributUnset = '', $attributValue = '')
    {
        if (empty($attributUnset) || empty($attributValue)) {
            return false;
        }

        if (empty($productId)) {
            $productId = get_the_ID();
        }

        $findAttributes       = [];
        $variation_attributes = [];
        $product              = wc_get_product($productId);
        $variations           = $product->get_available_variations();
        foreach ($product->get_attributes() as $attribute_name  => $attribute) {
            if ($attribute['variation']) {
                $childItemVariations = $product->get_variation_attributes()[$attribute_name];
                if (!empty($childItemVariations) && $attribute_name != $attributUnset) {
                    foreach ($childItemVariations as $varChildKey => $varChildValue) {
                        $varChildTerm = get_term_by('slug', $varChildValue, str_replace('attribute_', '', $attribute_name));
                        if (!empty($varChildTerm)) {
                            $variation_attributes['attribute_' . $attribute_name][$varChildValue] = [
                                'term_id' => $varChildTerm->term_id,
                                'name'    => $varChildTerm->name,
                                'slug'    => $varChildTerm->slug,
                            ];
                        }
                    }
                }
            }
        }
        return  $variation_attributes;
    }

    public static function findVariationId($productId = [], $attributes = [])
    {
        $data_store  = WC_Data_Store::load('product');
        $variationId = $data_store->find_matching_product_variation(new \WC_Product($productId), $attributes);
        return $variationId;
    }
}
