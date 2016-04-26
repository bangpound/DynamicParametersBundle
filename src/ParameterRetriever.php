<?php

namespace Incenteev\DynamicParametersBundle;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Yaml\Inline;

class ParameterRetriever
{
    private $container;
    private $parameterBag;
    private $parameterMap;

    public function __construct(ContainerInterface $container, ParameterBagInterface $parameterBag, array $parameterMap)
    {
        $this->container = $container;
        $this->parameterBag = $parameterBag;
        $this->parameterMap = $parameterMap;
    }

    /**
     * @param string $name
     *
     * @return array|string|bool|int|float|null
     */
    public function getParameter($name)
    {
        if (!isset($this->parameterMap[$name])) {
            return $this->container->getParameter($name);
        }

        if (!$this->parameterBag->has($name)) {
            return $this->container->getParameter($name);
        }

        $var = $this->parameterBag->get($name);

        if ($this->parameterMap[$name]['yaml']) {
            return Inline::parse($var);
        }

        return $var;
    }
}
