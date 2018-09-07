<?php

namespace App;

use Slim;

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
        $this->config();
        $this->app = new \Slim\App([
            'settings' => $this->config['slim'],
        ]);

        $this->init();
    }

    /** run SlimApp */
    public function run(): void
    {
        $this->app->run();
    }

    protected function init(): void
    {
        $this->twig();
        $this->routes();
    }

    protected function twig(): void
    {
        $container = $this->app->getContainer();
        $container['view'] = function ($c) {
            $view = new \Slim\Views\Twig(__DIR__ . '/../templates/');
            $router = $c->get('router');
            $uri = \Slim\Http\Uri::createFromEnvironment(new \Slim\Http\Environment($_SERVER));
            $view->addExtension(new \Slim\Views\TwigExtension($router, $uri));

            return $view;
        };
    }
    /** create routes */
    protected function routes(): void
    {
        $this->app->get('/', function ($request, $response, $args) {
            return $this->view->render($response, 'Hello.twig');
        });
    }

    protected function config(): void
    {
        $configDir = __DIR__ . '/../config';
        $configFiles = [
            'system.php',
            'user.php',
        ];

        $config = [
            'slim' => [],
        ];

        foreach ($configFiles as $configFile) {
            if (file_exists($configDir . $configFile)) {
                $config = array_merge_recursive(
                    $config,
                    require $configDir . $configFile
                );
            }
        }

        $this->config = $config;
    }
}
