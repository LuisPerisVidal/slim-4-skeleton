<?php namespace App\Libraries;

Class RespPretty{

	static public function send(Array $data, $response){

		// We can save the response in mongo like log...
		// Or we can check that we response with a 'standar'

		$respuesta = json_encode($data);

		$response->getBody()->write($respuesta);
		$response->withHeader('Content-Type', 'application/json');

		return $response;

	}

}