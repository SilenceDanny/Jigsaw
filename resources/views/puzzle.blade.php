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
        <script type="text/javascript"
            src="{{ URL::asset('js/threejs/three.js') }}"></script>
        <script type="text/javascript"
            src="{{ URL::asset('js/threejs/Projector.js') }}"></script>
        <script type="text/javascript"
            src="{{ URL::asset('js/threejs/CanvasRenderer.js') }}"></script>
        <script type="text/javascript"
            src="{{ URL::asset('js/libs/stats.min.js') }}"></script>
        <script type="text/javascript"
            src="{{ URL::asset('js/threejs/OrbitControls.js') }}"></script>
        <script type="text/javascript"
            src="{{ URL::asset('js/threejs/TransformControls.js') }}"></script>
        <script type="text/javascript"
            src="{{ URL::asset('js/threejs/DDSLoader.js') }}"></script>
        <script type="text/javascript"
            src="{{ URL::asset('js/threejs/MTLLoader.js') }}"></script>
        <script type="text/javascript"
            src="{{ URL::asset('js/threejs/OBJLoader.js') }}"></script>
        <script type="text/javascript"
            src="{{ URL::asset('js/threejs/DragControls.js') }}"></script>
        <script type="text/javascript"
            src="{{ URL::asset('js/threejs/TrackBallControls.js') }}"></script>
        <script type="text/javascript"
            src="{{ URL::asset('http://www.zhangxinxu.com/study/js/zxx.drag.1.0.js') }}"></script>
        <style type="text/css">
        #box{position:absolute; left:100px; top:100px; padding:5px; background:#f0f3f9; font-size:12px; -moz-box-shadow:2px 2px 4px #666666; -webkit-box-shadow:2px 2px 4px #666666;}
        </style>
        <div id="box" style="position: absolute;">
            <img src="objFolder/reflact.jpg" alt="" id="reflact" width="200" height="200" style="width: 200px; height: 200px;">
        </div>
        <script type="text/javascript">
            var startreflact = document.getElementById("box");
            var endreflact = document.getElementById("reflact");
            startDrag(endreflact, startreflact);
        </script>

        <div id="main" style="position:absolute;z-index: -1;">
            
        </div>


        <script>
            var container, stats;

            var camera, scene, renderer, objects;
            var pointLight;

            init();
            animate();

            function init() {

                var mode = {{$gamemode}};

                // container = document.createElement('div');
                container = document.getElementById('main');
                document.body.appendChild(container);

                camera = new THREE.PerspectiveCamera( 45, window.innerWidth / window.innerHeight, 1, 4000 );
                camera.position.set( 0, 1000, 20 );

                scene = new THREE.Scene();

                raycaster = new THREE.Raycaster();
                projector = new THREE.Projector();
                mouse = new THREE.Vector2();

                controls = new THREE.TrackballControls( camera );
                controls.rotateSpeed = 0.0;
                controls.zoomSpeed = 1.0;
                controls.panSpeed = 0.8;
                controls.noZoom = false;
                controls.noPan = false;
                controls.staticMoving = true;
                controls.dynamicDampingFactor = 0.3;

                // Lights

                scene.add( new THREE.AmbientLight( 0xffffff , 1) );

                var directionalLight = new THREE.DirectionalLight( 0xffffff );
                directionalLight.position.x = -200;
                directionalLight.position.y = 300;
                directionalLight.position.z = -200;
                directionalLight.position.normalize();
                scene.add( directionalLight );

                spotLight = new THREE.SpotLight( 0xffffff, 2 );
                spotLight.position.set( 150, 400, 350 );
                spotLight.angle = Math.PI / 4;
                spotLight.penumbra = 0.05;
                spotLight.decay = 2;
                spotLight.distance = 200;

                spotLight.castShadow = true;
                spotLight.shadow.mapSize.width = 1024;
                spotLight.shadow.mapSize.height = 1024;
                spotLight.shadow.camera.near = 10;
                spotLight.shadow.camera.far = 200;
                scene.add( spotLight );

                renderer = new THREE.WebGLRenderer();
                renderer.setPixelRatio( window.devicePixelRatio );
                renderer.setSize( window.innerWidth, window.innerHeight );
                renderer.setClearColor( 0xf0f0f0 );
                container.appendChild( renderer.domElement );


                document.addEventListener( 'mouseup', onDocumentMouseUp, false );
                document.addEventListener( 'touchstart', onDocumentTouchStart, false );

                objects = [];
               
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

            var xLength, yLength, OBJMTL_Path, prefix;
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
                    object.position.x = 0;//位置坐标X
                    object.position.z = 0;//位置坐标y
                    object.scale.x=1;//缩放级别
                    object.scale.y=1;//缩放级别
                    object.scale.z=1;//缩放级别

                    object.traverse(function(child) { 
                        if (child instanceof THREE.Mesh) { 
                            child.position.x = (Math.random()-0.5)*mode*20;
                            child.position.z = (Math.random()-0.5)*mode*20;
                            objects.push(child);
                        }
                    });
                    // console.log(objects);
                    console.log(object);
                    scene.add(object);//添加到场景中
                    }
                    })
                }
            }

            for(var i = 0; i<objects.length; i++)
            {
                console.log("test");
                objects[i].position.x = 0;
                objects[i].position.y = 0;
            }

            var dragControls = new THREE.DragControls( objects, camera, renderer.domElement );

            dragControls.addEventListener( 'dragstart', function ( event )
            { 
                controls.enabled = false; 

            });

            dragControls.addEventListener( 'dragend', function ( event ) 
            { 
                controls.enabled = true;
            });

            // stats = new Stats();
            // container.appendChild(stats.dom);


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
                if ( intersects.length > 0 ) {
                    var target = intersects[ 0 ].object;
                            
                    if(target.position.x > -75 && target.position.x < 75 && target.position.z >- 75 && target.position.z < 75)
                    {
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

                        console.log(positionMarkerX);
                        console.log(positionMarkerZ);
                    }
                }
            }


            function animate() {

                requestAnimationFrame( animate );

                render();
                // stats.update();

            }

            function render() {
                controls.update();
                renderer.render( scene, camera );

            }

        </script>

    </body>
</html>