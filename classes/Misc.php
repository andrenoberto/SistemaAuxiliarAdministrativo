<?php

class Misc
{
    public function __construct()
    {
    }

    public static function getURI()
    {
        return "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    }
}