<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class PageController
{
    private $c = null;

    public function __construct($container)
    {
        $this->c = $container;
    }

    public function index(Request $request, Response $response, $args)
    {
        return $this->c['view']->render($response, 'Welcome.twig');
    }

    public function about(Request $request, Response $response, $args)
    {
        return $this->c['view']->render($response, 'pages/About.twig');
    }
}
