<?php

namespace PHPMaker2025\pssk2025;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Symfony\Component\Routing\Attribute\Route;

class UjianTahapBersamaController extends ControllerBase
{
    // list
    #[Route("/ujiantahapbersamalist[/{id_utb:.*}]", methods: ["GET", "POST", "OPTIONS"], defaults: ["middlewares" => [PermissionMiddleware::class, AuthenticationMiddleware::class]], name: "list.ujian_tahap_bersama")]
    public function list(Request $request, Response &$response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "UjianTahapBersamaList");
    }

    // add
    #[Route("/ujiantahapbersamaadd[/{id_utb:.*}]", methods: ["GET", "POST", "OPTIONS"], defaults: ["middlewares" => [PermissionMiddleware::class, AuthenticationMiddleware::class]], name: "add.ujian_tahap_bersama")]
    public function add(Request $request, Response &$response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "UjianTahapBersamaAdd");
    }

    // view
    #[Route("/ujiantahapbersamaview[/{id_utb:.*}]", methods: ["GET", "POST", "OPTIONS"], defaults: ["middlewares" => [PermissionMiddleware::class, AuthenticationMiddleware::class]], name: "view.ujian_tahap_bersama")]
    public function view(Request $request, Response &$response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "UjianTahapBersamaView");
    }

    // edit
    #[Route("/ujiantahapbersamaedit[/{id_utb:.*}]", methods: ["GET", "POST", "OPTIONS"], defaults: ["middlewares" => [PermissionMiddleware::class, AuthenticationMiddleware::class]], name: "edit.ujian_tahap_bersama")]
    public function edit(Request $request, Response &$response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "UjianTahapBersamaEdit");
    }

    // delete
    #[Route("/ujiantahapbersamadelete[/{id_utb:.*}]", methods: ["GET", "POST", "OPTIONS"], defaults: ["middlewares" => [PermissionMiddleware::class, AuthenticationMiddleware::class]], name: "delete.ujian_tahap_bersama")]
    public function delete(Request $request, Response &$response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "UjianTahapBersamaDelete");
    }
}
