<?php
/**
 * Discount test file
 * 
 * @category Tests
 * @author   Pieterjan Fiers <pjfiers@gmail.com>
 * @version  0.1
 */

use App\Discounts;
use App\Condition;

/**
 * Discount test class
 * 
 * @category Tests
 * @author   Pieterjan Fiers <pjfiers@gmail.com>
 * @version  0.1
 */
class DiscountTest extends TestCase
{
     /**
     * Re-usable test order
     *
     * @var array
     */
    private $sampleOrder = [
        'id' => '1',
        'customer-id' => '2',
        'items' => [
            [
                'product-id' => 'B102',
                'quantity' => '10',
                'unit-price' => '4.99',
                'total' => '49.90' 
            ],
            [
                "product-id" => "A101",
                "quantity" => "2",
                "unit-price" => "9.75",
                "total" => "19.50"
            ]
        ],
        'total' => '69.40'
    ];

    /**
     * Convert an stdClass object to an array
     *
     * @param [type] $object Object from DB
     * @return void
     */
    private function convertObjectToArray($object)
    {
        $array = json_decode(json_encode($object), true);
        return $array;
    }

    /**
     * Test if all discount references in conditions db 
     * Have an existing Discount class
     *
     * @return void
     */
    public function testCanAccessDiscountClasses()
    {
        // get discounts from conditions db
        $allConditions = Condition::all();
        $this->assertInternalType(
            'array',
            $allConditions
        );

        $discounts = [];
        // get distinct list of discounts
        foreach ($allConditions as $condition) {
            $discounts[$condition->discount] = true;
        }
        $discounts = array_keys($discounts);
        // access discount classes
        foreach ($discounts as $discount) {
            $className = '\\App\\Discounts\\' . $discount;
            $this->assertTrue(class_exists($className));
        }

        return $allConditions;
    }

    /**
     * Test if discounts can be applied
     *
     * @param array $conditdiscountsions
     * 
     * @depends testCanAccessDiscountClasses
     * 
     * @return void
     */
    public function testCanApplyAllDiscountsToOrders($allConditions)
    {
        foreach ($allConditions as $condition) {
            $className = '\\App\\Discounts\\' . $condition->discount;
            $condition = $this->convertObjectToArray($condition);
            $this->assertInternalType(
                'array',
                $className::apply(
                    $this->sampleOrder,
                    $condition['discount_params']
                )
            );
        }
    }

    /**
     * Test if ProcentToOrderDetail discount works
     *
     * @return void
     */
    public function testApplyTenProcentToOrderTotal()
    {
        $test = (float) $this->sampleOrder['total'] * 0.9;
        $result = \App\Discounts\ApplyProcentToOrderTotal::apply(
            $this->sampleOrder,
            [
                'percentage' => 10
            ]
        );
        $this->assertEquals($test, $result['total']);
    }

    /**
     * Test if 6th of 6 switches in indeed free
     *
     * @return void
     */
    public function testBuySixSwitchesPayFive()
    {
        $simpleOrder = [
            'id' => '1',
            'customer-id' => '2',
            'items' => [
                [
                    'product-id' => 'B102',
                    'quantity' => '5',
                    'unit-price' => '4.99',
                    'total' => '24.95' 
                ]
            ],
            'total' => '24.95'
        ];
        $test = 6; // 5 in order, means one is free
        $result = \App\Discounts\FreeItemForVolume::apply(
            $simpleOrder,
            [
                'amount' => 5,
                'category' => 2
            ]
        );
        $this->assertEquals($test, $result['items'][0]['quantity']);
    }

    /**
     * Test if more than 6 and less than a multitude of 6 
     * still has the correct total
     *
     * @return void
     */
    public function testBuySixSwitchesPayFiveForOverSix()
    {
        $simpleOrder = [
            'id' => '1',
            'customer-id' => '2',
            'items' => [
                [
                    'product-id' => 'B102',
                    'quantity' => '6',
                    'unit-price' => '4.99',
                    'total' => '49.90' 
                ]
            ],
            'total' => '49.90'
        ];
        $test = 7; // 6 in order, means one is free
        $result = \App\Discounts\FreeItemForVolume::apply(
            $simpleOrder,
            [
                'amount' => 5,
                'category' => 2
            ]
        );
        $this->assertEquals($test, $result['items'][0]['quantity']);
    }

    /**
     * Test if an order 12 or more products of the switches category
     * Substracts one for every 6 switches
     *
     * @return void
     */
    public function testBuySixSwitchesPayFiveAppliesMoreThanOnce()
    {
        $simpleOrder = [
            'id' => '1',
            'customer-id' => '2',
            'items' => [
                [
                    'product-id' => 'B102',
                    'quantity' => '11',
                    'unit-price' => '4.99',
                    'total' => '64.87' 
                ]
            ],
            'total' => '64.87'
        ];
        $test = 13; // 11 in order, means two are free
        $result = \App\Discounts\FreeItemForVolume::apply(
            $simpleOrder,
            [
                'amount' => 5,
                'category' => 2
            ]
        );
        $this->assertEquals($test, $result['items'][0]['quantity']);
    }

    /**
     * Test if discount to cheapest product in category works
     *
     * @return void
     */
    public function testApplyTenProcentToCheapest()
    {
        $simpleOrder = [
            'id' => '1',
            'customer-id' => '2',
            'items' => [
                [
                    "product-id" => "A101",
                    "quantity" => "2",
                    "unit-price" => "9.75",
                    "total" => "19.50"
                ],
                [
                    "product-id" => "A102",
                    "quantity" => "1",
                    "unit-price" => "49.50",
                    "total" => "49.50"
                ]
            ],
            'total' => '64.87'
        ];

        $test = [
            "product-id" => "A101",
            "quantity" => "2",
            "unit-price" => "9.75",
            "total" => 17.55
        ];

        $result = \App\Discounts\ApplyProcentToCheapest::apply(
            $simpleOrder,
            [
                'percentage' => 10,
                'category' => 1
            ]
        );
        $this->assertEquals($test, $result['items'][0]);
    }
}
