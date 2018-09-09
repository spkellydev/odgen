<?php

namespace App\Factories;

use App\Factory;

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
    public static function loader(bool $cache = false)
    {
        return function ($c) {
            if ($cache) {
                $view = new \Slim\Views\Twig(__DIR__ . '/../../templates/', [
                    'cache' => __DIR__ . '/../../cache/',
                ]);
            } else {
                $view = new \Slim\Views\Twig(__DIR__ . '/../../templates/');
            }

            $router = $c->get('router');
            $uri = \Slim\Http\Uri::createFromEnvironment(new \Slim\Http\Environment($_SERVER));
            $view->addExtension(new \Slim\Views\TwigExtension($router, $uri));

            return $view;
        };
    }
}
