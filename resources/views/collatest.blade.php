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
            src="{{ URL::asset('js/threejs/Projector.js') }}"></script>
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
            src="{{ URL::asset('js/jquery.min.js') }}"></script>
        <script>

            var container, stats;

            var camera, scene, renderer, objects;
            var pointLight;
            var ws;

            var mode = {{$gamemode}};
            objects = [];

            var colladata = new Array();

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
                prefix = "1010_";
            }

            init();
            animate();

            function init() 
            {
                container = document.createElement('div');
                document.body.appendChild(container);

                camera = new THREE.PerspectiveCamera( 45, window.innerWidth / window.innerHeight, 1, 4000 );
                camera.position.set( 0, 1000, 0 );

                scene = new THREE.Scene();

                raycaster = new THREE.Raycaster();
                projector = new THREE.Projector();
                mouse = new THREE.Vector2();

                controls = new THREE.TrackballControls( camera );

                controls.rotateSpeed = 2.0;

                controls.zoomSpeed = 1.2;

                controls.panSpeed = 0.8;

                controls.noZoom = false;

                controls.noPan = false;

                controls.staticMoving = true;

                controls.dynamicDampingFactor = 0.3;

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
                
                pointLight = new THREE.PointLight( 0xffffff, 1 );
                scene.add( pointLight );

                renderer = new THREE.WebGLRenderer();
                renderer.setPixelRatio( window.devicePixelRatio );
                renderer.setSize( window.innerWidth, window.innerHeight );
                renderer.setClearColor( 0xf0f0f0 );
                container.appendChild( renderer.domElement );


                document.addEventListener( 'mouseup', onDocumentMouseUp, false );
                document.addEventListener( 'touchstart', onDocumentTouchStart, false );

            }

            function createMtlObj(options)
            {
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
                //     mtlLoader.setBaseUrl( options.mtlBaseUrl );//设置材质路径
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
                            //console.log( Math.round(percentComplete, 2) + '% downloaded' );
                        }
                    }, function(error){

                    });
                });

            }


            function CreateColla()
            {
                ws = new WebSocket("ws://localhost:8181");

                ws.onopen = function (e) {
                    console.log('Connection to server opened');

                    sum = xLength*yLength;
                    for(var i = 1; i<=xLength; i++)
                    {
                        for(var j = 1; j<=yLength; j++){
                            var mtlPath = prefix + i + "_" + j + ".mtl";
                            var objPath = prefix + i + "_" + j + ".obj";

                            createMtlObj(
                            {
                                mtlPath: "objFolder/" + OBJMTL_Path + "/",
                                mtlFileName: mtlPath,
                                objPath:"objFolder/" + OBJMTL_Path + "/",
                                objFileName: objPath,
                                completeCallback:function(object)
                                {
                                    object.traverse(function(child) 
                                    { 
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

                                object.traverse(function(child) 
                                { 
                                    if (child instanceof THREE.Mesh) 
                                    { 
                                        child.position.x = Math.floor((Math.random()-0.5)*mode*20);
                                        child.position.z = Math.floor((Math.random()-0.5)*mode*20);
                                        objects.push(child);
                                        
                                        colladata.push(child);

                                        // console.log(collaObjectsX);
                                        if(colladata.length == sum)
                                        {
                                            // var sendX = collaObjectsX.join(";");
                                            // var sendY = collaObjectsZ.join(";");
                                            console.log(colladata);
                                            // ws.send("X;"+sendX);
                                            // ws.send("Y;"+sendY);
                                            ws.send(JSON.stringify(colladata));
                                        }
                                    }
                                });
                                scene.add(object);//添加到场景中
                                }
                            })
                        }
                    }
                    // ws.send();
                }

                


                var dragControls = new THREE.DragControls( objects, camera, renderer.domElement );

                dragControls.addEventListener( 'dragstart', function ( event )
                { 
                    controls.enabled = false; 

                } );

                dragControls.addEventListener( 'dragend', function ( event ) 
                { 
                    controls.enabled = true;
                } );

                window.addEventListener( 'resize', onWindowResize, false );
            }


            function JoinColla()
            {
                ws = new WebSocket("ws://localhost:8181");

                ws.onopen = function(e)
                {
                    ws.send("join");
                }

                ws.onmessage = function(e)
                {
                    // var temp = JSON.parse(e.data);
                    console.log(e.data);
                }
               
            }

            console.log(objects);


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
                if ( intersects.length > 0 ) {
                    var target = intersects[ 0 ].object;
                            
                    if(target.position.x > -75 && target.position.x < 75 && target.position.z >- 75 && target.position.z < 75)
                    {
                        // target.position.x = target.position.x-(target.position.x%30);
                        // target.position.z = target.position.z-(target.position.z%30);

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

                        // console.log(positionMarkerX);
                        // console.log(positionMarkerZ);
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

        <button type="button" id="create" class="btn btn-primary"
                        onclick="CreateColla();">
                    Create
        </button>

        <button type="button" id="join" class="btn btn-primary"
                        onclick="JoinColla();">
                    Join
        </button>
        </script>
    </body>
</html>