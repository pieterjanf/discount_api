<?php
/**
 * Product Model file
 * 
 * @category Models
 * @author   Pieterjan Fiers <pjfiers@gmail.com>
 * @version  0.1
 */

namespace App;

/**
 * Product Model class
 * 
 * @category Models
 * @author   Pieterjan Fiers <pjfiers@gmail.com>
 * @version  0.1
 */
class Product extends JsonModel
{
   /**
    * JSON file name
    *
    * @var string
    */
   protected static $filename = 'products';
}
