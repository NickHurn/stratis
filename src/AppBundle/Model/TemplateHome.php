<?php

namespace AppBundle\Model;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class TemplateHome extends Controller
{


    public function __construct()
    {

    }

    public function jobBoard()
    {
        $arr = $this->container->getParameter('webPath');
        return $arr;
    }


}
