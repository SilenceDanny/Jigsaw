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
            src="{{ URL::asset('js/three.js') }}"></script>
        <script type="text/javascript"
            src="{{ URL::asset('js/renderers/Projector.js') }}"></script>
        <script type="text/javascript"
            src="{{ URL::asset('js/renderers/CanvasRenderer.js') }}"></script>
        <script type="text/javascript"
            src="{{ URL::asset('js/libs/stats.min.js') }}"></script>
        <script type="text/javascript"
            src="{{ URL::asset('js/OrbitControls.js') }}"></script>
        <script type="text/javascript"
            src="{{ URL::asset('js/Projector.js') }}"></script>
        <script type="text/javascript"
            src="{{ URL::asset('js/TransformControls.js') }}"></script>
        <script type="text/javascript"
            src="{{ URL::asset('js/DDSLoader.js') }}"></script>
        <script type="text/javascript"
            src="{{ URL::asset('js/MTLLoader.js') }}"></script>
        <script type="text/javascript"
            src="{{ URL::asset('js/OBJLoader.js') }}"></script>
        <script type="text/javascript"
            src="{{ URL::asset('js/DragControls.js') }}"></script>
        <script type="text/javascript"
            src="{{ URL::asset('js/TrackBallControls.js') }}"></script>

        <script type="text/javascript"
            src="{{ URL::asset('js/diylib/DiyTools.js') }}"></script>
        <script>
            var container, stats;

            var camera, scene, renderer, objects;
            var pointLight;

            init();
            animate();

            function init() {

                var mode = {{$gamemode}};

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


                document.addEventListener( 'mouseup', onDocumentMouseUp, false );
                document.addEventListener( 'touchstart', onDocumentTouchStart, false );


                // var background = new THREE.PlaneGeometry(2560,1440);
                // var textureLoader = new THREE.TextureLoader()
                // var backgroundTexture = textureLoader.load("background.jpg");
                // var backgroundMaterials = new THREE.MeshBasicMaterial({map:backgroundTexture});
                // var plane = new THREE.Mesh(background,backgroundMaterials);
                // plane.position.x = 0;
                // plane.position.y = -100;
                // plane.position.z = 50;
                // plane.rotation.x= -Math.PI/2;

                // scene.add(plane);

                // var background2 = new THREE.PlaneGeometry(300,300);
                // var textureLoader2 = new THREE.TextureLoader()
                // var backgroundTexture2 = textureLoader2.load("objFolder/" + mode +"/texture/texture.jpg");
                // var backgroundMaterials2 = new THREE.MeshBasicMaterial({map:backgroundTexture2});
                // var plane2 = new THREE.Mesh(background2,backgroundMaterials2);
                // plane2.position.x = -1000;
                // plane2.position.y = -20;
                // plane2.position.z = 400;
                // plane2.rotation.x= -Math.PI/2;
                
                // scene.add(plane2);

                // var background3 = new THREE.PlaneGeometry(300,300);
                // var textureLoader3 = new THREE.TextureLoader()
                // var backgroundTexture3 = textureLoader3.load("background.jpg");
                // var backgroundMaterials3 = new THREE.MeshBasicMaterial({map:backgroundTexture});
                // var plane3 = new THREE.Mesh(background3,backgroundMaterials3);
                // plane3.position.x = 0;
                // plane3.position.y = -1;
                // plane3.position.z = 0;
                // plane3.rotation.x= -Math.PI/2;

                // scene.add(plane3);

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

        objects = [];

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
            for(var j = 1; j<=yLength; j++){
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
                
                pointLight = new THREE.PointLight( 0xffffff, 1 );
                scene.add( pointLight );

                renderer = new THREE.WebGLRenderer();
                renderer.setPixelRatio( window.devicePixelRatio );
                renderer.setSize( window.innerWidth, window.innerHeight );
                renderer.setClearColor( 0xf0f0f0 );
                container.appendChild( renderer.domElement );

                // transformControl = new THREE.TransformControls(camera,renderer.domElement);
                // transformControl.addEventListener('change',render);

                // orbitControl = new THREE.OrbitControls( camera, renderer.domElement );
                // orbitControl.enableDamping = true;
                // orbitControl.dampingFactor = 0.25;
                // orbitControl.enableZoom = true;
                // orbitControl.zoomSpeed = 1;

                var dragControls = new THREE.DragControls( objects, camera, renderer.domElement );

                dragControls.addEventListener( 'dragstart', function ( event )
                { 
                    controls.enabled = false; 

                } );

                dragControls.addEventListener( 'dragend', function ( event ) 
                { 
                    controls.enabled = true;
                } );

                stats = new Stats();
                container.appendChild(stats.dom);

                //

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

                        console.log(positionMarkerX);
                        console.log(positionMarkerZ);
                    }
                }
            }

            //

            function animate() {

                requestAnimationFrame( animate );

                render();
                stats.update();

            }

            function render() {

                // orbitControl.update();
                controls.update();
                renderer.render( scene, camera );

            }

            // function translate(){
            // transformControl.setMode( "translate" );
            // }

            // function rotate(){
            //     transformControl.setMode( "rotate" );
            // }

            // function scale(){
            //     transformControl.setMode( "scale" );
            // }
        </script>

    </body>
</html>