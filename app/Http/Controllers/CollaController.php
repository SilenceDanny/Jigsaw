<?php

namespace App\Http\Controllers;

use App\Puzzle;

use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CollaController extends Controller
{
	public function Play(Request $request)
	{
		$JigsawName = $request->get('Name');
		$gamemode = $request->get('Mode');
		$puzzle_id = $request->get('ID');
		Storage::disk('public')->delete("/objFolder/".$gamemode."/texture/texture.jpg");
		Storage::disk('public')->copy("/puzzleSource/".$JigsawName."/".$JigsawName.".jpg", "/objFolder/".$gamemode."/texture/texture.jpg");
		Storage::disk('public')->delete("/objFolder/reflact.jpg");
		Storage::disk('public')->copy("/puzzleSource/".$JigsawName."/".$JigsawName.".jpg", "/objFolder/reflact.jpg");
		return view('collatest')->with(['gamemode'=> $gamemode,'puzzle_id' => $puzzle_id]);
	}
}