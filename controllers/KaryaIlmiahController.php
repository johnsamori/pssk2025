<?php

namespace PHPMaker2025\pssk2025;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Symfony\Component\Routing\Attribute\Route;

class KaryaIlmiahController extends ControllerBase
{
    // list
    #[Route("/karyailmiahlist[/{Id_karya_ilmiah}]", methods: ["GET", "POST", "OPTIONS"], defaults: ["middlewares" => [PermissionMiddleware::class, AuthenticationMiddleware::class]], name: "list.karya_ilmiah")]
    public function list(Request $request, Response &$response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "KaryaIlmiahList");
    }

    // add
    #[Route("/karyailmiahadd[/{Id_karya_ilmiah}]", methods: ["GET", "POST", "OPTIONS"], defaults: ["middlewares" => [PermissionMiddleware::class, AuthenticationMiddleware::class]], name: "add.karya_ilmiah")]
    public function add(Request $request, Response &$response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "KaryaIlmiahAdd");
    }

    // view
    #[Route("/karyailmiahview[/{Id_karya_ilmiah}]", methods: ["GET", "POST", "OPTIONS"], defaults: ["middlewares" => [PermissionMiddleware::class, AuthenticationMiddleware::class]], name: "view.karya_ilmiah")]
    public function view(Request $request, Response &$response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "KaryaIlmiahView");
    }

    // edit
    #[Route("/karyailmiahedit[/{Id_karya_ilmiah}]", methods: ["GET", "POST", "OPTIONS"], defaults: ["middlewares" => [PermissionMiddleware::class, AuthenticationMiddleware::class]], name: "edit.karya_ilmiah")]
    public function edit(Request $request, Response &$response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "KaryaIlmiahEdit");
    }

    // delete
    #[Route("/karyailmiahdelete[/{Id_karya_ilmiah}]", methods: ["GET", "POST", "OPTIONS"], defaults: ["middlewares" => [PermissionMiddleware::class, AuthenticationMiddleware::class]], name: "delete.karya_ilmiah")]
    public function delete(Request $request, Response &$response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "KaryaIlmiahDelete");
    }
}
