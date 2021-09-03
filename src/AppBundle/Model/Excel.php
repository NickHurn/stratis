<?php

namespace AppBundle\Model;

class Excel {

    public function __construct()
    {

    }


    public function numbertoLetter($number){
        $letters = array('-','a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z',);

        return $letters[$number];
    }


}
