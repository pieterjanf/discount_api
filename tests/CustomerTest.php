<?php
/**
 * Customer tests file
 * 
 * @category Tests
 * @author   Pieterjan Fiers <pjfiers@gmail.com>
 * @version  0.1
 */

use App\Customer;

/**
 * Customer test class
 * 
 * @category Tests
 * @author   Pieterjan Fiers <pjfiers@gmail.com>
 * @version  0.1
 */
class CustomerTest extends TestCase
{
    /**
     * Test if get all customers works
     *
     * @return void
     */
    public function testGetAllCustomers()
    {
        $this->assertInternalType(
            'array',
            Customer::all()
        );
    }

    /**
     * Test if all items in customers collections are Customers
     * 
     * @return void
     */
    public function testGetAllCustomersHasObjects()
    {
        $this->assertContainsOnly(
            Customer::class,
            Customer::all()
        );
    }

    /**
     * Test if all customers have correct attributes
     *
     * @return void
     */
    public function testGetAllCustomersObjectsHaveAttributes()
    {
        $allCustomers = Customer::all();
        foreach ($allCustomers as $oneCustomer) {
            $this->assertObjectHasAttribute(
                'id',
                $oneCustomer
            );
            $this->assertObjectHasAttribute(
                'name',
                $oneCustomer
            );
            $this->assertObjectHasAttribute(
                'since',
                $oneCustomer
            );
            $this->assertObjectHasAttribute(
                'revenue',
                $oneCustomer
            );
        }
    }

    /**
     * Test if a customer can be found by it's ID
     *
     * @return void
     */
    public function testFindCustomerById()
    {
        $testId = "1";
        $oneCustomer = Customer::find($testId);

        $this->assertInstanceOf(
            Customer::class,
            $oneCustomer
        );

        $this->assertEquals(
            $testId,
            $oneCustomer->id
        );
    }
}
