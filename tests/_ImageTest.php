<?php
/*
class ImageTest extends PHPUnit_Framework_Testcase
{
    public $app;

    protected function setUp()
    {
        $this->app = new \Illuminate\Container\Container;
        $this->app->bind('image', function() {
            $imagine = new \Imagine\Gd\Imagine();
            return new \Intervention\Image\Image($imagine);
        });

        \Intervention\Image\Facades\Image::setFacadeApplication($this->app);
    }

    protected function tearDown()
    {
        
    }

    public function testSomething()
    {
        \Intervention\Image\Facades\Image::open('public/test.jpg')->save('public/yo.jpg');
    }
}

*/