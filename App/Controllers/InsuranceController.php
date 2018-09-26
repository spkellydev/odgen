<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class InsuranceController
{
    private $c = null;

    public function __construct($container)
    {
        $this->c = $container;
    }

    public function index(Request $request, Response $response, $args)
    {
        return $this->c['view']->render($response, 'pages/insurance/Index.twig');
    }

    public function individual(Request $request, Response $response, $args)
    {
        return $this->c['view']->render($response, 'pages/insurance/Individual.twig');
    }

    public function group(Request $request, Response $response, $args)
    {
        return $this->c['view']->render($response, 'pages/insurance/Group.twig');
    }

    public function travel(Request $request, Response $response, $args)
    {
        return $this->c['view']->render($response, 'pages/insurance/Travel.twig');
    }
}
