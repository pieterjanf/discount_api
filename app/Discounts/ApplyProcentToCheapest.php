<?php
/**
 * ApplyProcentToCheapest Discount file
 * 
 * @category Discounts
 * @author   Pieterjan Fiers <pjfiers@gmail.com>
 * @version  0.1
 */
namespace App\Discounts;

use App\Product;

/**
 * ApplyProcentToCheapest Discount class
 * 
 * This discount applies a percentage reduction to
 * the cheapest product within a given category
 * 
 * @category Discounts
 * @author   Pieterjan Fiers <pjfiers@gmail.com>
 * @version  0.1
 */
class ApplyProcentToCheapest extends AbstractDiscount
{
    /**
     * Required parameters
     *
     * @var array
     */
    protected static $params = [
        'category',
        'percentage'
    ];
    
    /**
     * Apply the discount to the order
     *
     * @param array $order  The order to apply it to
     * @param array $params The parameters of the discount
     * 
     * @return array|bool
     */
    public static function apply(array $order, array $params): array
    {
        static::validate($params);
        $cheapestId = null;
        $cheapestPrice = null;
        // iterate to find cheapest
        foreach ($order['items'] as $item) {
            $product = Product::find($item['product-id']);
            // prevent invalid order from crashing app
            if (!$product) {
                continue;
            }
            // skip mismatched categories
            if ((int) $product->category !== (int) $params['category']) {
                continue;
            }
            // get cheapest
            if (is_null($cheapestPrice)
                || $product->price < $cheapestPrice
            ) {
                $cheapestId = $product->id;
                $cheapestPrice = $product->price;
            }
        }
        
        // iterate again to apply cheapest
        foreach ($order['items'] as &$item) {
            $product = Product::find($item['product-id']);
            // prevent invalid order from crashing app
            if (!$product) {
                continue;
            }
            if ($product->id == $cheapestId) {
                $total = (float) $item['total'];
                $coefficient = $params['percentage'] / 100;
                $newTotal = $total - ($total * $coefficient);
                $item['total'] = $newTotal;
                // substract from order total
                $order['total'] = $order['total'] - ($total * $coefficient);
            }
        }

        return $order;
    }
}