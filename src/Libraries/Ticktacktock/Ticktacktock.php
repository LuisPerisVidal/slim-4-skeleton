<?php namespace App\Libraries\Ticktacktock;

/*
ORDER USED
  A   B   C
  -   -   - 
| 0 | 1 | 2 | 1
  -   -   - 
| 3 | 4 | 5 | 2
  -   -   - 
| 6 | 7 | 8 | 3
  -   -   - 

Move Format:
	[ "move" => "A1", "player" => $ID_player ]

*/

class Ticktacktock extends Game implements iGame{

	protected $need_players = 2;
	protected $board = ["A1", "A2", "A3", "B1", "B2", "B3", "C1", "C2", "C3"];

	public function new(String $ID_player): Array{
		// The base
			$game = [
				"status" =>true,
				"state" => "waiting",
				"players_count" => 0,
				"players" => [],
				"movements" => []
			];
			$this->load_game($game);


		// Adde the first player
			$this->add_player($ID_player);


		// Check if the name player is correct
			if($this->game["status"] == false){ return $this->game; }

		// Validate and send the game
			return $this->valid_game();

	}

	public function join_game(String $ID_player, Array $game): Array{

		// Load and check the integrity
			$this->load_game($game);
			if($this->game["status"] == false){ return false; }


		// Add the new player (inside validate the array $game)
			$this->add_player($ID_player);
			if($this->game["status"]==false){ return $this->game; }


		// Star the game
			if($this->game["players_count"] == $this->need_players){
				$this->change_state("ongoing");
			}

		return $this->game;

	}

	public function move(String $ID_player, String $move, Array $game): Array{
		// Load the game
			$this->load_game($game);
			if($this->game["status"] == false){ return ["status"=>false, "error"=>""]; }

		// Check state game
			if($this->game["state"] != "ongoing"){ return ["status"=>false, "error"=>"You can't play"]; }

		// Force UpperCase
			$move = strtoupper($move);

		// Check the real tourn
			if(@$this->game["tourn"] != $ID_player){
				return ["status"=>false, "error"=>"It's not your turn"];
			}

		// Checj if the movement is invalid
			if( in_array($move, $this->board) == false ){
				return ["status"=>false, "error"=>"It's a invalid movement"];
			}

		// Check if the square is free
			$free = true;
			foreach ($this->game["movements"] as $value) {
				if($value["move"] == $move){
					$free = false;
				}
			}

			if( $free === false ){
				return ["status"=>false, "error"=>"You can't do it, choose another square"];
			}

		// Add the movement
			$this->game["movements"][] = ["move"=>$move, "player"=>$ID_player];

		// Check if win the game
			if($this->game["movements"] >= 5){
				if( $this->is_the_winner($ID_player) ){

					$this->change_state("finalized");
					$this->game["winner"] = $ID_player;
					return $this->game;

				}
			}

		// Cambia turno
			$this->change_tourn();
			return $this->game;

	}

	private function is_the_winner(String $ID_player){

		$posibilities = ["A1A2A3","B1B2B3","C1C2C3","A1B2C3","A1B1C1","A2B2C2","A3B3C3","A3B2C1"];
		
		$moves_player = [];

		foreach ($this->game["movements"] as $value) {
			if($value["player"] == $ID_player){
				$moves_player[] = $value["move"];
			}
		}

		// Order the movements
			sort($moves_player);

		// Array to string
			$string_movements = implode("", $moves_player);

		// Find the movement
			foreach ($posibilities as $pos) {
				if( strpos($string_movements, $pos) !== false){
					return true;
				}
			}

		return false;

	}

}