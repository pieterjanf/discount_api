<?php
/**
 * Abstract Discount file
 * 
 * @category Discounts
 * @author   Pieterjan Fiers <pjfiers@gmail.com>
 * @version  0.1
 */

namespace App\Discounts;

/**
 * Abstract Discount class
 * 
 * A Discount applies a reduction based on parameters
 * 
 * @category Discounts
 * @author   Pieterjan Fiers <pjfiers@gmail.com>
 * @version  0.1
 */

abstract class AbstractDiscount
{
    /**
     * Required parameters
     *
     * @var array
     */
    protected static $params = [];

    /**
     * Validate if required parameters are given
     *
     * @param array $params Given parameters
     * @return void
     */
    final static function validate(array $params)
    {
        sort(static::$params);
        $testParams = array_keys($params);
        sort($testParams);
        if (static::$params !== $testParams) {
            throw new \Exception('Insufficient parameters.');
        }
    }

    /**
     * Apply the discount to the order
     *
     * @param array $order  The order to apply it to
     * @param array $params The parameters of the discount
     * 
     * @return array
     */
    abstract public static function apply(array $order, array $params): array;
}