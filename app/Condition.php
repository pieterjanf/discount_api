<?php
/**
 * Condtion Model file
 * 
 * @category Models
 * @author   Pieterjan Fiers <pjfiers@gmail.com>
 * @version  0.1
 */

namespace App;

/**
 * Condtion Model class
 * 
 * @category Models
 * @author   Pieterjan Fiers <pjfiers@gmail.com>
 * @version  0.1
 */
class Condition extends JsonModel
{
    /**
     * JSON file name
     *
     * @var string
     */
    protected static $filename = 'conditions';

    /**
     * Discount ID
     *
     * @var string
     */
    public $id;

    /**
     * Discount name
     *
     * @var string
     */
    public $discount;
}
