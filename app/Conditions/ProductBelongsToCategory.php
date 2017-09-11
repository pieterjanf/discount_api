<?php
/**
 * ProductBelongsToCategory condition file
 * 
 * @category Conditions
 * @author   Pieterjan Fiers <pjfiers@gmail.com>
 * @version  0.1
 */

namespace App\Conditions;

use \App\Product;

/**
 * ProductBelongsToCategory condition class
 * 
 * Assert if a product matches a given category
 * 
 * @category Conditions
 * @author   Pieterjan Fiers <pjfiers@gmail.com>
 * @version  0.1
 */
class ProductBelongsToCategory extends AbstractCondition
{
    /**
     * Required params
     *
     * @var array
     */
    static $params = [
        'category'
    ];

    /**
     * Assert if condition applies
     *
     * @param array $order  Order to check
     * @param array $params Params of the condition
     * 
     * @return array|bool
     */
    public static function assert(array $order, array $params)
    {
        static::validate($params);
        // iterate over items
        $items = $order['items'];
        $hits = [];
        foreach ($items as $item) {
            $product = Product::find($item['product-id']);
            // category 2 is Switches
            if ((int) $product->category === (int) $params['category']) {
                $hits[] = $product;
            }
        }

        if (!empty($hits)) {
            return $hits;
        }

        return false;
    }
}