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
            src="{{ URL::asset('js/threejs/TrackBallControls.js') }}"></script>
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
            <img src="objFolder/reflact.jpg" alt="" id="reflact" width="200" height="200" style="width: 200px; height: 200px;background: #3B3F42">
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
                        <a class="nav-link" href="#">USER:{{ Auth::user()->name }}</a>
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
                <div id="dtime" style="font-size:40px;line-height: 50px;color: #fff;font-weight: 600;background-color: #2C3E50">00:00:00</div>
            </div>
        {{-- 拼图场景 --}}
            <div id="main" style="position:absolute;z-index: -1;"></div> 
        </div>

        <script>
            var container, stats;

            var camera, scene, renderer, objects;
            var pointLight;
            var xLength, yLength, OBJMTL_Path, prefix;

            init();
            animate();

            function init() {

                // 模式：25块或100块
                var mode = {{$gamemode}};

                // 定义场景显示到main div
                container = document.getElementById('main');
                document.body.appendChild(container);

                // 镜头声明
                camera = new THREE.PerspectiveCamera( 45, window.innerWidth / window.innerHeight, 1, 4000 );
                camera.position.set( 0, 1000, 20 );//位置(x，y，z)

                // 场景声明
                scene = new THREE.Scene();

                // 模型拾取声明，参考raycaster实现
                raycaster = new THREE.Raycaster();
                projector = new THREE.Projector();
                mouse = new THREE.Vector2();

                // 视角控制声明
                controls = new THREE.TrackballControls( camera );
                controls.rotateSpeed = 0.0; // 镜头旋转速度
                controls.zoomSpeed = 1.0;   // 镜头缩放速度
                controls.panSpeed = 0.8;    // 镜头平移速度
                controls.noZoom = false;    // 可缩放
                controls.noPan = false;     // 可平移
                controls.staticMoving = true;
                controls.dynamicDampingFactor = 0.3;

                // 灯光声明
                // 环境光：颜色白色(0xffffff)，强度2
                scene.add( new THREE.AmbientLight( 0xffffff , 2) );

                // 渲染器声明
                renderer = new THREE.WebGLRenderer();
                renderer.setPixelRatio( window.devicePixelRatio );
                renderer.setSize( window.innerWidth, window.innerHeight );
                renderer.setClearColor( 0x615355 );// 背景色设定
                container.appendChild( renderer.domElement );

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
                prefix = "55_";
            }
            else if(mode == 100)
            {
                xLength = 10;
                yLength = 10;
                OBJMTL_Path = "100";
                prefix = "1010_"
            }

            // 模型导入
            for(var i = 1; i<=xLength; i++)
            {
                for(var j = 1; j<=yLength; j++)
                {
                    var mtlPath = prefix + i + "_" + j + ".mtl";
                    var objPath = prefix + i + "_" + j + ".obj";

                    createMtlObj({
                    mtlPath: "objFolder/" + OBJMTL_Path + "/",
                    mtlFileName: mtlPath,
                    objPath:"objFolder/" + OBJMTL_Path + "/",
                    objFileName: objPath,
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
                            child.position.x = (Math.random()-0.5)*mode*20;//绝对位置坐标X
                            child.position.z = (Math.random()-0.5)*mode*20;//绝对位置坐标Y
                            objects.push(child);
                        }
                    });
                    console.log(object);
                    scene.add(object);//添加到场景中
                    }
                    })
                }
            }

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
                console.log(intersects);
                // 网格贴合逻辑
                if ( intersects.length > 0 ) {
                    var target = intersects[ 0 ].object;
                            
                    if(target.position.x > -75 && target.position.x < 75 && target.position.z >- 75 && target.position.z < 75)
                    {
                        // 设定网格
                        var xMarker = [0,30,30,60,60];
                        var zMarker = [0,30,30,60,60];

                        var positionMarkerX;
                        var positionMarkerZ;

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
                    // 平面位置调整，使贴合能更精准
                    target.position.y = 0;
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
            var HH = 0;
            var mm = 0;
            var ss = 0;
            var str = '';
            var timer = setInterval(function(){
                str = "";
                if(++ss==60)
                {
                    if(++mm==60)
                    {
                        HH++;
                        mm=0;
                    }
                    ss=0;
                }    
                str+=HH<10?"0"+HH:HH;
                str+=":";
                str+=mm<10?"0"+mm:mm;
                str+=":";
                str+=ss<10?"0"+ss:ss;
                document.getElementById("dtime").innerHTML = str;
            },1000);
        };
        </script>


    </body>
</html>