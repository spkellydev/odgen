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
        return $this->c['view']->render($response, 'Welcome.twig', [
            'token' => $_SESSION['token'],
        ]);
    }

    public function about(Request $request, Response $response, $args)
    {
        return $this->c['view']->render($response, 'pages/About.twig');
    }

    public function contact(Request $request, Response $response, $args)
    {
        return $this->c['view']->render($response, 'pages/Contact.twig');
    }

    public function privacy(Request $request, Response $response, $args)
    {
        return $this->c['view']->render($response, 'pages/Privacy.twig');
    }

    public function notFound(Request $request, Response $response, $args)
    {
        return $this->c['view']->render($response, 'pages/NotFound.twig');
    }
}
