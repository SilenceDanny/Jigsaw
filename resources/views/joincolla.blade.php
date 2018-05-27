<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Puzzle</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
        <style>
            body {
                font-family: Monospace;
                background-color: #202020;
                margin: 0px;
                overflow: hidden;
            }
        </style>
        <?php
            use App\PuzzleRank;
            // use App\Auth;
        ?>
    </head>
    <body>

        <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
        
        <!-- Fonts -->
        <!-- Source Sans Pro -->
        <link href="https://fonts.googleapis.com/css?family=Droid+Serif:400i|Source+Sans+Pro:300,400,600,700" rel="stylesheet">
        
        <!-- CSS -->

        <!-- <link rel="stylesheet" href="css/bootstrap.min.css"> -->
        <!-- Bootstrap CDN -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.5/css/bootstrap.min.css" integrity="sha384-AysaV+vQoT3kOAXZkl02PThvDr8HYKPZhNT5h/CXfBThSRXQ6jW5DO2ekP5ViFdi" crossorigin="anonymous">
        <link rel="stylesheet" href="css/themefisher-fonts.css">
        <link rel="stylesheet" href="css/font-awesome.min.css">
        <link rel="stylesheet" href="css/owl.carousel.css">
        <link rel="stylesheet" href="css/animate.css">
        <link rel="stylesheet" href="css/style.css">
        <!-- Responsive Stylesheet -->
        <link rel="stylesheet" href="css/responsive.css">

        <script type="text/javascript"
            src="{{ URL::asset('js/threejs/three.js') }}"></script>
            {{-- threejs核心库 --}}

        <script type="text/javascript"
            src="{{ URL::asset('js/threejs/Projector.js') }}"></script>
            {{-- 点选模型最主要的库（raycaster） --}}

        <script type="text/javascript"
            src="{{ URL::asset('js/threejs/CanvasRenderer.js') }}"></script>
            {{-- 渲染器 --}}

        <script type="text/javascript"
            src="{{ URL::asset('js/threejs/DDSLoader.js') }}"></script>
        <script type="text/javascript"
            src="{{ URL::asset('js/threejs/MTLLoader.js') }}"></script>
        <script type="text/javascript"
            src="{{ URL::asset('js/threejs/OBJLoader.js') }}"></script>
            {{-- 导入objmtl用到的三个库 --}}

        <script type="text/javascript"
            src="{{ URL::asset('js/threejs/DragControls.js') }}"></script>
            {{-- 模型拖动 --}}

        <script type="text/javascript"
            src="{{ URL::asset('js/threejs/OrbitControls.js') }}"></script>
            {{-- 视角控制 --}}

        <script type="text/javascript"
            src="{{ URL::asset('http://www.zhangxinxu.com/study/js/zxx.drag.1.0.js') }}"></script>
            {{-- 缩略图拖动插件 --}}
        <script type="text/javascript"
            src="{{ URL::asset('js/jquery.min.js') }}"></script>

        <script type="text/javascript"
            src="{{ URL::asset('js/libs/gameinittool.js') }}"></script>
            




        {{-- 缩略图 --}}
        <style type="text/css">
        #box{position:absolute; padding:5px; background:#3B3F42; font-size:12px;}
         /*-moz-box-shadow:2px 2px 4px #666666; -webkit-box-shadow:2px 2px 4px #666666;*/
        </style>
        <div id="box" style="position: absolute; margin-left: 300px; margin-bottom: 50px;">
            <img src="objFolder/reflact.jpg" alt="" id="reflact" style="width: 300px; height: 300px;background: #3B3F42">
        </div>
        <script type="text/javascript">
            var startreflact = document.getElementById("box");
            var endreflact = document.getElementById("reflact");
            startDrag(endreflact, startreflact);
        </script>

        {{-- 顶端导航栏 --}}
        <div class="container">
            <nav class="navbar navbar-fixed-top  navigation " id="top-nav">
                <ul class="nav navbar-nav menu float-lg-right" id="top-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="#">USER: {{ Auth::user()->name }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                            Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </li>
                </ul>
            </nav>
        </div>
            
        {{-- 侧边栏 --}}
        </div>
        <div id="content">
            <div id="sidebar" style="float: left;width: 200px;height: 1024px;background: #D7DADB;box-shadow: #573544">
                {{-- 计时器 --}}
                <div style="font-size:40px;line-height: 50px;color: #fff;font-weight: 600;background-color: #2C3E50">Timer:</div>
                <div id="dtime" style="font-size:25px;line-height: 50px;color: #fff;font-weight: 400;background-color: #2C3E50">00:00:00</div>

                <div style="font-size:40px;line-height: 50px;color: #fff;font-weight: 600;background-color: #2C3E50">Progress:</div>
                <div id="finishPercentage" style="font-size:25px;line-height: 50px;color: #fff;font-weight: 400;background-color: #2C3E50">NaN/NaN</div>

                <div style="font-size:40px;line-height: 50px;color: #fff;font-weight: 600;background-color: #2C3E50">Penalty:</div>
                <div id="penaltyTime" style="font-size:25px;line-height: 50px;color: #fff;font-weight: 400;background-color: #2C3E50">00:00:00</div>

                <div style="font-size:40px;line-height: 50px;color: #fff;font-weight: 600;background-color: #2C3E50">Rank:</div>
                <?php
                    $rankList =PuzzleRank::where('puzzle_id',$puzzle_id)
                                            ->orderby('time','asc')
                                            ->take(5)
                                            ->get();
                    
                    $rank[0]="1st";
                    $rank[1]="2nd";
                    $rank[2]="3rd";
                    $rank[3]="4th";
                    $rank[4]="5th";
                ?>
                @if(count($rankList)==0)
                    <div style="font-size:20px;line-height: 50px;color: #fff;font-weight: 600;background-color: #2C3E50">NO RECORD !</div>
                @endif
                @for ($i = 0; $i < count($rankList); $i++)
                    <?php
                        $rankHour = 0;
                        $rankMinute = 0;
                        $rankSecond = 0;
                        $rankTime = "";

                        $tempTime = $rankList[$i]->time;
                        $rankHour = floor($tempTime/3600);
                        $rankMinute = floor(($tempTime%3600)/60);
                        $rankSecond = floor($tempTime%60);
                        $rankTime = $rankTime.($rankHour<10?"0".$rankHour:$rankHour);
                        $rankTime = $rankTime.":";
                        $rankTime = $rankTime.($rankMinute<10?"0".$rankMinute:$rankMinute);
                        $rankTime = $rankTime.":";
                        $rankTime = $rankTime.($rankSecond<10?"0".$rankSecond:$rankSecond);
                    ?>
                    <div style="font-size:25px;line-height: 50px;color: #fff;font-weight: 600;background-color: #2C3E50">{{$rank[$i]}}:{{$rankList[$i]->player_name}}</div>
                    <div style="font-size:25px;line-height: 50px;color: #fff;font-weight: 400;background-color: #2C3E50">{{$rankTime}}</div>
                @endfor


                <button id="check" onclick="checkSubmit()">Submit</button>

                <form name="rank" action="saveRank" method="POST" enctype="multipart/form-data" onsubmit="return saveReport();">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input id="Puzzle_id" type="hidden" name="Puzzle_id" value="">
                    <input id="Player_id" type="hidden" name="Player_id" value="">
                    <input id="Player_name" type="hidden" name="Player_name" value="">
                    <input id="Time" type="hidden" name="Time" value="">
                    <button id="rankSubmit" type="submit" disabled="true">Exit Game</button>
                </form>

                

            </div>
        {{-- 拼图场景 --}}
            <div id="main" style="position:absolute;z-index: -1;"></div> 

            <p id="colla_time" hidden></p>


        <script>
            var container, stats;

            var camera, scene, renderer, objects;
            var pointLight;
            var xLength, yLength, OBJMTL_Path;

            // 模式相关参数：25块或100块
            var mode = {{$gamemode}};
            var gameName = "{{$gameName}}";
            var puzzle_id = {{$puzzle_id}};
            var xMarker;
            var zMarker;

            var dragControls;
            var onDrag = null;

            var checkarray = new Array();
            var isFinished = 0;
            var penalty = "";
            var penaltyHH = 0;
            var penaltyMM = 0;
            var penaltySS = 0;
            var gameTime = "";
            var HH = 0;
            var mm = 0;
            var ss = 0;
            // var time;//声明time，此时不能声明称var time = 0
            var jigsaw_progress = new Array();
            var progresscount = 0;
            
            var isTimeChecked = 0;


            var backboard;

            // 存储加入场景模型的数组，便于选择和拖动
            objects = [];


            //协同数据
            var collaData = [];
            var ws = new WebSocket("ws://localhost:8181");
            ws.onopen = function (e) {
                console.log('Connection to server opened');
                joinCollaGame();
            }
            ws.onmessage = function(e){
                tempData = e.data;
                requestData = tempData.split('#');
                //是requestData数组的第四个
                //console.log("协同传过来的time："+time);
                //console.log(requestData[3]);
                //jigsaw_progress = requestData[4];
                // console.log("requestData: "+requestData);
                // console.log("requestData[4]: "+requestData[4].split(","));

                if(requestData[0] == 'J')
                {
                    document.getElementById("colla_time").innerHTML = requestData[3];
                    joinCollaInit(requestData[1],requestData[4]);
                    
                    // console.log(requestData[4]);
                }
                else if(requestData[0] == 'I')
                {
                    // console.log("I de requestData: "+requestData);
                    requestMove(requestData[2],requestData[4]);
                }
            }
            //console.log("外部的时间："+time)

            init();
            animate();

            function init() {

                // 定义场景显示到main div
                container = document.getElementById('main');
                document.body.appendChild(container);

                // 镜头声明
                camera = new THREE.PerspectiveCamera( 45, window.innerWidth / window.innerHeight, 1, 4000 );
                camera.position.set( 0, 800, 0 );//位置(x，y，z)
                camera.lookAt(new THREE.Vector3(0,0,0));

                // 场景声明
                scene = new THREE.Scene();

                // 模型拾取声明，参考raycaster实现
                raycaster = new THREE.Raycaster();
                projector = new THREE.Projector();
                mouse = new THREE.Vector2();

                // 灯光声明
                // 环境光：颜色白色(0xffffff)，强度2
                scene.add( new THREE.AmbientLight( 0xffffff , 2) );

                // 渲染器声明
                renderer = new THREE.WebGLRenderer({antialias: true});
                renderer.setPixelRatio( window.devicePixelRatio );
                renderer.setSize( window.innerWidth, window.innerHeight );
                renderer.setClearColor( 0x615355 );// 背景色设定
                container.appendChild( renderer.domElement );

                // 视角控制声明
                controls = new THREE.OrbitControls( camera, renderer.domElement );
                controls.enableDamping = true; 
                controls.enableRotate = false;
                controls.dampingFactor = 0.25;
                controls.panningMode = THREE.HorizontalPanning; 
                controls.minDistance = 400;
                controls.maxDistance = 3500;
                controls.maxPolarAngle = Math.PI / 4;

                // 鼠标监听事件
                document.addEventListener( 'mouseup', onDocumentMouseUp, false );
                document.addEventListener( 'mousedown', onDocumentMouseDown, false );
                document.addEventListener( 'touchstart', onDocumentTouchStart, false );

                // 拖动控制器声明
                dragControls = new THREE.DragControls( objects, camera, renderer.domElement , onDrag);

                dragControls.addEventListener( 'dragstart', function ( event )
                { 
                    controls.enabled = false; 
                                      
                });

                dragControls.addEventListener( 'dragend', function ( event ) 
                { 
                    controls.enabled = true;
                });


                window.addEventListener( 'resize', onWindowResize, false );
            }


            // 模型导入函数
            function createMtlObj(options){
            //      options={
            //          mtlBaseUrl:"",
            //          mtlPath:"",
            //          mtlFileName:"",
            //          objPath:"",
            //          objFileName:"",
            //          completeCallback:function(object){  
            //          }
            //          progress:function(persent){
            //              
            //          }
            //      }
            THREE.Loader.Handlers.add( /\.dds$/i, new THREE.DDSLoader() );
            var mtlLoader = new THREE.MTLLoader();
            mtlLoader.setPath( options.mtlPath );//设置mtl文件路径
            mtlLoader.load( options.mtlFileName, function( materials ) {
                materials.preload();
                var objLoader = new THREE.OBJLoader();
                objLoader.setMaterials( materials );//设置三维对象材质库
                objLoader.setPath( options.objPath );//设置obj文件所在目录
                objLoader.load( options.objFileName, function ( object ) {
                    if(typeof options.completeCallback=="function"){
                        options.completeCallback(object);

                    }
                }, function ( xhr ) {
                    if ( xhr.lengthComputable ) {
                        var percentComplete = xhr.loaded / xhr.total * 100;
                        if(typeof options.progress =="function"){
                            options.progress( Math.round(percentComplete, 2));
                        }
                    }
                }, function(error){
                });
            });
            }

            function onWindowResize() {

                camera.aspect = window.innerWidth / window.innerHeight;
                camera.updateProjectionMatrix();

                renderer.setSize( window.innerWidth, window.innerHeight );

            }

            function loadImage( path ) {

                var image = document.createElement( 'img' );
                var texture = new THREE.Texture( image, THREE.UVMapping );

                image.onload = function () { texture.needsUpdate = true; };
                image.src = path;

                return texture;
            }

            function onDocumentTouchStart( event ) {

                event.preventDefault();

                event.offsetX = event.touches[0].offsetX;
                event.offsetY = event.touches[0].offsetY;
                onDocumentMouseUp( event );

            }

            function onDocumentMouseUp( event ) {

                event.preventDefault();

                mouse.x = ( event.offsetX / renderer.domElement.clientWidth ) * 2 - 1;
                mouse.y = - ( event.offsetY / renderer.domElement.clientHeight ) * 2 + 1;

                raycaster.setFromCamera( mouse, camera );

                var intersects = raycaster.intersectObjects( objects );
                // console.log(intersects);
                // 网格贴合逻辑
                if ( intersects.length > 0 ) {
                    var target = intersects[ 0 ].object;
                    if(mode%2 == 1)
                    {
                        var marker;
                        for(marker = 0; marker<mode; marker++)
                        {
                            if(target.name.toString() == checkarray[0][marker])
                            {
                                break;
                            }
                        }
                        if(target.position.x > -(side/2*30) && target.position.x < (side/2*30) && target.position.z > -(side/2*30) && target.position.z < (side/2*30))
                        {
                            var positionMarkerX;
                            var positionMarkerZ;

                            checkarray[4][marker] = 1;

                            if(target.position.x >= 0)
                            {
                                positionMarkerX = Math.floor(target.position.x/15);
                                target.position.x = xMarker[positionMarkerX];
                            }
                            else
                            {
                                positionMarkerX = Math.floor(target.position.x/15)+1;
                                target.position.x = -xMarker[-positionMarkerX];
                            }

                            if(target.position.z >= 0)
                            {
                                positionMarkerZ = Math.floor(target.position.z/15);
                                target.position.z = zMarker[positionMarkerZ];
                            }
                            else
                            {
                                positionMarkerZ = Math.floor(target.position.z/15)+1;
                                target.position.z = -zMarker[-positionMarkerZ];
                            }
                        }
                        else
                        {
                            checkarray[4][marker] = 0;
                        }
                    }        
                    else if(mode%2 == 0)
                    {
                        var marker;
                        for(marker = 0; marker<mode; marker++)
                        {
                            if(target.name.toString() == checkarray[0][marker])
                            {
                                break;
                            }
                        }
                        if(target.position.x > -(side/2*30) && target.position.x < (side/2*30) && target.position.z > -(side/2*30) && target.position.z < (side/2*30))
                        {
                            var positionMarkerX;
                            var positionMarkerZ;

                            checkarray[4][marker] = 1;

                            if(target.position.x >= 0)
                            {
                                positionMarkerX = Math.floor(target.position.x/30);
                                target.position.x = xMarker[positionMarkerX];
                            }
                            else
                            {
                                positionMarkerX = Math.floor(target.position.x/30)+1;
                                target.position.x = -xMarker[-positionMarkerX];
                            }

                            if(target.position.z >= 0)
                            {
                                positionMarkerZ = Math.floor(target.position.z/30);
                                target.position.z = zMarker[positionMarkerZ];
                            }
                            else
                            {
                                positionMarkerZ = Math.floor(target.position.z/30)+1;
                                target.position.z = -zMarker[-positionMarkerZ];
                            }
                        }
                        else
                        {
                            checkarray[4][marker] = 0;
                        }
                    }
                    // 平面位置调整，使贴合能更精准
                    target.position.y = 0;


                    for(var p = 0;p<mode;p++)
                    {
                        if(target.name.toString() == checkarray[0][p])
                        {
                            if(target.position.x == checkarray[1][p]&&target.position.z == checkarray[2][p])
                            {
                                checkarray[3][p] = 1;
                            }
                            else
                            {
                                checkarray[3][p] = 0;
                            }
                        }
                    }

                    var moveInfo = target.name+";"+target.position.x+";"+target.position.z;
                    console.log(moveInfo);

                    // moveBlockColla(moveInfo);
                }
            }

            // 实时协同连续性
            function onDocumentMouseDown( event ){
                event.preventDefault();

                mouse.x = ( event.offsetX / renderer.domElement.clientWidth ) * 2 - 1;
                mouse.y = - ( event.offsetY / renderer.domElement.clientHeight ) * 2 + 1;

                raycaster.setFromCamera( mouse, camera );
                var intersects = raycaster.intersectObjects( objects );
                // console.log(intersects);
                if ( intersects.length > 0 ) {
                    console.log("start");
                    
                    onDrag = intersects[ 0 ].object;
                    console.log(onDrag.name+";"+onDrag.position.x+";"+onDrag.position.z);
                } 
            }


            function animate() {

                requestAnimationFrame( animate );
                render();

            }

            function render() {
                controls.update();
                renderer.render( scene, camera );
            }

            //加入协同
            function joinCollaGame(){

                ws.send("J#"+gameName+"#");
            }

            function joinCollaInit(data,now_progress){
                var initData = [];
                tempArr = data.split(',');
                
                for(var i = 0;i<tempArr.length;i++)
                {
                    initData[i] = tempArr[i].split(';');
                }

                // 模式相关参数设定
                xMarker = new Array();
                zMarker = new Array();
                checkarray[0] = new Array();
                checkarray[1] = new Array();
                checkarray[2] = new Array();
                checkarray[3] = new Array();
                checkarray[4] = new Array();
                OBJMTL_Path = mode.toString();
                side = Math.sqrt(mode);
                gameinittool(mode, xMarker, zMarker, checkarray);

                checkarray[4] = now_progress.split(",");

                for(var i = 0;i<checkarray[4].length;i++)
                {
                    checkarray[4][i] = parseInt(checkarray[4][i]);
                }

                var backboardwide = 35*side;
                var backboardtexture = new THREE.TextureLoader().load( "backboard.png" );
                var backboardmaterial = new THREE.MeshBasicMaterial( { map: backboardtexture, transparent: true } );
                backboard = new THREE.Mesh(new THREE.PlaneGeometry(backboardwide,backboardwide), backboardmaterial);
                backboard.position.x = 0;
                backboard.position.z = 0;
                backboard.position.y = -1;
                backboard.rotation.x = -Math.PI/2;
                backboard.side = THREE.DoubleSide;
                scene.add(backboard);

                // 模型导入
                createMtlObj({
                mtlPath: "objFolder/" + OBJMTL_Path + "/",
                mtlFileName: OBJMTL_Path + ".mtl",
                objPath: "objFolder/" + OBJMTL_Path + "/",
                objFileName: OBJMTL_Path + ".obj",
                completeCallback:function(object){
                                object.traverse(function(child) { 
                                    if (child instanceof THREE.Mesh) { 
                                    child.material.side = THREE.DoubleSide;//设置贴图模式为双面贴图                 
                                    child.material.shading=THREE.SmoothShading;//平滑渲染
                                }
                });
                object.emissive=0xffffff;//自发光颜色
                object.ambient=0x00ffff;//环境光颜色
                //      object.rotation.x= 0;//x轴方向旋转角度
                object.position.x = 0;//参考位置坐标X
                object.position.z = 0;//参考位置坐标y
                object.scale.x=1;//缩放级别
                object.scale.y=1;//缩放级别
                object.scale.z=1;//缩放级别

                object.traverse(function(child) {
                                if (child instanceof THREE.Mesh) { 
                                    for(var i = 0;i<initData.length;i++)
                                    {
                                        if(child.name == initData[i][0])
                                        {
                                            child.position.x = initData[i][1];
                                            child.position.z = initData[i][2];
                                        }
                                        objects.push(child);
                                    }
                                }
                });
                scene.add(object);//添加到场景中
                }
                });


            }

            function moveBlockColla(info,jigsaw_progress){
                jigsaw_progress = checkarray[4];
                ws.send("I#"+gameName+"#"+info+"#"+jigsaw_progress.toString()+"#");
            }

            function requestMove(data)
            {
                var tempData = data.split(";")
                console.log(data);
                for(var i=0;i<objects.length;i++)
                {
                    objects[i].traverse(function(child) 
                    { 
                        if (child instanceof THREE.Mesh) 
                        { 
                            if(child.name == tempData[0])
                            {
                                child.position.x = tempData[1];
                                child.position.z = tempData[2];
                                var marker;
                                for(marker = 0; marker<mode; marker++)
                                {
                                    if(child.name.toString() == checkarray[0][marker])
                                    {
                                        break;
                                    }
                                }
                                if(child.position.x > -(side/2*30) && child.position.x < (side/2*30) && child.position.z > -(side/2*30) && child.position.z < (side/2*30))
                                {
                                    checkarray[4][marker] = 1;
                                }
                                else
                                {
                                    checkarray[4][marker] = 0;
                                }
                            }
                            for(var p = 0;p<mode;p++)
                            {
                                if(child.name.toString() == checkarray[0][p])
                                {
                                    if(child.position.x == checkarray[1][p]&&child.position.z == checkarray[2][p])
                                    {
                                        checkarray[3][p] = 1;
                                    }
                                    else
                                    {
                                        checkarray[3][p] = 0;
                                    }
                                }
                            }
                        }
                    });
                }
            }

        {{-- 计时器 --}}
        window.onload = function(){

            var timer = setInterval(function(){
                var start = document.getElementById("colla_time").innerHTML;
                if(start != null && isTimeChecked == 0)
                {
                    var date2 = new Date();
                    // console.log("计时器里的time："+time);
                    // console.log("赋值的start："+start);
                    // console.log("现在的时间date2："+date2);
                    var date3 = Date.parse(date2)/1000-parseInt(start);//Date.parse()函数，表示从这个时间开始到和格林尼治标准时间之间的差时，算出来是毫秒
                    var hours = Math.floor(date3/(3600));
                    var leave1 = date3%(3600);
                    var minutes = Math.floor(leave1/(60));
                    var leave2= leave1%(60);
                    var seconds = Math.floor(leave2);

                    HH = hours;
                    mm = minutes;
                    ss = seconds;
                    gameTime = '';

                    isTimeChecked = 1;
                }
                if(isFinished == 0)
                {
                    gameTime = "";
                    if(++ss==60)
                    {
                        if(++mm==60)
                        {
                            HH++;
                            mm=0;
                        }
                        ss=0;
                    }    
                    gameTime+=HH<10?"0"+HH:HH;
                    gameTime+=":";
                    gameTime+=mm<10?"0"+mm:mm;
                    gameTime+=":";
                    gameTime+=ss<10?"0"+ss:ss;
                }
                
              
                document.getElementById("dtime").innerHTML = gameTime;
                document.getElementById("finishPercentage").innerHTML = checkarray[4].sum() + "/" + mode;
            },1000);
        };

        Array.prototype.sum = function (){
             var result = 0;
             for(var i = 0; i < this.length; i++) {
              result += this[i];
             }
             return result;
        };


        var checkSubmit = function()
        {
            if(checkarray[3].sum() == mode)
            {
                isFinished = 1;
                alert("Success");


                document.getElementById("rankSubmit").disabled = false;

                var totaltime = HH*3600+mm*60+ss+penaltyHH*3600+penaltyMM*60+penaltySS;

                var tmp_puzzle_id = <?php echo $puzzle_id;?>;
                var tmp_player_id = <?php echo Auth::user()->id;?>;
                var tmp_player_name = "<?php echo Auth::user()->name;?>";
                document.getElementById("Puzzle_id").value = tmp_puzzle_id;
                document.getElementById("Player_id").value = tmp_player_id;
                document.getElementById("Player_name").value = tmp_player_name;
                document.getElementById("Time").value = totaltime;

            }
            else
            {
                penaltyCount();
                alert("failed");
                document.getElementById("penaltyTime").innerHTML = penalty;
            }
        }   

        var penaltyCount = function()
        {
                penalty = "";
                penaltySS+=30;
                if(penaltySS>=60)
                {
                    penaltyMM++;
                    if(penaltyMM==60)
                    {
                        penaltyHH++;
                        penaltyMM=0;
                    }
                    penaltySS = penaltySS-60;
                }
                penalty+=penaltyHH<10?"0"+penaltyHH:penaltyHH;
                penalty+=":";
                penalty+=penaltyMM<10?"0"+penaltyMM:penaltyMM;
                penalty+=":";
                penalty+=penaltySS<10?"0"+penaltySS:penaltySS;
        }

        document.getElementById('main').onmousemove = function(event)
        {
            if(onDrag != null)
            {
                var moveInfo = onDrag.name+";"+onDrag.position.x+";"+onDrag.position.z;
                // console.log(moveInfo);

                moveBlockColla(moveInfo);
            }
        }
        </script>
    </body>
</html>