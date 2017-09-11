<?php
/**
 * Condition test file
 * 
 * @category Tests
 * @author   Pieterjan Fiers <pjfiers@gmail.com>
 * @version  0.1
 */

use App\Condition;

/**
 * Condition test class
 * 
 * @category Tests
 * @author   Pieterjan Fiers <pjfiers@gmail.com>
 * @version  0.1
 */
class ConditionTest extends TestCase
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
     * Test if fetching all conditions in db works
     *
     * @return void
     */
    public function testGetAllConditions()
    {
        $this->assertInternalType(
            'array',
            Condition::all()
        );
    }

    /**
     * Test if all items in collection are Condition objects
     *
     * @return void
     */
    public function testGetAllConditionsAreObjects()
    {
        $this->assertContainsOnly(
            'App\Condition',
            Condition::all()
        );
    }

    /**
     * Test if all objects in collection have the required attributes
     *
     * @return void
     */
    public function testGetAllConditionsObjectsHaveAttributes()
    {
        $allConditions = Condition::all();
        foreach ($allConditions as $oneCondition) {
            $this->assertObjectHasAttribute(
                'id',
                $oneCondition
            );
            $this->assertObjectHasAttribute(
                'condition_params',
                $oneCondition
            );
            $this->assertObjectHasAttribute(
                'reduction',
                $oneCondition
            );
            $this->assertObjectHasAttribute(
                'discount_params',
                $oneCondition
            );
        }
    }

    /**
     * Test if all conditions from DB have assert methods
     *
     * @return void
     */
    public function testCanAssertAllDbConditions()
    {
        $allConditions = Condition::all();
        foreach ($allConditions as $condition) {
            $condition = $this->convertObjectToArray($condition);
            $className = '\\App\\Conditions\\' . $condition['id'];
            $this->assertNotNull(
                $className::assert(
                    $this->sampleOrder,
                    $condition['condition_params']
                )
            );
        }
    }

    /**
     * Test if a condition can fail
     *
     * @return void
     */
    public function testCanAssertConditionFail()
    {
        $className = '\\App\\Conditions\\ProductBelongsToCategory';
        $orderShouldFail = [
            "id" => "1",
            "customer-id" => "1",
            "items" => [
                [
                    "product-id" => "A101",
                    "quantity" => "2",
                    "unit-price" => "9.75",
                    "total" => "19.50"
                ]
            ]
        ];
        $this->assertEquals(
            false,
            $className::assert(
                $orderShouldFail,
                [
                    "category" => "2"
                ]
            )
        );
    }

    /**
     * Test a condition to succeed
     *
     * @return void
     */
    public function testCanAssertConditionSuccess()
    {
        $className = '\\App\\Conditions\\ProductBelongsToCategory';
        $orderShouldSucceed = [
            "id" => "1",
            "customer-id" => "1",
            "items" => [
                [
                    'product-id' => 'B102',
                    'quantity' => '10',
                    'unit-price' => '4.99',
                    'total' => '49.90' 
                ]
            ]
        ];
        $this->assertNotEquals(
            false,
            $className::assert(
                $orderShouldSucceed,
                [
                    "category" => "2"
                ]
            )
        );
    }
}
