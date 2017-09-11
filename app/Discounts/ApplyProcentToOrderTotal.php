<?php
/**
 * ApplyProcentToOrderTotal Discount file
 * 
 * @category Discounts
 * @author   Pieterjan Fiers <pjfiers@gmail.com>
 * @version  0.1
 */

namespace App\Discounts;

/**
 * ApplyProcentToOrderTotal Discount class
 * 
 * This Discount applies a percentage reduction to the order-total
 * 
 * @category Discounts
 * @author   Pieterjan Fiers <pjfiers@gmail.com>
 * @version  0.1
 */
class ApplyProcentToOrderTotal extends AbstractDiscount
{
    /**
     * Required parameters
     *
     * @var array
     */
    protected static $params = [
        'percentage'
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
        static::validate($params);
        $total = (float) $order['total'];
        $coeficient = 1 + ($params['percentage'] / 100);
        $newTotal = $total * $coeficient;
        $order['total'] = $newTotal;
        return $order;
    }
}