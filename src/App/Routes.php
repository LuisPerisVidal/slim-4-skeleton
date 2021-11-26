<?php
	// use Slim\Routing\RouteCollectorProxy;

	$app->group('/v1', function($group){

		// Users
			$group->post('/users/new', 'App\Controllers\Users:new');
			$group->post('/users/delete', 'App\Controllers\Users:delete');
			
			// No solicitadas en los requerimientos
				$group->get('/users/get', 'App\Controllers\Users:get');
				$group->get('/users/get_list', 'App\Controllers\Users:get_list');
				$group->post('/users/update', 'App\Controllers\Users:update');

		// Game
			$group->post('/game/new', 'App\Controllers\Game:new');
			$group->post('/game/join_game', 'App\Controllers\Game:join_game');
			$group->post('/game/move', 'App\Controllers\Game:move');
			
		
		

	});