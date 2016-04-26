<?php

namespace Incenteev\DynamicParametersBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\ConfigurableExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class IncenteevDynamicParametersExtension extends ConfigurableExtension
{
    protected function loadInternal(array $config, ContainerBuilder $container)
    {
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');

        $parameters = $config['parameters'];

        $container->setParameter('incenteev_dynamic_parameters.parameters', $parameters);
    }
}
