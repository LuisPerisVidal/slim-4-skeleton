<?php namespace App\Libraries\Ticktacktock;

/*$ret = [
	"status" => true,
	"error" => null,
	"state" => ["waiting", "ongoing", "finalized"],
	"players_count" => 1,
	"players" => [],
	"movements" => [],
	"tourn" => ""
];*/


/* INTERFACE */
	interface iGame
	{
		public function new(String $ID_player);
		public function join_game(String $ID_player, Array $game);
		public function move(String $ID_player, String $move, Array $game);
	}


/* CLASS GAME */
class Game{

	protected $states = ["waiting", "ongoing", "finalized"];
	protected $need_players = 2;
	protected $game = [];

	protected function add_player(String $ID_player): Array{

		// Validate the game
			$this->valid_game($this->game);
			if($this->game["status"]==false){ return $this->game; }

		// Check ID_player is valid
			if($this->valid_ID($ID_player) == false){
				$this->game = ["status"=>false, "error"=>"Invalid ID"];
				return $this->game;
			}

		// If the server/game is full
			if($this->game["players_count"] == $this->need_players){
				$this->game = ["status"=>false, "error"=>"the game is complete"];
				return $this->game;
			}

		// Add the new player and add one to the counter
			if($ID_player){
				$this->game["players"][] = $ID_player;
				$this->game["players_count"]++;
			}

		// If is the 'first_player' start the game
			if($this->game["players_count"] == 1){
				$this->game["tourn"] = $ID_player;
			}

		return $this->game;

	}

	protected function change_state(String $new_state): Array{

		// Validate the game
			$this->valid_game($this->game);
			if($this->game["status"]==false){ return $this->game; }

		// Validate the new status is allow
			if( in_array($new_state, $this->states) ){
				$this->game["state"] = $new_state;
				return $this->game;
			}else{
				$this->game = ["status"=>false, "error"=>"Invalid state"];
				return $this->game;
			}

	}

	protected function valid_game(): Array{

		$error = false;

		// Exist Status and is boolean
			if( !in_array($this->game["state"], $this->states) ){ $error = "Incorrect State"; }
			if( !is_bool(@$this->game["status"]) ){ $error = "Incorrect Status"; }
			if( !is_int(@$this->game["players_count"]) ){ $error = "Incorrect Players Count"; }
			if( !is_array(@$this->game["players"]) ){ $error = "Incorrect Players array"; }
			if( !is_array(@$this->game["movements"]) ){ $error = "Incorrect movements"; }

		if( $error !== false){
			$this->game = ["status"=>false, "error"=> $error];
			return $this->game;
		}

		return $this->game;

	}

	protected function change_tourn(): Array{

		// Validate the game
			$this->valid_game($this->game);
			if($this->game["status"]==false){ return $this->game; }

		// Find the next gamer
			$current_player = array_search($this->game["tourn"], $this->game["players"]);
			$count_players = count($this->game["players"])-1;
			if($current_player == $count_players){
				$next_player = 0;
			}else{
				$next_player = $count_players++;
			}

			$this->game["tourn"] = $this->game["players"][$next_player];

			return $this->game;

	}

	// Load and check the $game
	protected function load_game(Array $game): Array{
		$this->game = $game;
		$this->valid_game();
		return $this->game;
	}

	private function valid_ID(String $ID): bool{
	
		if( empty($ID) ){
			return false;
		}else{
			return true;
		}

	}


}
