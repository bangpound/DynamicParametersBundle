<?php

namespace Incenteev\DynamicParametersBundle\Tests;

use Incenteev\DynamicParametersBundle\ParameterRetriever;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;

class ParameterRetrieverTest extends \PHPUnit_Framework_TestCase
{
    public function testMissingEnvVar()
    {
        $container = $this->getMock('Symfony\Component\DependencyInjection\ContainerInterface');
        $container->expects($this->once())
            ->method('getParameter')
            ->with('foo')
            ->willReturn('bar');

        $retriever = new ParameterRetriever($container, new ParameterBag(), array('foo' => $this->buildParam()));

        $this->assertSame('bar', $retriever->getParameter('foo'));
    }

    public function testUnknownParameter()
    {
        $container = $this->getMock('Symfony\Component\DependencyInjection\ContainerInterface');
        $container->expects($this->once())
            ->method('getParameter')
            ->with('foo')
            ->willReturn('bar');

        $retriever = new ParameterRetriever($container, new ParameterBag(), array('baz' => $this->buildParam()));

        $this->assertSame('bar', $retriever->getParameter('foo'));
    }

    public function testEnvParameter()
    {
        $container = $this->getMock('Symfony\Component\DependencyInjection\ContainerInterface');
        $container->expects($this->never())
            ->method('getParameter');

        $retriever = new ParameterRetriever($container, new ParameterBag(['foo' => 'bar']), array('foo' => $this->buildParam()));

        $this->assertSame('bar', $retriever->getParameter('foo'));
    }

    public function testYamlParameter()
    {
        $container = $this->getMock('Symfony\Component\DependencyInjection\ContainerInterface');
        $container->expects($this->never())
            ->method('getParameter');

        $retriever = new ParameterRetriever($container, new ParameterBag(['foo' => 'true']), array('foo' => $this->buildParam(true)));

        $this->assertSame(true, $retriever->getParameter('foo'));
    }

    private function buildParam($isYaml = false)
    {
        return array('yaml' => $isYaml);
    }
}
