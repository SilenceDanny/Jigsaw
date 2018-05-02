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

                {{-- <form name="rank" action="saveRank" method="POST" enctype="multipart/form-data"> --}}
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
        </div>

        <script>
            var container, stats;

            var camera, scene, renderer, objects;
            var pointLight;
            var xLength, yLength, OBJMTL_Path;

            // 模式相关参数：25块或100块
            var mode = {{$gamemode}};
            var xMarker;
            var zMarker;

            var check_25 = new Array();
            var check_100 = new Array();
            var isFinished = 0;
            var penalty = "";
            var penaltyHH = 0;
            var penaltyMM = 0;
            var penaltySS = 0;
            var gameTime = "";
            var HH = 0;
            var mm = 0;
            var ss = 0;


            var backboard;
            

            init();
            animate();

            function init() {

                // 定义场景显示到main div
                container = document.getElementById('main');
                document.body.appendChild(container);

                // 镜头声明
                camera = new THREE.PerspectiveCamera( 45, window.innerWidth / window.innerHeight, 1, 4000 );
                camera.position.set( 0, 800, 50 );//位置(x，y，z)

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
                controls.maxDistance = 1000
                controls.maxPolarAngle = Math.PI / 4;

                // 鼠标监听事件
                document.addEventListener( 'mouseup', onDocumentMouseUp, false );
                document.addEventListener( 'touchstart', onDocumentTouchStart, false );

                // 存储加入场景模型的数组，便于选择和拖动
                objects = [];
               
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

            // 模式相关参数设定
            if(mode == 25)
            {
                xLength = 5;
                yLength = 5;
                OBJMTL_Path = "25";
                xMarker = [0,30,30,60,60];
                zMarker = [0,30,30,60,60];
                check_25[0] = ["001","002","003","004","005","006","007","008","009","010","011","012","013","014","015","016","017","018","019","020","021","022","023","024","025"];
                check_25[1] = [-60,-60,-60,-60,-60,-30,-30,-30,-30,-30,0,0,0,0,0,30,30,30,30,30,60,60,60,60,60];
                check_25[2] = [-60,-30,0,30,60,-60,-30,0,30,60,-60,-30,0,30,60,-60,-30,0,30,60,-60,-30,0,30,60];
                check_25[3] = [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0];
                check_25[4] = [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0];

                var backboardtexture = new THREE.TextureLoader().load( "backboard.png" );
                var backboardmaterial = new THREE.MeshBasicMaterial( { map: backboardtexture, transparent: true } );
                backboard = new THREE.Mesh(new THREE.PlaneGeometry(175,175), backboardmaterial);
                backboard.position.x = 0;
                backboard.position.z = 0;
                backboard.position.y = -1;
                backboard.rotation.x = -Math.PI/2;
                backboard.side = THREE.DoubleSide;
                scene.add(backboard);
            }
            else if(mode == 100)
            {
                xLength = 10;
                yLength = 10;
                OBJMTL_Path = "100";
                xMarker = [15,45,75,105,135];
                zMarker = [15,45,75,105,135];
                check_100[0] = ["001","002","003","004","005","006","007","008","009","010","011","012","013","014","015","016","017","018","019","020","021","022","023","024","025","026","027","028","029","030","031","032","033","034","035","036","037","038","039","040","041","042","043","044","045","046","047","048","049","050","051","052","053","054","055","056","057","058","059","060","061","062","063","064","065","066","067","068","069","070","071","072","073","074","075","076","077","078","079","080","081","082","083","084","085","086","087","088","089","090","091","092","093","094","095","096","097","098","099",  "100"];
                check_100[1] = [-135,-135,-135,-135,-135,-135,-135,-135,-135,-135,
                                -105,-105,-105,-105,-105,-105,-105,-105,-105,-105,
                                -75,-75,-75,-75,-75,-75,-75,-75,-75,-75,
                                -45,-45,-45,-45,-45,-45,-45,-45,-45,-45,
                                -15,-15,-15,-15,-15,-15,-15,-15,-15,-15,
                                15,15,15,15,15,15,15,15,15,15,
                                45,45,45,45,45,45,45,45,45,45,
                                75,75,75,75,75,75,75,75,75,75,
                                105,105,105,105,105,105,105,105,105,105,
                                135,135,135,135,135,135,135,135,135,135];
                check_100[2] = [-135,-105,-75,-45,-15,15,45,75,105,135,
                                -135,-105,-75,-45,-15,15,45,75,105,135,
                                -135,-105,-75,-45,-15,15,45,75,105,135,
                                -135,-105,-75,-45,-15,15,45,75,105,135,
                                -135,-105,-75,-45,-15,15,45,75,105,135,
                                -135,-105,-75,-45,-15,15,45,75,105,135,
                                -135,-105,-75,-45,-15,15,45,75,105,135,
                                -135,-105,-75,-45,-15,15,45,75,105,135,
                                -135,-105,-75,-45,-15,15,45,75,105,135,
                                -135,-105,-75,-45,-15,15,45,75,105,135,];
                check_100[3] = [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,
                                0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,
                                0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,
                                0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,
                                0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,];
                check_100[4] = [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,
                                0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,
                                0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,
                                0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,
                                0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,];

                var backboardtexture = new THREE.TextureLoader().load( "backboard.png" );
                var backboardmaterial = new THREE.MeshBasicMaterial( { map: backboardtexture, transparent: true } );
                backboard = new THREE.Mesh(new THREE.PlaneGeometry(350,350), backboardmaterial);
                backboard.position.x = 0;
                backboard.position.z = 0;
                backboard.position.y = -1;
                backboard.rotation.x = -Math.PI/2;
                backboard.side = THREE.DoubleSide;
                scene.add(backboard);
            }

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
                    child.position.x = (Math.random())*mode*15 + mode*5;//绝对位置坐标X
                    child.position.z = (Math.random()-0.5)*mode*8;//绝对位置坐标Y
                    objects.push(child);
                    // scene.add(child);
                }
            });
            console.log(object);
            scene.add(object);//添加到场景中
            }
            });

            // 拖动控制器声明
            var dragControls = new THREE.DragControls( objects, camera, renderer.domElement );

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
                    if(mode == 25)
                    {
                        var marker;
                        for(marker = 0; marker<25; marker++)
                        {
                            if(target.name.toString() == check_25[0][marker])
                            {
                                break;
                            }
                        }
                        if(target.position.x > -75 && target.position.x < 75 && target.position.z >- 75 && target.position.z < 75)
                        {
                            var positionMarkerX;
                            var positionMarkerZ;

                            check_25[4][marker] = 1;

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
                            check_25[4][marker] = 0;
                        }
                    }        
                    else if(mode == 100)
                    {
                        var marker;
                        for(marker = 0; marker<100; marker++)
                        {
                            if(target.name.toString() == check_100[0][marker])
                            {
                                break;
                            }
                        }
                        if(target.position.x > -150 && target.position.x < 150 && target.position.z >- 150 && target.position.z < 150)
                        {
                            var positionMarkerX;
                            var positionMarkerZ;

                            check_100[4][marker] = 1;

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
                            check_100[4][marker] = 0;
                        }
                    }
                    // 平面位置调整，使贴合能更精准
                    target.position.y = 0;
                    if(mode == 25)
                    {
                        for(var p = 0;p<25;p++)
                        {
                            if(target.name.toString() == check_25[0][p])
                            {
                                if(target.position.x == check_25[1][p]&&target.position.z == check_25[2][p])
                                {
                                    check_25[3][p] = 1;
                                }
                                else
                                {
                                    check_25[3][p] = 0;
                                }
                            }
                        }
                    }

                    if(mode == 100)
                    {
                        for(var p = 0;p<100;p++)
                        {
                            if(target.name.toString() == check_100[0][p])
                            {
                                if(target.position.x == check_100[1][p]&&target.position.z == check_100[2][p])
                                {
                                    check_100[3][p] = 1;
                                }
                                else
                                {
                                    check_100[3][p] = 0;
                                }
                            }
                        }
                    }
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

        </script>




        {{-- 计时器 --}}
        <script>
        window.onload = function(){
            HH = 0;
            mm = 0;
            ss = 0;
            gameTime = '';
            var timer = setInterval(function(){
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
                if(mode == 25)
                {
                    document.getElementById("finishPercentage").innerHTML = check_25[4].sum() + "/" + mode;
                }
                else if(mode == 100)
                {
                    document.getElementById("finishPercentage").innerHTML = check_100[4].sum() + "/" + mode;
                }
            },1000);
        };
        </script>




        <script type="text/javascript">
            Array.prototype.sum = function (){
             var result = 0;
             for(var i = 0; i < this.length; i++) {
              result += this[i];
             }
             return result;
            };
        </script>

        <script type="text/javascript">
            var checkSubmit = function()
            {
                switch(mode)
                {
                    case 25:
                    if(check_25[3].sum() == mode)
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
                    break;

                    case 100:
                    if(check_100[3].sum() == mode)
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
                    break;
                }   
                
            }
        </script>





        <script type="text/javascript">
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
        </script>
    </body>
</html>