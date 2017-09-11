<?php
/**
 * CustomerHasRevenueOver condition file
 * 
 * @category Conditions
 * @author   Pieterjan Fiers <pjfiers@gmail.com>
 * @version  0.1
 */

namespace App\Conditions;

/**
 * CustomerHasRevenueOver condition class
 * 
 * Assert if a customer has a revenue over a given amount
 * 
 * @category Conditions
 * @author   Pieterjan Fiers <pjfiers@gmail.com>
 * @version  0.1
 */
class CustomerHasRevenueOver extends AbstractCondition
{
    /**
     * Required params
     *
     * @var array
     */
    static $params = [
        'minimum'
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
        // get customer
        $customerDb = new \App\Customer;
        $customer = $customerDb->find($order['customer-id']);
        // assert if total is over 1000
        if ((float) $customer->revenue > (int) $params['minimum']) {
            return true;
        }
        return false;
    }
}