<?php

use Mockery as m;

class ImageGdTest extends PHPUnit_Framework_Testcase
{
    protected function tearDown()
    {
        m::close();
    }

    public function getDriver()
    {
        return new \Imagine\Gd\Imagine;
    }

    public function testGetSize()
    {
        $resource = imagecreatefromjpeg('public/test.jpg');
        $core = m::mock(new \Imagine\Gd\Image($resource));
        $box = m::mock(new \Imagine\Image\Box(800, 600));
        $core->shouldReceive('getSize')->withAnyArgs()->times(1)->andReturn($box);
        $imagine = m::mock($this->getDriver());
        $image = new \Intervention\Image\Image($imagine);
        $image->setImage($core);

        $this->assertEquals($image->getSize(), $box);
    }

    public function testGetWidth()
    {
        $resource = imagecreatefromjpeg('public/test.jpg');
        $core = m::mock(new \Imagine\Gd\Image($resource));
        $box = m::mock(new \Imagine\Image\Box(800, 600));
        $core->shouldReceive('getSize')->withAnyArgs()->times(1)->andReturn($box);
        $imagine = m::mock($this->getDriver());
        $image = new \Intervention\Image\Image($imagine);
        $image->setImage($core);

        $this->assertEquals(800, $image->getWidth());
    }

    public function testGetHeight()
    {
        $resource = imagecreatefromjpeg('public/test.jpg');
        $core = m::mock(new \Imagine\Gd\Image($resource));
        $box = m::mock(new \Imagine\Image\Box(800, 600));
        $core->shouldReceive('getSize')->withAnyArgs()->times(1)->andReturn($box);
        $imagine = m::mock($this->getDriver());
        $image = new \Intervention\Image\Image($imagine);
        $image->setImage($core);

        $this->assertEquals(600, $image->getHeight());
    }

    public function testMakeFromPath()
    {
        $imagine = m::mock($this->getDriver());
        $imagine->shouldReceive('open')->with('public/test.jpg')->once();
        $image = new \Intervention\Image\Image($imagine);   
        $image = $image->make('public/test.jpg');
        $this->assertInstanceOf('Intervention\Image\Image', $image);
        $this->assertEquals('test.jpg', $image->basename);
        $this->assertEquals('test', $image->filename);
        $this->assertEquals('public', $image->dirname);
        $this->assertEquals('jpg', $image->extension);
    }

    public function testMakeFromBinary()
    {
        $str = file_get_contents('public/test.jpg');
        $imagine = m::mock($this->getDriver());
        $imagine->shouldReceive('load')->with($str)->once();
        $image = new \Intervention\Image\Image($imagine);   
        $image = $image->make($str);
        $this->assertInstanceOf('Intervention\Image\Image', $image);
    }

    public function testMakeFromStreamResource()
    {
        $resource = fopen('public/test.jpg', 'r');
        $imagine = m::mock($this->getDriver());
        $imagine->shouldReceive('read')->with($resource)->once();
        $image = new \Intervention\Image\Image($imagine);   
        $image = $image->make($resource);
        $this->assertInstanceOf('Intervention\Image\Image', $image);
    }

    public function testCanvas()
    {
        # code...
    }

    public function testOpen()
    {
        $imagine = m::mock($this->getDriver());
        $imagine->shouldReceive('open')->with('public/test.jpg')->once();
        $image = new \Intervention\Image\Image($imagine);   
        $image = $image->open('public/test.jpg');
        $this->assertInstanceOf('Intervention\Image\Image', $image);
        $this->assertEquals('test.jpg', $image->basename);
        $this->assertEquals('test', $image->filename);
        $this->assertEquals('public', $image->dirname);
        $this->assertEquals('jpg', $image->extension);
    }
    
    public function testLoad()
    {
        $str = file_get_contents('public/test.jpg');
        $imagine = m::mock($this->getDriver());
        $imagine->shouldReceive('load')->with($str)->once();
        $image = new \Intervention\Image\Image($imagine);   
        $image = $image->load($str);
        $this->assertInstanceOf('Intervention\Image\Image', $image);
    }

    public function testRead()
    {
        $resource = fopen('public/test.jpg', 'r');
        $imagine = m::mock($this->getDriver());
        $imagine->shouldReceive('read')->with($resource)->once();
        $image = new \Intervention\Image\Image($imagine);
        $image = $image->read($resource);
        $this->assertInstanceOf('Intervention\Image\Image', $image);
    }

    
    public function testResize()
    {
        $resource = imagecreatefromjpeg('public/test.jpg');
        $core = m::mock(new \Imagine\Gd\Image($resource));
        $core->shouldReceive('resize')->withAnyArgs()->times(3)->andReturn(m::self());
        $imagine = m::mock($this->getDriver());
        $image = new \Intervention\Image\Image($imagine);
        $image->setImage($core);

        $image->resize(300, null);
        $image->resize(null, 200);
        $image->resize(100, 100);
    }

    public function testWiden()
    {
        $resource = imagecreatefromjpeg('public/test.jpg');
        $core = m::mock(new \Imagine\Gd\Image($resource));
        $core->shouldReceive('resize')->withAnyArgs()->once()->andReturn(m::self());
        $imagine = m::mock($this->getDriver());
        $image = new \Intervention\Image\Image($imagine);
        $image->setImage($core);

        $image->widen(300);
    }

    public function testHeighten()
    {
        $resource = imagecreatefromjpeg('public/test.jpg');
        $core = m::mock(new \Imagine\Gd\Image($resource));
        $core->shouldReceive('resize')->withAnyArgs()->once()->andReturn(m::self());
        $imagine = m::mock($this->getDriver());
        $image = new \Intervention\Image\Image($imagine);
        $image->setImage($core);

        $image->heighten(300);
    }

}
