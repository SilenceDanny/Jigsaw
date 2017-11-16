<?php

namespace App\Http\Controllers\Corp;

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
      Storage::makeDirectory($JigsawName);
      Storage::disk('public')->makeDirectory($JigsawName);


    	//将图片转化成资源类型(resource)
    	$contents = Storage::get($path);
    	$src_image = imagecreatefromstring($contents);
    	$sourceX =imagesx($src_image);
     	$sourceY =imagesy($src_image);


    // 	/*
		  // 图片裁剪代码：基础裁剪
    // 	*/
    // 	//获取长宽
    // 	$sourceX = imagesx($src_image);
    // 	$sourceY = imagesy($src_image);

    // 	//计算拼图块边长
    // 	$side = max_divisor($sourceX,$sourceY);

    // 	//设置初始变量
    // 	$LUCornerX;//裁剪起始位置x
    // 	$LUCornerY;//裁剪起始位置y
    // 	$PositionX = 1;//图片对应拼图块位置X
    // 	$PositionY = 1;//图片对应拼图块位置Y
    // 	$MaxPositionX = $sourceX/$side;//最大位置X值
    // 	$MaxPositionY = $sourceY/$side;//最大位置Y值
    // 	$CorpWidth = $side;//裁剪宽度
    // 	$CorpHeight = $side;//裁剪高度
    // 	$XCount = $sourceX/$side;//x方向拼图数
    // 	$YCount = $sourceY/$side;//y方向拼图数

    // 	//裁剪过程
    // 	//先行后列
    // 	for($LUCornerX = 0; $LUCornerX < $XCount; $LUCornerX ++)
    // 	{
    //     $PositionY =1;
    // 		for($LUCornerY = 0; $LUCornerY < $YCount; $LUCornerY ++)
    // 		{
    //       //创建分块图
    // 			$dst_image = imagecreatetruecolor($side, $side);

    //       //裁剪单块到分块图中
    // 			imagecopyresampled($dst_image, $src_image, 0, 0, $LUCornerX*$side, $LUCornerY*$side, $side, $side, $side, $side);

    //       //生成位置编号
    // 			$PartName = $PositionX."_".$PositionY;

    //       //输出到指定文件夹
    //       imagepng($dst_image,"../storage/app/".$JigsawName."/".$PartName.".png");

    // 			$PositionY ++;
    // 		}
    //     $PositionX++;
    // 	}



      /*
      凹凸拼图图块裁剪
      主体边长+1/2边长凸起部分

      需要改进，目前是生成可生成的最少块数
      可能需要异步
      */
      //获取长宽
      // $sourceX = imagesx($src_image);
      // $sourceY = imagesy($src_image);

      // //计算拼图块主体边长
      // $side = max_divisor($sourceX, $sourceY);

      // //
      // $realSide = $side*1.5;

      // // //
      // $LUCornerX = -0.25*$side;
      // $LUCornerY = -0.25*$side;
      // $PositionX = 1;//图片对应拼图块位置X
      // $PositionY = 1;//图片对应拼图块位置Y
      // $MaxPositionX = $sourceX/$side;//最大位置X值
      // $MaxPositionY = $sourceY/$side;//最大位置Y值
      // $CorpWidth = $realSide;//裁剪宽度
      // $CorpHeight = $realSide;//裁剪高度
      // $XCount = $sourceX/$side;//x方向拼图数
      // $YCount = $sourceY/$side;//y方向拼图数
      // $ImageData = array();//返回前端的数据集

      // //
      // for($PositionX = 1; $PositionX <= $XCount; $PositionX++)
      // {
      //   $LUCornerY = -0.25*$side;
      //   for ($PositionY = 1; $PositionY <= $YCount ; $PositionY++) 
      //   { 
      //     //
      //     $dst_image = imagecreatetruecolor($realSide, $realSide);

      //     //
      //     imagecopyresampled($dst_image, $src_image, 0, 0, $LUCornerX, $LUCornerY, $realSide, $realSide, $realSide, $realSide);

      //     //生成位置编号
      //     $PartName = $PositionX."_".$PositionY;

      //     //输出到指定文件夹
      //     // imagepng($dst_image,"../storage/app/".$JigsawName."/".$PartName.".png");
      //     imagejpeg($dst_image,"../public/puzzleSource/".$JigsawName."/".$PartName.".jpg");
      //     imagejpeg($src_image,"../public/objFolder/texture/texture.jpg");

      //     //
      //     // array_push($ImageData, "/storage/app/".$JigsawName."/".$PartName.".png");
      //     array_push($ImageData, "puzzleSource/".$JigsawName."/".$PartName.".jpg");

      //     //
      //     $LUCornerY += $side;
      //   }
      //   $LUCornerX += $side;
      // }


      imagejpeg($src_image,"../public/objFolder/".$gamemode."/texture/texture.jpg");
      //
      // return view('puzzle',compact('ImageData'));
      // return view('puzzle')->with('gamemode',$gamemode);
      return view('collatest')->with('gamemode',$gamemode);
    }
}
