<?php

namespace App;

class Factory
{
    protected $container;
    protected function __construct(&$container, $name, $cb)
    {
        $this->container = &$container;
        $this->name = $name;
        $this->init($cb);
    }

    protected function init($cb)
    {
        // set container name and applicable callback function
        $this->container[$this->name] = $cb;
    }
}
