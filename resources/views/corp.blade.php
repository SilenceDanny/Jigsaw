<?php

/**
 * Jcrop image cropping plugin for jQuery
 * Example cropping script
 * @copyright 2008-2009 Kelly Hallman
 * More info: http://deepliquid.com/content/Jcrop_Implementation_Theory.html
 */


?><!DOCTYPE html>
<html lang="en">
<head>
  <title>Corpping Picture</title>
  <meta http-equiv="Content-type" content="text/html;charset=UTF-8" />
  <script src="js/jquery.min.js"></script>
  <script src="js/jquery.Jcrop.js"></script>
  <link rel="stylesheet" href="css/main.css" type="text/css" />
  <link rel="stylesheet" href="css/demos.css" type="text/css" />
  <link rel="stylesheet" href="css/jquery.Jcrop.css" type="text/css" />

  <script type="text/javascript"
    src="{{ URL::asset('js/jquery.min.js') }}"></script>
  <script type="text/javascript"
    src="{{ URL::asset('js/jquery.Jcrop.js') }}"></script>


<script type="text/javascript">

  $(function(){

    $('#cropbox').Jcrop({
      aspectRatio: 1,
      onSelect: updateCoords
    });

  });

  function updateCoords(c)
  {
    $('#x').val(c.x);
    $('#y').val(c.y);
    $('#w').val(c.w);
    $('#h').val(c.h);
  };

  function checkCoords()
  {
    if (parseInt($('#w').val())) return true;
    alert('Please select a crop region then press submit.');
    return false;
  };

</script>
<style type="text/css">
  #target {
    background-color: #ccc;
    width: 500px;
    height: 330px;
    font-size: 24px;
    display: block;
  }


</style>

</head>
<body>

<div class="container">
<div class="row">
<div class="span12">
<div class="jc-demo-box" style="width: 500;">
		<!-- This is the image we're attaching Jcrop to -->
		<img src="{{$image}}" id="cropbox"/>

		<!-- This is the form that our event handler fills -->
		<form action="corpFinish" method="post" onsubmit="return checkCoords();">
      <input type="hidden" name="_token" value="{{ csrf_token() }}">
			<input type="hidden" id="x" name="x" />
			<input type="hidden" id="y" name="y" />
			<input type="hidden" id="w" name="w" />
			<input type="hidden" id="h" name="h" />
      <input type="hidden" id="JigsawName" name="JigsawName" value="{{$JigsawName}}"/>
			<input type="submit" value="Crop Image" class="btn btn-large btn-inverse" />
		</form>

	</div>
	</div>
	</div>
	</div>
	</body>

</html>
