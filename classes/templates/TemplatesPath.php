<?php

class TemplatesPath
{
    public function __construct()
    {
    }

    public static function includeTemplate($templatePath) {
        //include_once("{$_SERVER['DOCUMENT_ROOT']}/templates/{$path}");
        include_once("/templates/{$templatePath}");
    }
}