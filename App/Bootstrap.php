<?php

namespace App;

use App\Controllers\FormController;
use App\Controllers\InsuranceController;
use App\Controllers\PageController;
use App\Factories\HttpFactory;
use App\Factories\TwigFactory;
use Slim\App;
use \Illuminate\Database\Capsule\Manager;

class Bootstrap
{
    /** @var Slim\App */
    protected $app;

    /** load config from a file
     *  @var array
     */
    protected $config;

    protected $container;

    /** bootstrap application */
    public function __construct()
    {
        $this->config();
        $this->app = new App([
            'settings' => $this->config['slim'],
        ]);

        $this->container = $this->app->getContainer();

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
        $this->capsule = new Manager;
        $this->capsule->addConnection($this->container['settings']['db']);
        $this->capsule->setAsGlobal();
        $this->capsule->bootEloquent();

        $this->db();
        $this->http();
        $this->controllers();
        $this->twig();
        $this->routes();
    }

    /** Service Factory for Twig
     * @return void
     */
    protected function twig()
    {
        new TwigFactory($this->container, 'view');
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
        $this->app->get('/thank-you', 'PageController:thankYou');
        $this->app->get('/404', 'PageController:notFound');

        $this->app->get('/insurance[/]', 'InsuranceController:index');
        $this->app->get('/insurance/individual', 'InsuranceController:individual');
        $this->app->get('/insurance/group', 'InsuranceController:group');
        $this->app->get('/insurance/travel', 'InsuranceController:travel');

        $this->app->get('/api/request', 'FormController:index');
        $this->app->post('/api/create', 'FormController:create');
    }

    /**
     * Service factory for Eloquent DB ORM
     * @return void
     */
    protected function db()
    {
        $capsule = $this->capsule;
        $this->container['db'] = function ($c) use ($capsule) {
            return $capsule;
        };
    }

    /**
     * load controllers into app containers
     * @TODO autoload
     * @return void
     */
    protected function controllers()
    {
        $this->container['PageController'] = function ($c) {
            return new PageController($c);
        };

        $this->container['InsuranceController'] = function ($c) {
            return new InsuranceController($c);
        };

        $this->container['FormController'] = function ($c) {
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

    /**
     * Set application wide http options
     * Example: CORS
     * @return void
     */
    protected function http()
    {
        // create default 404 page
        new HttpFactory($this->container, 'notFoundHandler');

        // add options for all available routes
        $this->app->options('/{routes:.+}', function ($request, $response, $args) {
            return $response;
        });

        // enable CORS
        $this->app->add(function ($req, $res, $next) {
            $response = $next($req, $res);
            return $response
                ->withHeader('Access-Control-Allow-Origin', '*')
                ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
                ->withHeader('Access-Control-Allow-Methods', 'GET, POST');
        });
    }
}
