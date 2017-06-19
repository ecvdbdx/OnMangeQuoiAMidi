<?php

namespace AppBundle\Twig;

class AppExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('httpcat', array($this, 'httpcatFilter')),
        );
    }

    public function httpcatFilter($code)
    {
        $httpcat = "<img src=\"https://http.cat/". $code ."\" />";

        return $httpcat;
    }
}