<?php

namespace App\Factories;

use App\Factory;
use Slim\Http\Environment;
use Slim\Http\Uri;
use Slim\Views\Twig;
use Slim\Views\TwigExtension;

class TwigFactory extends Factory
{
    public function __construct(&$container, $name)
    {
        parent::__construct($container, $name, $this->loader());
    }

    /**
     * Loads the Twig Environment
     * @param bool $cache -- if true, application will cache templates
     */
    public static function loader()
    {
        return function ($c) {
            $view = new Twig(__DIR__ . '/../../templates/');

            $router = $c->get('router');
            $uri = Uri::createFromEnvironment(new Environment($_SERVER));
            $view->addExtension(new TwigExtension($router, $uri));

            return $view;
        };
    }
}
