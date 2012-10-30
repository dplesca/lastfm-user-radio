<?php
require_once __DIR__.'/../vendor/autoload.php';
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
require_once __DIR__.'/../vendor/config.php';

$app->get('/', function () use ($app) {
    return $app['twig']->render('index.twig', array());
});

$app->post('/start', function (Request $request) use ($app) {
	$track_params = array(
		'method' => 'user.gettoptracks',
		'user' => $request->get('username'),
		'api_key' => $app['api_key'],
		'limit' => '1',
		'format' => 'json'
	);
	$track = file_get_contents( $app['endpoint'] . http_build_query($track_params, '', '&') ); 
	echo '<pre>';print_r($track);die();
});

$app->run();