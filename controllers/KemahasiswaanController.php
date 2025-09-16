<?php

namespace PHPMaker2025\pssk2025;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Symfony\Component\Routing\Attribute\Route;

class KemahasiswaanController extends ControllerBase
{
    // list
    #[Route("/kemahasiswaanlist[/{id_kemahasiswaan}]", methods: ["GET", "POST", "OPTIONS"], defaults: ["middlewares" => [PermissionMiddleware::class, AuthenticationMiddleware::class]], name: "list.kemahasiswaan")]
    public function list(Request $request, Response &$response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "KemahasiswaanList");
    }

    // add
    #[Route("/kemahasiswaanadd[/{id_kemahasiswaan}]", methods: ["GET", "POST", "OPTIONS"], defaults: ["middlewares" => [PermissionMiddleware::class, AuthenticationMiddleware::class]], name: "add.kemahasiswaan")]
    public function add(Request $request, Response &$response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "KemahasiswaanAdd");
    }

    // view
    #[Route("/kemahasiswaanview[/{id_kemahasiswaan}]", methods: ["GET", "POST", "OPTIONS"], defaults: ["middlewares" => [PermissionMiddleware::class, AuthenticationMiddleware::class]], name: "view.kemahasiswaan")]
    public function view(Request $request, Response &$response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "KemahasiswaanView");
    }

    // edit
    #[Route("/kemahasiswaanedit[/{id_kemahasiswaan}]", methods: ["GET", "POST", "OPTIONS"], defaults: ["middlewares" => [PermissionMiddleware::class, AuthenticationMiddleware::class]], name: "edit.kemahasiswaan")]
    public function edit(Request $request, Response &$response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "KemahasiswaanEdit");
    }

    // delete
    #[Route("/kemahasiswaandelete[/{id_kemahasiswaan}]", methods: ["GET", "POST", "OPTIONS"], defaults: ["middlewares" => [PermissionMiddleware::class, AuthenticationMiddleware::class]], name: "delete.kemahasiswaan")]
    public function delete(Request $request, Response &$response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "KemahasiswaanDelete");
    }
}
