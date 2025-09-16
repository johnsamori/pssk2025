<?php

namespace PHPMaker2025\pssk2025;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Symfony\Component\Routing\Attribute\Route;

class KesehatanMahasiswaController extends ControllerBase
{
    // list
    #[Route("/kesehatanmahasiswalist[/{Id_kesehatan}]", methods: ["GET", "POST", "OPTIONS"], defaults: ["middlewares" => [PermissionMiddleware::class, AuthenticationMiddleware::class]], name: "list.kesehatan_mahasiswa")]
    public function list(Request $request, Response &$response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "KesehatanMahasiswaList");
    }

    // add
    #[Route("/kesehatanmahasiswaadd[/{Id_kesehatan}]", methods: ["GET", "POST", "OPTIONS"], defaults: ["middlewares" => [PermissionMiddleware::class, AuthenticationMiddleware::class]], name: "add.kesehatan_mahasiswa")]
    public function add(Request $request, Response &$response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "KesehatanMahasiswaAdd");
    }

    // view
    #[Route("/kesehatanmahasiswaview[/{Id_kesehatan}]", methods: ["GET", "POST", "OPTIONS"], defaults: ["middlewares" => [PermissionMiddleware::class, AuthenticationMiddleware::class]], name: "view.kesehatan_mahasiswa")]
    public function view(Request $request, Response &$response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "KesehatanMahasiswaView");
    }

    // edit
    #[Route("/kesehatanmahasiswaedit[/{Id_kesehatan}]", methods: ["GET", "POST", "OPTIONS"], defaults: ["middlewares" => [PermissionMiddleware::class, AuthenticationMiddleware::class]], name: "edit.kesehatan_mahasiswa")]
    public function edit(Request $request, Response &$response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "KesehatanMahasiswaEdit");
    }

    // delete
    #[Route("/kesehatanmahasiswadelete[/{Id_kesehatan}]", methods: ["GET", "POST", "OPTIONS"], defaults: ["middlewares" => [PermissionMiddleware::class, AuthenticationMiddleware::class]], name: "delete.kesehatan_mahasiswa")]
    public function delete(Request $request, Response &$response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "KesehatanMahasiswaDelete");
    }
}
