<?php

namespace PHPMaker2025\pssk2025;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Symfony\Component\Routing\Attribute\Route;

/**
 * dashboard2 controller
 */
class Dashboard2Controller extends ControllerBase
{
    // custom
    #[Route("/dashboard2[/{params:.*}]", methods: ["GET", "POST", "OPTIONS"], defaults: ["middlewares" => [PermissionMiddleware::class, AuthenticationMiddleware::class]], name: "custom.dashboard2")]
    public function custom(Request $request, Response &$response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "Dashboard2");
    }
}
