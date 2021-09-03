<?php

namespace AppBundle\Twig;

class WhatPageExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('whatpage', array($this, 'whatPageFilter')),
        );
    }

    public function whatPageFilter($routename)
    {
        $routes = explode("_", $routename);

        if(empty($routes)){
            return $routename;
        } else {
            return $routes[0];
        }
    }

    public function getName()
    {
        return 'app_extension';
    }
}