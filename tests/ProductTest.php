<?php
/**
 * Product test file
 * 
 * @category Tests
 * @author   Pieterjan Fiers <pjfiers@gmail.com>
 * @version  0.1
 */


use App\Product;

/**
 * Product test class
 * 
 * @category Tests
 * @author   Pieterjan Fiers <pjfiers@gmail.com>
 * @version  0.1
 */
class ProductTest extends TestCase
{
    /**
     * Test if getting all products works
     *
     * @return void
     */
    public function testGetAllProducts()
    {
        $this->assertInternalType(
            'array',
            Product::all()
        );
    }

    /**
     * Test if all items in products collection are correct object
     *
     * @return void
     */
    public function testGetAllProductsHasObjects()
    {
        $this->assertContainsOnly(
            App\Product::class,
            Product::all()
        );
    }

    /**
     * Test if all Products have correct attributes
     *
     * @return void
     */
    public function testGetAllProductsObjectsHaveAttributes()
    {
        $allProducts = Product::all();
        foreach ($allProducts as $oneProduct) {
            $this->assertObjectHasAttribute(
                'id',
                $oneProduct
            );
            $this->assertObjectHasAttribute(
                'description',
                $oneProduct
            );
            $this->assertObjectHasAttribute(
                'category',
                $oneProduct
            );
            $this->assertObjectHasAttribute(
                'price',
                $oneProduct
            );
        }
    }

    /**
     * Test if Product can be found by it's ID
     *
     * @return void
     */
    public function testFindProductById()
    {
        $testId = "A101";
        $oneProduct = Product::find($testId);

        $this->assertInstanceOf(
            Product::class,
            $oneProduct
        );

        $this->assertEquals(
            $testId,
            $oneProduct->id
        );
    }
}
