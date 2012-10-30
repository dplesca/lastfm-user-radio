<?php
require_once('util.php');

Orm::configure('mysql:host=127.0.0.1;dbname=radio');
Orm::configure('username', 'radio');
Orm::configure('password', 'j4x7zKUHTuwEFyL7');
Orm::configure('driver_options', array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));


$app = new Silex\Application(); 
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => dirname(__DIR__).'/views',
));

$app['api_key'] = '3b6669beb308ddab699c5584e7f8de21';
$app['endpoint'] = 'http://ws.audioscrobbler.com/2.0/?';