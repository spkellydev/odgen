<?php

namespace App;

use App\Controllers\FormController;
use App\Controllers\InsuranceController;
use App\Controllers\PageController;
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

        $container['notFoundHandler'] = function ($c) {
            return function ($request, $response) use ($c) {
                return $response->withRedirect('/404');
            };
        };
    }
    /** create routes for MVC structure
     * @return void
     */
    protected function routes()
    {
        $this->app->get('/', 'PageController:index');
        $this->app->get('/about', 'PageController:about');
        $this->app->get('/contact', 'PageController:contact');
        $this->app->get('/privacy-policy', 'PageController:privacy');
        $this->app->get('/404', 'PageController:notFound');

        $this->app->get('/insurance', 'InsuranceController:index');
        $this->app->get('/insurance/individual', 'InsuranceController:individual');
        $this->app->get('/insurance/group', 'InsuranceController:group');
        $this->app->get('/insurance/travel', 'InsuranceController:travel');

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

        $container['PageController'] = function ($c) {
            return new PageController($c);
        };

        $container['InsuranceController'] = function ($c) {
            return new InsuranceController($c);
        };

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
