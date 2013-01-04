<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>last.fm library radio</title>
	<link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:400,700' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="/css/foundation.min.css" media="all">
	<link rel="stylesheet" href="/css/app.css" media="all">

	<script src="/js/jquery.min.js"></script>
	<script src="/js/jquery.form.js"></script>
	<script src="/js/jwplayer.js"></script>
</head>
<body>
	<header class="row">
		<!-- Basic Needs -->
		<nav class="top-bar">
			<ul>
				<li class="name"><h1><a href="#">last.fm library radio</a></h1></li>
				<li class="toggle-topbar"><a href="#"></a></li>
			</ul>
		</nav>
	</header>

	<div class="row">
		<div class="eight columns">
			<form action="/user" method="post">
				<div class="row collapse">
					<div class="ten mobile-three columns">
						<input type="text" placeholder="last.fm username" name="username" />
					</div>
					<div class="two mobile-one columns">
						<button type="submit" class="success button expand postfix">Play</button>
					</div>
				</div>
				
				
			</form>
			<div class="playing twelve columns">
				
				<div id="playaaaa"></div>
				<div id="title"></div>
				<div class="next">
					<button class="secondary button" id="next">Next &raquo;</button>
				</div>
			</div>
		</div>
	</div>
	<script>
	$(function(){
		var next_song = function(){
			$.post('/user', { 'username' : $('input[name="username"]').val() }, function(api_response){	
				jwplayer('playaaaa').load({file: "http://youtu.be/" + api_response.guid}).play();
				$('#title').html(api_response.track_name);
			},'json');
		};

		$('form[method="post"]').ajaxForm({
			success: function(response){
				if ( !$('.playing').is(':visible') ){
					$('.playing').show();
				}
				$('#title').html(response.track_name);
				jwplayer("playaaaa").setup({
			        file: "http://youtu.be/" + response.guid,
			        autoplay: true,
			        height: 324,
			        width: 576
			    }).play();
				jwplayer("playaaaa").onComplete( function(){					
					$.post('/user', { 'username' : $('input[name="username"]').val() }, function(api_response){	
						jwplayer('playaaaa').load({file: "http://youtu.be/" + api_response.guid}).play();
						$('#title').html(api_response.track_name);
					},'json');
				});				
			},
			dataType: 'json'
		});
		$('#next').on('click', next_song);
	});
	</script>
</body>
</html>