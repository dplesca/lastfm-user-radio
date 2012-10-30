<?php
require_once __DIR__.'/../vendor/autoload.php';
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
require_once __DIR__.'/../vendor/config.php';

$app->get('/', function () use ($app) {
    return $app['twig']->render('index.twig', array());
});

$app->post('/start', function (Request $request) use ($app) {
	for($i = 0;$i <= 9;$i++){
		$tracks = util::getSearchString($request->get('username'), $app['api_key'], $app['endpoint']);	
		foreach ($tracks['tracks']['feed']['entry'] as $key => $value) {

			$track_title = 	$tracks['tracks']['feed']['entry'][$key]['title']['$t'];
			$guid = str_replace(':', '', strrchr($tracks['tracks']['feed']['entry'][$key]['id']['$t'], ':'));
			$link = util::getMediaLink($guid);
			if ($link !== false){
				file_put_contents('log', 'Try: ' . $i . ', video: ' . $key . ' ' . $track_title . ', search string: ' . $tracks['search_string'] .PHP_EOL , FILE_APPEND);
				echo json_encode( array('title' => $track_title, 'url' => $link) );exit;
			}
		}
	}
});

$app->run();