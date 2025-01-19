<?php
function DIR__URI()
{
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTvPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";

    $host = $_SERVER['HTTP_HOST'];

    $baseDir = explode('/', trim($_SERVER['SCRIPT_NAME'], '/'))[0];
    return $protocol . $host . '/' . $baseDir . '/';
}

define('SITE_URI', DIR__URI());
define('SITE_PATH', dirname(__FILE__));
