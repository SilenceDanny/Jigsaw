<?php

namespace App\Http\Controllers;

use App\PuzzleRank;

use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SaveRankController extends Controller
{
	public function SaveRank(Request $request)
	{
		$Puzzle_id = $request->get('Puzzle_id');
		$Player_id = $request->get('Player_id');
		$Player_name = $request->get('Player_name');
		$Time = $request->get('Time');

		$newRank = new PuzzleRank;
		$newRank->puzzle_id = $Puzzle_id;
		$newRank->player_id = $Player_id;
		$newRank->player_name = $Player_name;
		$newRank->time = $Time;
		$newRank->save();
		return view('gameResult')->with('puzzle_id',$Puzzle_id);
	}
}