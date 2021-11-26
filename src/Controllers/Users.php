<?php namespace App\Controllers;

use Slim\Psr7\Request;
use Slim\Psr7\Response;
use App\Libraries\RespPretty;

class Users{

	public function new($request, $response, $arg){

		// Get the body
			$body = $request->getParsedBody();

		/*
			MAGIC: MONGO, SQL...
		*/
		$respuesta = [ "status"=>true, "ID"=>rand(1,500), "name"=> $body["name"]];

		return RespPretty::send($respuesta, $response);

	}

	public function delete($request, $response, $arg){

		/*
			MAGIC: MONGO, SQL...
		*/
		$respuesta = [ "status"=>true];

		return RespPretty::send($respuesta, $response);

	}

	/*
	No solicitados en el requerimiento
	*/
		public function get_list($request, $response, $arg){ }

		public function get($request, $response, $arg){ }

		public function update($request, $response, $arg){ }

}