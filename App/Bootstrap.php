<?php

namespace App;

use App\Controllers\FormController;
use Slim;
use \Illuminate\Database\Capsule\Manager;

class Bootstrap
{
    /** @var Slim\App */
    protected $app;

    /** load config from a file
     *  @var array
     */
    protected $config;

    /** bootstrap application */
    public function __construct()
    {
        $this->config();
        $this->app = new \Slim\App([
            'settings' => $this->config['slim'],
        ]);

        $this->init();
    }

    /** run SlimApp
     * @return void
     */
    public function run()
    {
        $this->app->run();
    }

    /** intialize project features
     * @return void
     */
    protected function init()
    {
        $container = $this->app->getContainer();
        $capsule = new Manager;
        $capsule->addConnection($container['settings']['db']);

        $capsule->setAsGlobal();
        $capsule->bootEloquent();

        $this->db();
        $this->controllers();
        $this->twig();
        $this->routes();
    }

    /** Service Factory for Twig
     * @return void
     */
    protected function twig()
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
    /** create routes for MVC structure
     * @return void
     */
    protected function routes()
    {
        $this->app->get('/', function ($request, $response, $args) {
            return $this->view->render($response, 'Welcome.twig');
        });

        $this->app->get('/create', 'FormController:index');
    }

    /**
     * Service factory for Eloquent DB ORM
     * @return void
     */
    protected function db()
    {
        $container = $this->app->getContainer();
        $container['db'] = function ($c) use ($capsule) {
            return $capsule;
        };
    }

    protected function controllers()
    {
        $container = $this->app->getContainer();
        $container['FormController'] = function ($c) {
            return new FormController($c);
        };
    }

    /**
     * Base project configurations for development
     * @return void
     */
    protected function config()
    {
        $configDir = __DIR__ . '/../config/';
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
