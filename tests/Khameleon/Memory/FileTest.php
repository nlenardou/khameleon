<?php

namespace Khameleon\Tests\Khameleon\Memory;

class FileTest extends \PHPUnit_Framework_TestCase
{
    private
        $fs;

    public function setUp()
    {
        $this->fs = new \Khameleon\Memory\FileSystem('/');
    }
    
    public function testReadWrite()
    {
        $path = 'path/to/my/file';
        
        $this->assertFalse($this->fs->exists($path), "File <$path> should not exist");
        
        $f = $this->fs->file($path);
        $this->assertTrue($this->fs->exists($path), "File <$path> should have been created");
        $this->assertEmpty($f->read(), "File <$path> should be empty");
        
        $content = "This the file content\n";
        $f->write($content);
        $this->assertNotEmpty($f->read(), "File <$path> should not be empty anymore");
        $this->assertSame($content, $f->read(), "File <$path> should contain the correct content");
        
        $otherFile = $this->fs->file('path/to/other/file');
        $otherFile->write('another content');
        
        $this->assertSame($content, $f->read(), "File <$path> should still contain the same content");
        $this->assertNotSame($content, $otherFile->read(), "Other file should contain another content");
    }
}