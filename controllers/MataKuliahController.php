<?php

namespace PHPMaker2025\pssk2025;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Symfony\Component\Routing\Attribute\Route;

class MataKuliahController extends ControllerBase
{
    // list
    #[Route("/matakuliahlist[/{keys:.*}]", methods: ["GET", "POST", "OPTIONS"], defaults: ["middlewares" => [PermissionMiddleware::class, AuthenticationMiddleware::class]], name: "list.mata_kuliah")]
    public function list(Request $request, Response &$response, array $args): Response
    {
        return $this->runPage($request, $response, $this->getKeyParams($args), "MataKuliahList");
    }

    // add
    #[Route("/matakuliahadd[/{keys:.*}]", methods: ["GET", "POST", "OPTIONS"], defaults: ["middlewares" => [PermissionMiddleware::class, AuthenticationMiddleware::class]], name: "add.mata_kuliah")]
    public function add(Request $request, Response &$response, array $args): Response
    {
        return $this->runPage($request, $response, $this->getKeyParams($args), "MataKuliahAdd");
    }

    // view
    #[Route("/matakuliahview[/{keys:.*}]", methods: ["GET", "POST", "OPTIONS"], defaults: ["middlewares" => [PermissionMiddleware::class, AuthenticationMiddleware::class]], name: "view.mata_kuliah")]
    public function view(Request $request, Response &$response, array $args): Response
    {
        return $this->runPage($request, $response, $this->getKeyParams($args), "MataKuliahView");
    }

    // edit
    #[Route("/matakuliahedit[/{keys:.*}]", methods: ["GET", "POST", "OPTIONS"], defaults: ["middlewares" => [PermissionMiddleware::class, AuthenticationMiddleware::class]], name: "edit.mata_kuliah")]
    public function edit(Request $request, Response &$response, array $args): Response
    {
        return $this->runPage($request, $response, $this->getKeyParams($args), "MataKuliahEdit");
    }

    // delete
    #[Route("/matakuliahdelete[/{keys:.*}]", methods: ["GET", "POST", "OPTIONS"], defaults: ["middlewares" => [PermissionMiddleware::class, AuthenticationMiddleware::class]], name: "delete.mata_kuliah")]
    public function delete(Request $request, Response &$response, array $args): Response
    {
        return $this->runPage($request, $response, $this->getKeyParams($args), "MataKuliahDelete");
    }

    // Get keys as associative array
    protected function getKeyParams($args)
    {
        global $RouteValues;
        if (array_key_exists("keys", $args)) {
            $sep = Container("mata_kuliah")->RouteCompositeKeySeparator;
            $keys = explode($sep, $args["keys"]);
            if (count($keys) == 2) {
                $keyArgs = array_combine(["id_mk","Kode_MK"], $keys);
                $RouteValues = array_merge(Route(), $keyArgs);
                $args = array_merge($args, $keyArgs);
            }
        }
        return $args;
    }
}
