<?php

namespace Incenteev\DynamicParametersBundle\Tests\DependencyInjection;

use Incenteev\DynamicParametersBundle\DependencyInjection\IncenteevDynamicParametersExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class IncenteevDynamicParametersExtensionTest extends \PHPUnit_Framework_TestCase
{
    public function testLoadEmptyConfig()
    {
        $container = new ContainerBuilder();
        $extension = new IncenteevDynamicParametersExtension();

        $extension->load(array(), $container);

        $this->assertTrue($container->hasParameter('incenteev_dynamic_parameters.parameters'));
        $this->assertSame(array(), $container->getParameter('incenteev_dynamic_parameters.parameters'));

        $this->assertTrue($container->hasDefinition('incenteev_dynamic_parameters.retriever'));
    }

    public function testLoadParameters()
    {
        $container = new ContainerBuilder();
        $extension = new IncenteevDynamicParametersExtension();

        $config = array(
            'parameters' => array(
                'foo' => null,
                'bar' => null,
            ),
        );

        $extension->load(array($config), $container);

        $expected = array(
            'foo' => array('yaml' => false),
            'bar' => array('yaml' => false),
        );

        $this->assertTrue($container->hasParameter('incenteev_dynamic_parameters.parameters'));
        $this->assertSame($expected, $container->getParameter('incenteev_dynamic_parameters.parameters'));
    }
}
