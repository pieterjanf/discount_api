<?php
/**
 * API test file
 * 
 * @category Tests
 * @author   Pieterjan Fiers <pjfiers@gmail.com>
 * @version  0.1
 */

use GuzzleHttp\Client;

/**
 * Api test class
 * 
 * @category Tests
 * @author   Pieterjan Fiers <pjfiers@gmail.com>
 * @version  0.1
 */
class ApiTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->client = new Client([
            'base_uri' => 'http://localhost:8000'
        ]);
    }

    /**
     * Test accessing API
     *
     * @return void
     */
    public function testCanAccessApi()
    {
        $response = $this->client->get('/api/v1/');
        $data = $response->getBody()->getContents();;
        $data = json_decode($data);
        
        $this->assertInstanceOf(
            'stdClass',
            $data
        );

        $this->assertEquals(
            $this->app->version(), $data->version
        );
    }

    /**
     * Test accessing Discount API
     *
     * @return void
     */
    public function testCanAccessDiscountApi()
    {
       
        $response = $this->client->post('/api/v1/discount/');
        $data = $response->getBody()->getContents();
        $data = json_decode($data);
        
        $this->assertInstanceOf(
            'stdClass',
            $data
        );

        $this->assertEquals(
            $data->error,
            'Missing payload'
        );
    }

    public function testGetParsedOrder()
    {
        $sampleOrder = [
            "id" => "1",
            "customer-id" => "1",
            "items" => [
                [
                    "product-id" => "B102",
                    "quantity" => "10",
                    "unit-price" => "4.99",
                    "total" => "49.90"
                ]
            ],
            "total" => "49.90"
        ];
        // send JSON POST
        $response = $this->client->request(
            'post',
            '/api/v1/discount/',
            [
                'json' => $sampleOrder
            ]
        );
        // decode response
        $data = $response->getBody()->getContents();
        $data = json_decode($data);

        $this->assertInstanceOf(
            'stdClass',
            $data
        );
    }

    /**
     * Test an order and it's result via the API
     *
     * @return void
     */
    public function testOrderWithCorrectDiscount()
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
        // send JSON POST
        $response = $this->client->request(
            'post',
            '/api/v1/discount/',
            [
                'json' => $simpleOrder
            ]
        );
        // decode response
        $data = $response->getBody()->getContents();
        $data = json_decode($data, true); // as array

        $this->assertInternalType(
            'array',
            $data
        );
        $this->assertEquals($test, $data['items'][0]['quantity']);
    }
}
