<?php

namespace App\Http\Controllers\Corp;

use App\Puzzle;

use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/*
图片裁剪类
目前问题：
1.支持上传的文件大小限制太小，大约1.8M以下，大于该值会报permission deny
*/
class CorpController extends Controller
{
    public function Corp(Request $request)
    {
    	//设置图片名称
    	$imgName = "image@".date("Y.m.d")."&".date("h.i.sa");

    	//获取上传的图片和名称
    	$path = Storage::disk('local')->putFileAs('imageTemp', $request->file('imageSrc'), $imgName.".jpg");
      $JigsawName = $request->get('JigsawName');
      $gamemode = $request->get('gamemode');

      //创建拼图文件夹
      // Storage::makeDirectory($JigsawName);
      Storage::disk('puzzleSource')->makeDirectory($JigsawName);


    	//将图片转化成资源类型(resource)
    	$contents = Storage::get($path);
    	$src_image = imagecreatefromstring($contents);
    	$sourceX =imagesx($src_image);
     	$sourceY =imagesy($src_image);


      imagejpeg($src_image,"../public/objFolder/".$gamemode."/texture/texture.jpg");
      imagejpeg($src_image,"../public/objFolder/reflact.jpg");
      imagejpeg($src_image,"../public/puzzleSource/".$JigsawName."/".$JigsawName.".jpg");

      $puzzle = new Puzzle;
      $puzzle->owner_id = Auth::user()->id;
      $puzzle->owner_name = Auth::user()->name;
      $puzzle->puzzle_name = $JigsawName;
      $puzzle->path = "/puzzleSource/".$JigsawName."/".$JigsawName.".jpg";
      $puzzle->mode = $mode;
      $puzzle->save();
      //
      // return view('puzzle',compact('ImageData'));
      return view('puzzle')->with('gamemode',$gamemode);
      // return view('collatest')->with('gamemode',$gamemode);
    }
}
