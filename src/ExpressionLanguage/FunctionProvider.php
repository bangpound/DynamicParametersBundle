<?php

namespace Incenteev\DynamicParametersBundle\ExpressionLanguage;

use Symfony\Component\ExpressionLanguage\ExpressionFunction;
use Symfony\Component\ExpressionLanguage\ExpressionFunctionProviderInterface;
use Symfony\Component\Yaml\Inline;

class FunctionProvider implements ExpressionFunctionProviderInterface
{
    public function getFunctions()
    {
        return array(
            new ExpressionFunction('dynamic_parameter', function ($paramName) {
                return sprintf('$this->get("%s")->has(%s) ? $this->get("%s")->get(%s) : $this->getParameter(%s)', 'incenteev_dynamic_parameters.parameter_bag', $paramName, 'incenteev_dynamic_parameters.parameter_bag', $paramName, $paramName);
            }, function (array $variables, $paramName) {

                if ($variables['container']->get('incenteev_dynamic_parameters.parameter_bag')->has($paramName)) {
                    $envParam = $variables['container']->get('incenteev_dynamic_parameters.parameter_bag')->get($paramName);

                    return $envParam;
                }

                return $variables['container']->getParameter($paramName);
            }),
            new ExpressionFunction('dynamic_yaml_parameter', function ($paramName) {
                return sprintf('$this->get("%s")->has(%s) ? \Symfony\Component\Yaml\Inline::parse($this->get("%s")->get(%s)) : $this->getParameter(%s)', 'incenteev_dynamic_parameters.parameter_bag', $paramName, 'incenteev_dynamic_parameters.parameter_bag', $paramName, $paramName);
            }, function (array $variables, $paramName) {

                if ($variables['container']->get('incenteev_dynamic_parameters.parameter_bag')->has($paramName)) {
                    $envParam = $variables['container']->get('incenteev_dynamic_parameters.parameter_bag')->get($paramName);

                    return Inline::parse($envParam);
                }

                return $variables['container']->getParameter($paramName);
            }),
        );
    }

}
