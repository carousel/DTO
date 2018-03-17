<?php

use Carousel\DTO\DTOClass;

class DTOTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Set up DTO instance
     * Prepare requst data
     */
    public function setUp()
    {
        $request = [
            'myUsername' => 'Miroslav Trninic',
            'my_timezone' => 'UTC+1',
        ];
        $this->dto = new DTOClass($request);
    }
    /**
     * Check that single input can be camelized
     * @test
     */
    public function singleInputCanBeCamelized()
    {
        $camelized = $this->dto->camelize('my_timezone');
        $this->assertTrue(array_key_exists('myTimezone', $camelized));
    }
    /**
     * Check that single input can be decamelized
     * @test
     */
    public function singleInputCanBeDecamelized()
    {
        $decamelized = $this->dto->decamelize('myUsername');
        $this->assertTrue(array_key_exists('my_username', $decamelized));
    }
    /**
     * Return subset of array input (without selected values)
     *
     * @test
     */
    public function exceptValuesCanBeSelected()
    {
        $except = $this->dto->except(['myUsername']);
        $this->assertFalse(array_key_exists('myUsername', $except));
    }
    /**
     * Return subset of array input (only selected values)
     *
     * @test
     */
    public function onlyValueCanBeSelected()
    {
        $only = $this->dto->only(['myUsername']);
        $this->assertTrue(count($only) == 1);
        $this->assertFalse(array_key_exists('my_timezone', $only));
    }
    /**
     * Return only single value (not modified)
     *
     * @test
     */
    public function singleValueCanBeReturned()
    {
        $this->assertEquals($this->dto->myUsername,'Miroslav Trninic');
    }
    /**
     * Return only single value (not modified)
     *
     * @test
     */
    public function valueCanBeAppended()
    {
        $appended = $this->dto->append(['role' => 'admin']);
        $this->assertTrue(array_key_exists('role', $appended));
    }

}
