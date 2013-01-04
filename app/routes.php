<?php

Route::get('/', function(){
	return View::make('hello');
});

Route::post('user', function()
{
	//do we have the username
	$user = Lastfmuser::where('username', '=', Input::get('username'))->first();
	if (!$user){
		$page = 1;
	} else {
		$page = rand(1, $user->tracks_count);
	}	

	$api_url = Config::get('lastfm.endpoint');
	$track_params = array(
		'method' => 'user.gettoptracks',
		'user' => Input::get('username'),
		'api_key' => Config::get('lastfm.api_key'),
		'limit' => '1',
		'format' => 'json',
		'page' => $page
	);

	$request = Requests::get( $api_url . http_build_query($track_params, '', '&') );
	$track = json_decode($request->body, true);
	$track_title = $track['toptracks']['track']['artist']['name'] . ' ' . $track['toptracks']['track']['name'];

	if (!$user){
		$user = Lastfmuser::create(array('username' => $track['toptracks']['@attr']['user'], 'tracks_count' => $track['toptracks']['@attr']['total']));
	}

	//looking for the track	
	$search_params = array(
		'q' => $track_title,
		'max-results' => 1,
		'fields' => 'entry(id,title)',
		'alt' => 'json',
		//'hd' => 'true',
		'v' => 2
	);
		
	$youtube_search = Requests::get('http://gdata.youtube.com/feeds/api/videos?' . http_build_query($search_params, '', '&'));
	$youtube_video = json_decode($youtube_search->body, true);
	$youtube_guid = preg_match_all('/video:([a-zA-Z0-9_-]{11})/', $youtube_video['feed']['entry'][0]['id']['$t'], $matches, PREG_PATTERN_ORDER);
	
	$result = array(
		'track_name' => $track['toptracks']['track']['artist']['name'] . ' - ' . $track['toptracks']['track']['name'],
		'guid' => $matches[1][0]
	);

	echo json_encode($result);
	
});