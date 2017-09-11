<?php
/**
 * Abstract conditions file
 * 
 * @category Conditions
 * @author   Pieterjan Fiers <pjfiers@gmail.com>
 * @version  0.1
 */

namespace App\Conditions;

/**
 * Abstract conditions test class
 * 
 * A condition asserts if an item within an order 
 * can be applied, and what Discount should be applied
 * 
 * @category Conditions
 * @author   Pieterjan Fiers <pjfiers@gmail.com>
 * @version  0.1
 */
abstract class AbstractCondition
{
    /**
     * Required params
     * 
     * These parameters fine-tune the condition
     *
     * @var array
     */
    protected static $params = [];

    /**
     * Validate if required params are in payload
     *
     * @param array $params Parameters passed to condition
     * 
     * @return void
     */
    final static function validate(array $params)
    {
        if (static::$params !== array_keys($params)) {
            throw new \Exception('Insufficient parameters.');
        }
    }

    /**
     * Assert if condition applies
     *
     * @param array $order  Order to check
     * @param array $params Params of the condition
     * 
     * @return void
     */
    abstract public static function assert(array $order, array $params);
}