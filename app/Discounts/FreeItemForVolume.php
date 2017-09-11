<?php
/**
 * FreeItemForVolume Discount file
 * 
 * @category Discounts
 * @author   Pieterjan Fiers <pjfiers@gmail.com>
 * @version  0.1
 */
namespace App\Discounts;

use \App\Product;
/**
 * FreeItemForVolume Discount class
 * 
 * This Discount substracts the price of one product
 * of a given amount and given category,
 * a "buy 3 pay 2" kind of deal.
 * 
 * @category Discounts
 * @author   Pieterjan Fiers <pjfiers@gmail.com>
 * @version  0.1
 */
class FreeItemForVolume extends AbstractDiscount
{
    /**
     * Required parameters
     *
     * @var array
     */
    protected static $params = [
        'amount',
        'category'
    ];

    /**
     * Apply the discount to the order
     *
     * @param array $order  The order to apply it to
     * @param array $params The parameters of the discount
     * 
     * @return array
     */
    public static function apply(array $order, array $params): array
    {   
        // validate input        
        static::validate($params);

        $amount = (int) $params['amount'];
        $categoryId = (int) $params['category'];
        // find products in category Switches
        foreach ($order['items'] as &$item)
        {
            $quantity = (float) $item['quantity'];
            $product = Product::find($item['product-id']);
            // prevent invalid order from crashing app
            if (!$product) {
                continue;
            }
            // category 2 is Switches
            if ((int) $product->category === $categoryId
                && $quantity >= $amount)
            {
                // divide quantity by amount, the net rest is the amount of times
                // the discount needs to be applied
                $raw = $quantity / $amount;
                $net = floor($raw);
                $item['quantity'] = (int) $quantity + $net;
            }
        }

        return $order;
    }
}