{{-- <!DOCTYPE html>
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
<div class="jc-demo-box">
		This is the image we're attaching Jcrop to
		<img src="{{$image}}" id="cropbox"/>

		This is the form that our event handler fills
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

</html> --}}


 <!DOCTYPE html>
<html lang="en">
<head>
  <title>Basic Handler | Jcrop Demo</title>
  <meta http-equiv="Content-type" content="text/html;charset=UTF-8" />

<script src="js/jquery.min.js"></script>
<script src="js/jquery.Jcrop.js"></script>
<script type="text/javascript">

  jQuery(function($){

    var jcrop_api;

    $('#target').Jcrop({
      onChange:   showCoords,
      onSelect:   showCoords,
      onRelease:  clearCoords,
      boxWidth: 500,
      aspectRatio: 1
    },function(){
      jcrop_api = this;
    });

    $('#coords').on('change','input',function(e){
      var x1 = $('#x1').val(),
          x2 = $('#x2').val(),
          y1 = $('#y1').val(),
          y2 = $('#y2').val();
      jcrop_api.setSelect([x1,y1,x2,y2]);
    });

  });

  // Simple event handler, called from onChange and onSelect
  // event handlers, as per the Jcrop invocation above
  function showCoords(c)
  {
    $('#x1').val(c.x);
    $('#y1').val(c.y);
    $('#x2').val(c.x2);
    $('#y2').val(c.y2);
    $('#w').val(c.w);
    $('#h').val(c.h);
  };

  function clearCoords()
  {
    $('#coords input').val('');
  };



</script>
  <link rel="stylesheet" href="css/main.css" type="text/css" />
  <link rel="stylesheet" href="css/demos.css" type="text/css" />
  <link rel="stylesheet" href="css/jquery.Jcrop.css" type="text/css" />

</head>
<body>

<div class="container">
<div class="row">
<div class="span12">
<div class="jc-demo-box">

<div class="page-header">

<h1>Click and Drag</h1>
<h1>To select your prefer area</h1>
</div>

  <img src="{{$image}}" id="target" alt="[Jcrop Example]" />

  <form action="corpFinish" method="post" onsubmit="return checkCoords();">
      <input type="hidden" name="_token" value="{{ csrf_token() }}">
      <input type="hidden" id="x1" name="x" />
      <input type="hidden" id="y1" name="y" />
      <input type="hidden" id="w" name="w" />
      <input type="hidden" id="h" name="h" />
      <input type="hidden" id="JigsawName" name="JigsawName" value="{{$JigsawName}}"/>
      <input type="submit" value="Crop Image" class="btn btn-large btn-inverse" />
  </form>

  

<div class="clearfix"></div>

</div>
</div>
</div>
</div>

</body>
</html>