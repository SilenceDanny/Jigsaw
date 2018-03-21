<?php

namespace App\Http\Controllers;

use App\Puzzle;

use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CollaController extends Controller
{
	public function CreateGame(Request $request)
	{
		$JigsawName = $request->get('Name');
		$gamemode = $request->get('Mode');
		$puzzle_id = $request->get('ID');
		$gameName = $request->get('gameName');
		Storage::disk('public')->delete("/objFolder/".$gamemode."/texture/texture.jpg");
		Storage::disk('public')->copy("/puzzleSource/".$JigsawName."/".$JigsawName.".jpg", "/objFolder/".$gamemode."/texture/texture.jpg");
		Storage::disk('public')->delete("/objFolder/reflact.jpg");
		Storage::disk('public')->copy("/puzzleSource/".$JigsawName."/".$JigsawName.".jpg", "/objFolder/reflact.jpg");
		return view('createcolla')->with(['gamemode'=> $gamemode,'puzzle_id' => $puzzle_id,'gameName' => $gameName]);
	}

	public function JoinGame(Request $request)
	{
		$gameName = $request->get('gameName');
		$puzzle_id = $request->get('puzzle_id');
		$gamemode = Puzzle::where('puzzle_id',$puzzle_id)->value('mode');
		$JigsawName = Puzzle::where('puzzle_id',$puzzle_id)->value('puzzle_name'); 
		Storage::disk('public')->delete("/objFolder/".$gamemode."/texture/texture.jpg");
		Storage::disk('public')->copy("/puzzleSource/".$JigsawName."/".$JigsawName.".jpg", "/objFolder/".$gamemode."/texture/texture.jpg");
		Storage::disk('public')->delete("/objFolder/reflact.jpg");
		Storage::disk('public')->copy("/puzzleSource/".$JigsawName."/".$JigsawName.".jpg", "/objFolder/reflact.jpg");
		return view('joinColla')->with(['gamemode'=> $gamemode,'puzzle_id' => $puzzle_id,'gameName' => $gameName]);
	}
}