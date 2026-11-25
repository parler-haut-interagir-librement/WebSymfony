<?php

declare(strict_types=1);

use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return static function (RoutingConfigurator $routingConfigurator): void {
    // The routes of the EasyAdmin dashboards and their CRUD controllers.
    $routingConfigurator->import('.', 'easyadmin.routes');
};
