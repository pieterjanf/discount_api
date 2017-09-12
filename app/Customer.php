<?php
/**
 * Customer Model file
 * 
 * @category Models
 * @author   Pieterjan Fiers <pjfiers@gmail.com>
 * @version  0.1
 */

namespace App;

/**
 * Customer Model class
 * 
 * @category Models
 * @author   Pieterjan Fiers <pjfiers@gmail.com>
 * @version  0.1
 */
class Customer extends JsonModel
{
   /**
    * JSON file name
    *
    * @var string
    */
   protected static $filename = 'customers';
}
