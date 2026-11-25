<?php

declare(strict_types=1);

use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return static function (RoutingConfigurator $routingConfigurator): void {
    // The routes of the security layer, the sign-out one among them.
    $routingConfigurator->import('security.route_loader', 'service');
};
