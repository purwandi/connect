<?php 

namespace Tests\Controllers;

use Tests\TestCase;

abstract class AbstractControllerTest extends TestCase 
{
    public function setUp()
    {
        parent::setUp();

        $this->app['config']->set('app.key', 'base64:L4V6T8t2fyOvv+00HcB9sJvB15bMYhrKifUSVXtTFqM=');
    }
}