<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use App\Libraries\Ticktacktock\Ticktacktock;


final class tickTackTockTest extends TestCase{

	public function testNewGame(): void{

		$ttt = new Ticktacktock();

		$rest = $ttt->new("Luis");

		$this->assertEquals( true, $rest["status"] );
	}

	public function testJoinGame(): void{

		$ttt = new Ticktacktock();

		$rest = $ttt->new("Luis");
		$rest = $ttt->join_game("Carlos", $rest);

		$this->assertEquals( true, $rest["status"] );

	}

	public function testJoinGameInFullServer(): void{

		$ttt = new Ticktacktock();

		$rest = $ttt->new("Luis");
		$rest = $ttt->join_game("Carlos", $rest);
		$rest = $ttt->join_game("Maria", $rest);

		// FYI: False because only can to play 2 gamers
		$this->assertEquals( false, $rest["status"] );

	}

	public function testCorrectlyMovement(): void{

		$ttt = new Ticktacktock();

		$rest = $ttt->new("Luis");
		$rest = $ttt->join_game("Carlos", $rest);
		$rest = $ttt->move("Luis", "A1", $rest);


		$this->assertEquals( true, $rest["status"] );

	}


	public function testDetectIncorrectlyMovement(): void{

		$ttt = new Ticktacktock();

		$rest = $ttt->new("Luis");
		$rest = $ttt->join_game("Carlitos", $rest);
		$rest = $ttt->move("Luis", "A6", $rest);

		// FYI: False because the movement is incorrectly
		$this->assertEquals( false, $rest["status"] );

	}


	public function testDetectIncorretTourn(): void{

		$ttt = new Ticktacktock();

		$rest = $ttt->new("Luis");
		$rest = $ttt->join_game("Carlitos", $rest);
		$rest = $ttt->move("Luis", "A1", $rest);
		$rest = $ttt->move("Luis", "A2", $rest);

		$this->assertEquals( false, $rest["status"] );

	}


	public function testDetectWinner(): void{

		$ttt = new Ticktacktock();

		$rest = $ttt->new("Luis");
		$rest = $ttt->join_game("Carlitos", $rest);
		$rest = $ttt->move("Luis", "A1", $rest);
		$rest = $ttt->move("Carlitos", "A2", $rest);
		$rest = $ttt->move("Luis", "B1", $rest);
		$rest = $ttt->move("Carlitos", "B2", $rest);
		$rest = $ttt->move("Luis", "C1", $rest);

		$this->assertEquals( true, $rest["status"] );

	}



}

