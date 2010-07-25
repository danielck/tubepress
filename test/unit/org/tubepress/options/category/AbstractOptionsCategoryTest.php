<?php

require_once dirname(__FILE__) . '/../../../../../../classes/org/tubepress/options/category/Embedded.class.php';


abstract class org_tubepress_options_category_AbstractOptionsCategoryTest extends PHPUnit_Framework_TestCase {

    private $_actualNames;
    
    protected abstract function getClassName();
    protected abstract function getExpectedNames();
    
    public function setup()
    {
        $class = new ReflectionClass($this->getClassName());    
        $this->_actualNames = $class->getConstants();
    }

    
    public function testHasRightOptionNames()
    {
        foreach ($this->getExpectedNames() as $expectedName) {
            $this->assertTrue(in_array($expectedName, $this->_actualNames));
        }
    }
    
    public function testHasRightNumberOfOptions()
    {
        $this->assertEquals(sizeof($this->getExpectedNames()), sizeof($this->_actualNames));
    }    

}
?>