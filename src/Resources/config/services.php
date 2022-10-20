<?php
namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Sebk\SmallLogger\Contracts\SwitchLogicInterface;

return function(ContainerConfigurator $configurator) {
    $services = $configurator->services()
        ->defaults()
        ->autowire(true)
        ->autoconfigure(false)
    ;

    $services->set(\Sebk\SmallLoggerBundle\Service\Logger::class);
};