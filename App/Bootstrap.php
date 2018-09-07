<?php

namespace App;

use Slim;
use \Psr\Http\Message\ResponseInterface as Response;
use \Psr\Http\Message\ServerRequestInterface as Request;

class Bootstrap
{
    /** @var Slim\App */
    protected $app;

    /** load config from a file
     *  @var array
     */
    protected $config;
    /** create application */
    public function __construct()
    {
        $this->app = new \Slim\App();
        $this->init();
    }

    /** run SlimApp */
    public function run(): void
    {
        $this->app->run();
    }

    protected function init(): void
    {
        // $this->twig();
        $this->routes();
    }

    protected function twig(): void
    {
        $container = $this->app->getContainer();
        $container['view'] = function ($c) {
            $view = new Slim\View\Twig(__DIR__ . '/../views/');
            $view->addExtension(new Slim\View\TwigExtension(
                $c['router'],
                $c['request']->getUri()
            ));
        };
    }
    /** create routes */
    protected function routes(): void
    {
        $this->app->get('/', function (Request $request, Response $response, array $args) {
            return $this->view->render(
                $response,
                'Hello.twig',
                ['name' => 'sean']
            });
        );

    }

}
