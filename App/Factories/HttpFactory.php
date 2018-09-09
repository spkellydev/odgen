<?php

namespace App\Factories;

use App\Factory;

class HttpFactory extends Factory
{
    public function __construct(&$container, $name)
    {
        parent::__construct($container, $name, $this->loader());
    }

    protected function loader()
    {
        return function ($c) {
            return function ($request, $response) use ($c) {
                return $response->withRedirect('/404');
            };
        };
    }
}
