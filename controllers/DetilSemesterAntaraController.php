<?php

namespace PHPMaker2025\pssk2025;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Symfony\Component\Routing\Attribute\Route;

class DetilSemesterAntaraController extends ControllerBase
{
    // list
    #[Route("/detilsemesterantaralist[/{keys:.*}]", methods: ["GET", "POST", "OPTIONS"], defaults: ["middlewares" => [PermissionMiddleware::class, AuthenticationMiddleware::class]], name: "list.detil_semester_antara")]
    public function list(Request $request, Response &$response, array $args): Response
    {
        return $this->runPage($request, $response, $this->getKeyParams($args), "DetilSemesterAntaraList");
    }

    // add
    #[Route("/detilsemesterantaraadd[/{keys:.*}]", methods: ["GET", "POST", "OPTIONS"], defaults: ["middlewares" => [PermissionMiddleware::class, AuthenticationMiddleware::class]], name: "add.detil_semester_antara")]
    public function add(Request $request, Response &$response, array $args): Response
    {
        return $this->runPage($request, $response, $this->getKeyParams($args), "DetilSemesterAntaraAdd");
    }

    // view
    #[Route("/detilsemesterantaraview[/{keys:.*}]", methods: ["GET", "POST", "OPTIONS"], defaults: ["middlewares" => [PermissionMiddleware::class, AuthenticationMiddleware::class]], name: "view.detil_semester_antara")]
    public function view(Request $request, Response &$response, array $args): Response
    {
        return $this->runPage($request, $response, $this->getKeyParams($args), "DetilSemesterAntaraView");
    }

    // edit
    #[Route("/detilsemesterantaraedit[/{keys:.*}]", methods: ["GET", "POST", "OPTIONS"], defaults: ["middlewares" => [PermissionMiddleware::class, AuthenticationMiddleware::class]], name: "edit.detil_semester_antara")]
    public function edit(Request $request, Response &$response, array $args): Response
    {
        return $this->runPage($request, $response, $this->getKeyParams($args), "DetilSemesterAntaraEdit");
    }

    // delete
    #[Route("/detilsemesterantaradelete[/{keys:.*}]", methods: ["GET", "POST", "OPTIONS"], defaults: ["middlewares" => [PermissionMiddleware::class, AuthenticationMiddleware::class]], name: "delete.detil_semester_antara")]
    public function delete(Request $request, Response &$response, array $args): Response
    {
        return $this->runPage($request, $response, $this->getKeyParams($args), "DetilSemesterAntaraDelete");
    }

    // preview
    #[Route("/detilsemesterantarapreview", methods: ["GET", "OPTIONS"], defaults: ["middlewares" => [PermissionMiddleware::class, AuthenticationMiddleware::class]], name: "preview.detil_semester_antara")]
    public function preview(Request $request, Response &$response, array $args): Response
    {
        return $this->runPage($request, $response, $this->getKeyParams($args), "DetilSemesterAntaraPreview", null, false);
    }

    // Get keys as associative array
    protected function getKeyParams($args)
    {
        global $RouteValues;
        if (array_key_exists("keys", $args)) {
            $sep = Container("detil_semester_antara")->RouteCompositeKeySeparator;
            $keys = explode($sep, $args["keys"]);
            if (count($keys) == 2) {
                $keyArgs = array_combine(["id_smtsr","no"], $keys);
                $RouteValues = array_merge(Route(), $keyArgs);
                $args = array_merge($args, $keyArgs);
            }
        }
        return $args;
    }
}
