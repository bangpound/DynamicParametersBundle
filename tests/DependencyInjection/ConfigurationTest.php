<?php

namespace Incenteev\DynamicParametersBundle\Tests\DependencyInjection;

use Incenteev\DynamicParametersBundle\DependencyInjection\Configuration;
use Symfony\Component\Config\Definition\Processor;

class ConfigurationTest extends \PHPUnit_Framework_TestCase
{
    public function testValidConfiguration()
    {
        $configs = array(
            array(
                'parameters' => array(
                    'foo' => null,
                    'bar' => array('yaml' => true),
                ),
            ),
            array(
                'parameters' => array(
                    'baz' => null,
                    'foo' => null,
                ),
            ),
        );

        $expected = array(
            'parameters' => array(
                'foo' => array('yaml' => false),
                'bar' => array('yaml' => true),
                'baz' => array('yaml' => false),
            ),
        );

        $this->assertEquals($expected, $this->processConfiguration($configs));
    }

    /**
     * @expectedException \Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     */
    public function testInvalidVariableName()
    {
        $this->processConfiguration(array(array('parameters' => array('foo' => ''))));
    }

    private function processConfiguration(array $configs)
    {
        $processor = new Processor();
        $configuration = new Configuration();

        return $processor->processConfiguration($configuration, $configs);
    }
}
