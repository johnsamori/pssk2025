<?php

namespace PHPMaker2025\pssk2025;

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->extension('security', Config('SECURITY'));
};
