<?php

namespace PHPMaker2025\pssk2025;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Symfony\Component\Routing\Attribute\Route;

class DetilUjianTahapBersamaController extends ControllerBase
{
    // list
    #[Route("/detilujiantahapbersamalist[/{no}]", methods: ["GET", "POST", "OPTIONS"], defaults: ["middlewares" => [PermissionMiddleware::class, AuthenticationMiddleware::class]], name: "list.detil_ujian_tahap_bersama")]
    public function list(Request $request, Response &$response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "DetilUjianTahapBersamaList");
    }

    // add
    #[Route("/detilujiantahapbersamaadd[/{no}]", methods: ["GET", "POST", "OPTIONS"], defaults: ["middlewares" => [PermissionMiddleware::class, AuthenticationMiddleware::class]], name: "add.detil_ujian_tahap_bersama")]
    public function add(Request $request, Response &$response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "DetilUjianTahapBersamaAdd");
    }

    // view
    #[Route("/detilujiantahapbersamaview[/{no}]", methods: ["GET", "POST", "OPTIONS"], defaults: ["middlewares" => [PermissionMiddleware::class, AuthenticationMiddleware::class]], name: "view.detil_ujian_tahap_bersama")]
    public function view(Request $request, Response &$response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "DetilUjianTahapBersamaView");
    }

    // edit
    #[Route("/detilujiantahapbersamaedit[/{no}]", methods: ["GET", "POST", "OPTIONS"], defaults: ["middlewares" => [PermissionMiddleware::class, AuthenticationMiddleware::class]], name: "edit.detil_ujian_tahap_bersama")]
    public function edit(Request $request, Response &$response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "DetilUjianTahapBersamaEdit");
    }

    // delete
    #[Route("/detilujiantahapbersamadelete[/{no}]", methods: ["GET", "POST", "OPTIONS"], defaults: ["middlewares" => [PermissionMiddleware::class, AuthenticationMiddleware::class]], name: "delete.detil_ujian_tahap_bersama")]
    public function delete(Request $request, Response &$response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "DetilUjianTahapBersamaDelete");
    }

    // preview
    #[Route("/detilujiantahapbersamapreview", methods: ["GET", "OPTIONS"], defaults: ["middlewares" => [PermissionMiddleware::class, AuthenticationMiddleware::class]], name: "preview.detil_ujian_tahap_bersama")]
    public function preview(Request $request, Response &$response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "DetilUjianTahapBersamaPreview", null, false);
    }
}
