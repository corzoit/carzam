<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Car;

class CarsControllerTest extends TestCase
{
    /**
     * Testing that the cars API returns no results if a search keyword was not passed
     *
     * @return void
     */
    public function testNoSearchKeyword()
    {
        $this->get('/api/v1/cars')
             ->seeJson(['count' => 0]);
    }

    /**
     * Testing that the cars API can filter using a query string
     *
     * @return void
     */
    public function testWithSearchKeyword()
    {
        //create a new Car entry
        $new_car = factory(Car::class)->create();

        //testing response
        $partial_search = substr($new_car->make, 0, 3);
        $this->get('/api/v1/cars?k='.$partial_search)
             ->seeJson(['make' => $new_car->make]);
    }  
}
