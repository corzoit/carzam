<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UiControllerTest extends TestCase
{
    /**
     * Basic UI route test
     *
     * @return void
     */
    public function testUiLandingPage()
    {
        //make sure welcome route is in place and showing the right vehicle search page
        $this->visit('/')
             ->see('VEHICLE SEARCH');
    }
}
