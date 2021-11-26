<?php namespace App\Controllers;

use Slim\Psr7\Request;
use Slim\Psr7\Response;
use App\Libraries\Ticktacktock\Ticktacktock;
use App\Libraries\RespPretty;

class Game{

	public function new($request, $response, $arg){

		// Get the body
			$body = $request->getParsedBody();

		// Call the game
			$ttt = new Ticktacktock;
			$rest = $ttt->new($body["name"]);

		return RespPretty::send($rest, $response);
	}

	public function join_game($request, $response, $arg){

		/* MAGIC: Como no tenemos sql/mongo/files, uso una función temporal */
			$last_game = $this->magic(1);
	
		// Get the body
			$body = $request->getParsedBody();

		$ttt = new Ticktacktock;
		$rest = $ttt->join_game($body["name"], $last_game);

		return RespPretty::send($rest, $response);

	}


	public function move($request, $response, $arg){

		/* MAGIC: Como no tenemos sql/mongo/files, uso una función temporal */
		$last_game = $this->magic(2);
	
		// Get the body
			$body = $request->getParsedBody();

			$ttt = new Ticktacktock;
			$rest = $ttt->move($body["name"], $body["square"], $last_game);

			return RespPretty::send($rest, $response);

	}

	private function magic($number=1){

		if($number === 1){
			$ttt = new Ticktacktock;
			return $ttt->new("Ana");
		}

		if($number === 2){
			$ttt = new Ticktacktock;
			$rest = $ttt->new("Ana");
			$rest = $ttt->join_game("Carla", $rest);
			$rest = $ttt->move("Ana", "A1", $rest);
			$rest = $ttt->move("Carla", "A2", $rest);
			$rest = $ttt->move("Ana", "B1", $rest);
			return $ttt->move("Carla", "B2", $rest);
		}

	}


}