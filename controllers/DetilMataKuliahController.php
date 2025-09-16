<?php

namespace PHPMaker2025\pssk2025;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Symfony\Component\Routing\Attribute\Route;

class DetilMataKuliahController extends ControllerBase
{
    // list
    #[Route("/detilmatakuliahlist[/{keys:.*}]", methods: ["GET", "POST", "OPTIONS"], defaults: ["middlewares" => [PermissionMiddleware::class, AuthenticationMiddleware::class]], name: "list.detil_mata_kuliah")]
    public function list(Request $request, Response &$response, array $args): Response
    {
        return $this->runPage($request, $response, $this->getKeyParams($args), "DetilMataKuliahList");
    }

    // add
    #[Route("/detilmatakuliahadd[/{keys:.*}]", methods: ["GET", "POST", "OPTIONS"], defaults: ["middlewares" => [PermissionMiddleware::class, AuthenticationMiddleware::class]], name: "add.detil_mata_kuliah")]
    public function add(Request $request, Response &$response, array $args): Response
    {
        return $this->runPage($request, $response, $this->getKeyParams($args), "DetilMataKuliahAdd");
    }

    // view
    #[Route("/detilmatakuliahview[/{keys:.*}]", methods: ["GET", "POST", "OPTIONS"], defaults: ["middlewares" => [PermissionMiddleware::class, AuthenticationMiddleware::class]], name: "view.detil_mata_kuliah")]
    public function view(Request $request, Response &$response, array $args): Response
    {
        return $this->runPage($request, $response, $this->getKeyParams($args), "DetilMataKuliahView");
    }

    // edit
    #[Route("/detilmatakuliahedit[/{keys:.*}]", methods: ["GET", "POST", "OPTIONS"], defaults: ["middlewares" => [PermissionMiddleware::class, AuthenticationMiddleware::class]], name: "edit.detil_mata_kuliah")]
    public function edit(Request $request, Response &$response, array $args): Response
    {
        return $this->runPage($request, $response, $this->getKeyParams($args), "DetilMataKuliahEdit");
    }

    // delete
    #[Route("/detilmatakuliahdelete[/{keys:.*}]", methods: ["GET", "POST", "OPTIONS"], defaults: ["middlewares" => [PermissionMiddleware::class, AuthenticationMiddleware::class]], name: "delete.detil_mata_kuliah")]
    public function delete(Request $request, Response &$response, array $args): Response
    {
        return $this->runPage($request, $response, $this->getKeyParams($args), "DetilMataKuliahDelete");
    }

    // preview
    #[Route("/detilmatakuliahpreview", methods: ["GET", "OPTIONS"], defaults: ["middlewares" => [PermissionMiddleware::class, AuthenticationMiddleware::class]], name: "preview.detil_mata_kuliah")]
    public function preview(Request $request, Response &$response, array $args): Response
    {
        return $this->runPage($request, $response, $this->getKeyParams($args), "DetilMataKuliahPreview", null, false);
    }

    // Get keys as associative array
    protected function getKeyParams($args)
    {
        global $RouteValues;
        if (array_key_exists("keys", $args)) {
            $sep = Container("detil_mata_kuliah")->RouteCompositeKeySeparator;
            $keys = explode($sep, $args["keys"]);
            if (count($keys) == 2) {
                $keyArgs = array_combine(["id_no","Kode_MK"], $keys);
                $RouteValues = array_merge(Route(), $keyArgs);
                $args = array_merge($args, $keyArgs);
            }
        }
        return $args;
    }
}
