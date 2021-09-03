<?php

namespace AppBundle\Twig;

class TwigExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('whatpage', array($this, 'whatPageFilter')),
            new \Twig_SimpleFilter('toMd5', array($this, 'toMd5Filter')),
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

    public function toMd5Filter($string)
    {
        return md5($string);
    }

    public function getName()
    {
        return 'app_extension';
    }
}