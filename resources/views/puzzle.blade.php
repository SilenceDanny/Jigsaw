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

        <script>
            var container, stats;

            var camera, scene, renderer, objects;
            var pointLight;

            init();
            animate();

            function init() {

                container = document.createElement('div');
                document.body.appendChild(container);

                camera = new THREE.PerspectiveCamera( 45, window.innerWidth / window.innerHeight, 1, 2000 );
                camera.position.set( 0, 100, 100 );

                scene = new THREE.Scene();

                raycaster = new THREE.Raycaster();
                projector = new THREE.Projector();
                mouse = new THREE.Vector2();

                document.addEventListener( 'mouseup', onDocumentMouseUp, false );
                document.addEventListener( 'touchstart', onDocumentTouchStart, false );

                // Grid

                // var gridHelper = new THREE.GridHelper( 1000, 10 );
                // gridHelper.position.y = - 120;
                // scene.add( gridHelper );

                // cube

                // var geometry = new THREE.BoxGeometry( 100, 20, 100 );

                // var textureLoader = new THREE.TextureLoader();

                // var imagepath = new Array();
                

                // var materials = new Array();
                // for(var i = 0; i < imagepath.length; i++)
                // {
                //     var tempTexture = textureLoader.load(imagepath[i]);
                //     materials[i] = new THREE.MeshBasicMaterial( {map:tempTexture} );
                    
                // }

                // objects = [];

                // for ( var i = 0, l = materials.length; i < l; i ++ ) {

                //     var cube = new THREE.Mesh( geometry, materials[ i ] );

                //     cube.position.x = ( i % 5 ) * 200 - 400;
                //     cube.position.z = Math.floor( i / 5 ) * 200 - 200;

                //     objects.push( cube );

                //     scene.add( cube );

                // }

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

            for(var i = 1; i<=5; i++){
                for(var j = 1; j<=5; j++){
                    var mtlPath = "55_" + i + "_" + j + ".mtl";
                    var objPath = "55_" + i + "_" + j + ".obj";

                    createMtlObj({
                    mtlPath: "objFolder/",
                    mtlFileName: mtlPath,
                    objPath:"objFolder/",
                    objFileName: objPath,
                    completeCallback:function(object){
                        object.traverse(function(child) { 
                            if (child instanceof THREE.Mesh) { 
                            child.material.side = THREE.DoubleSide;//设置贴图模式为双面贴图
                            //                 child.material.emissive.r=0;//设置rgb通道R通道颜色
                            //                 child.material.emissive.g=0.01;//设置rgb通道G通道颜色
                            //                 child.material.emissive.b=0.05;//设置rgb通道B通道颜色
                            // child.material.transparent=true;//材质允许透明
                            //child.material.opacity=0;//材质默认透明度                  
                            child.material.shading=THREE.SmoothShading;//平滑渲染
                        }
                    });
                    object.emissive=0xffffff;//自发光颜色
                    object.ambient=0x00ffff;//环境光颜色
                    //      object.rotation.x= 0;//x轴方向旋转角度
                    object.position.x = (Math.random()-0.5)*500;//位置坐标X
                    object.position.z = (Math.random()-0.5)*500;//位置坐标y
                    object.scale.x=1;//缩放级别
                    object.scale.y=1;//缩放级别
                    object.scale.z=1;//缩放级别
                    console.log(object);
                    object.name="haven";//刚体名称
                    object.rotation.y=-Math.PI;//初始Y轴方向旋转角度

                    object.traverse(function(child) { 
                        if (child instanceof THREE.Mesh) { 
                            objects.push(child);
                        }
                    });
                    console.log(objects);
                    scene.add(object);//添加到场景中
                    }
                    })
                }
            }

                // Lights

                scene.add( new THREE.AmbientLight( 0xffffff , 1) );

                var directionalLight = new THREE.DirectionalLight( 0xffffff );
                directionalLight.position.x = Math.random() - 0.5;
                directionalLight.position.y = Math.random() - 0.5;
                directionalLight.position.z = Math.random() - 0.5;
                directionalLight.position.normalize();
                scene.add( directionalLight );

                pointLight = new THREE.PointLight( 0xffffff, 1 );
                scene.add( pointLight );

                renderer = new THREE.WebGLRenderer();
                renderer.setPixelRatio( window.devicePixelRatio );
                renderer.setSize( window.innerWidth, window.innerHeight );
                renderer.setClearColor( 0xf0f0f0 );
                container.appendChild( renderer.domElement );

                transformControl = new THREE.TransformControls(camera,renderer.domElement);
                transformControl.addEventListener('change',render);

                orbitControl = new THREE.OrbitControls( camera, renderer.domElement );
                orbitControl.enableDamping = true;
                orbitControl.dampingFactor = 0.25;
                orbitControl.enableZoom = true;
                orbitControl.zoomSpeed = 1;

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
                    
                    transformControl.attach(intersects[ 0 ].object);
                    scene.add(transformControl);
                }
            }

            //

            function animate() {

                requestAnimationFrame( animate );

                render();
                stats.update();

            }

            function render() {

                orbitControl.update();
                renderer.render( scene, camera );

            }

            function translate(){
            transformControl.setMode( "translate" );
            }

            function rotate(){
                transformControl.setMode( "rotate" );
            }

            function scale(){
                transformControl.setMode( "scale" );
            }
        </script>

    </body>
</html>