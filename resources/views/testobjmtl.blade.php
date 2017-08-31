<!DOCTYPE html>
<html lang="en">
	<head>
		<title>three.js webgl - OBJLoader + MTLLoader</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
		<style>
			body {
				font-family: Monospace;
				background-color: #000;
				color: #fff;
				margin: 0px;
				overflow: hidden;
			}
			#info {
				color: #fff;
				position: absolute;
				top: 10px;
				width: 100%;
				text-align: center;
				z-index: 100;
				display:block;
			}
			#info a, .button { color: #f00; font-weight: bold; text-decoration: underline; cursor: pointer }
		</style>
	</head>

	<body>
		<div id="info">
		<a href="http://threejs.org" target="_blank" rel="noopener">three.js</a> - OBJLoader + MTLLoader
		</div>

		<script type="text/javascript"
            src="{{ URL::asset('js/three.js') }}"></script>
        <script type="text/javascript"
            src="{{ URL::asset('js/DDSLoader.js') }}"></script>
        <script type="text/javascript"
            src="{{ URL::asset('js/MTLLoader.js') }}"></script>
        <script type="text/javascript"
            src="{{ URL::asset('js/OBJLoader.js') }}"></script>
        <script type="text/javascript"
            src="{{ URL::asset('js/Detector.js') }}"></script>
        <script type="text/javascript"
            src="{{ URL::asset('js/libs/stats.min.js') }}"></script>
        <script type="text/javascript"
            src="{{ URL::asset('js/OrbitControls.js') }}"></script>
        <script type="text/javascript"
            src="{{ URL::asset('js/renderers/CanvasRenderer.js') }}"></script>
        <script type="text/javascript"
            src="{{ URL::asset('js/Projector.js') }}"></script>

		<script>

			var container, stats;

			var camera, scene, renderer;

			var mouseX = 0, mouseY = 0;

			var windowHalfX = window.innerWidth / 2;
			var windowHalfY = window.innerHeight / 2;


			init();
			animate();


			function init() {

				container = document.createElement( 'div' );
				document.body.appendChild( container );

				camera = new THREE.PerspectiveCamera( 45, window.innerWidth / window.innerHeight, 1, 30000 );
                camera.position.set( 0, 200, 0 );


                scene = new THREE.Scene();
                camera.lookAt( scene.position );
				
				// var onProgress = function ( xhr ) {
				// 	if ( xhr.lengthComputable ) {
				// 		var percentComplete = xhr.loaded / xhr.total * 100;
				// 		console.log( Math.round(percentComplete, 2) + '% downloaded' );
				// 	}
				// };

				// var onError = function ( xhr ) { };

				// THREE.Loader.Handlers.add( /\.dds$/i, new THREE.DDSLoader() );

				// var mtlLoader = new THREE.MTLLoader();
				// mtlLoader.setPath( 'objFolder/' );
				// mtlLoader.load( 'test.mtl', function( materials ) {

				// 	materials.preload();

				// 	var objLoader = new THREE.OBJLoader();
				// 	objLoader.setMaterials( materials );
				// 	objLoader.setPath( 'objFolder/' );
				// 	objLoader.load( 'test.obj', function ( object ) {

				// 		object.position.x = 0;
				// 		object.position.y = 0;
				// 		object.position.z = 0;
				// 		scene.add( object );

				// 	}, onProgress, onError );

				// });

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


			createMtlObj({
			//     mtlBaseUrl:"objFolder/",
			mtlPath: "objFolder/",
			mtlFileName:"board_1_1.mtl",
			objPath:"objFolder/",
			objFileName:"board_1_1.obj",
			completeCallback:function(object){
				object.traverse(function(child) { 
					if (child instanceof THREE.Mesh) { 
					child.material.side = THREE.DoubleSide;//设置贴图模式为双面贴图
					//                 child.material.emissive.r=0;//设置rgb通道R通道颜色
					//                 child.material.emissive.g=0.01;//设置rgb通道G通道颜色
					//                 child.material.emissive.b=0.05;//设置rgb通道B通道颜色
					child.material.transparent=true;//材质允许透明
					//child.material.opacity=0;//材质默认透明度                        
					child.material.shading=THREE.SmoothShading;//平滑渲染
				}
			});
			object.emissive=0x00ffff;//自发光颜色
			object.ambient=0x00ffff;//环境光颜色
			//      object.rotation.x= 0;//x轴方向旋转角度
			object.position.y = 0;//位置坐标X
			object.position.z = 0;//位置坐标y
			object.scale.x=1;//缩放级别
			object.scale.y=1;//缩放级别
			object.scale.z=1;//缩放级别
			object.name="haven";//刚体名称
			object.rotation.y=-Math.PI;//初始Y轴方向旋转角度
			scene.add(object);//添加到场景中
		}
		//     progress:function(persent){
		//          
		//         $("#havenloading .progress").css("width",persent+"%");
		//     }
	})















				scene.add( new THREE.AmbientLight( Math.random() * 0x202020 ) );

                // var directionalLight = new THREE.DirectionalLight( Math.random() * 0xffffff );
                // directionalLight.position.x = Math.random() - 0.5;
                // directionalLight.position.y = Math.random() - 0.5;
                // directionalLight.position.z = Math.random() - 0.5;
                // directionalLight.position.normalize();
                // scene.add( directionalLight );

                // pointLight = new THREE.PointLight( 0xffffff, 1 );
                // scene.add( pointLight );

                var ambient = new THREE.AmbientLight( 0xffffff );
				scene.add( ambient );

                renderer = new THREE.CanvasRenderer();
                // renderer.setPixelRatio( window.devicePixelRatio );
                renderer.setSize( window.innerWidth, window.innerHeight );
                renderer.setClearColor( 0xf0f0f0 );
                container.appendChild( renderer.domElement );

                orbitControl = new THREE.OrbitControls( camera, renderer.domElement );
                orbitControl.enableDamping = true;
                orbitControl.dampingFactor = 0.25;
                orbitControl.enableZoom = true;
                orbitControl.zoomSpeed = 10;

                window.addEventListener( 'resize', onWindowResize, false );
            }

            function onDocumentTouchStart( event ) {

            event.preventDefault();

            event.offsetX = event.touches[0].offsetX;
            event.offsetY = event.touches[0].offsetY;
            onDocumentMouseUp( event );

            }

            function onWindowResize() {

                camera.aspect = window.innerWidth / window.innerHeight;
                camera.updateProjectionMatrix();

                renderer.setSize( window.innerWidth, window.innerHeight );

            }

            function animate() {

                requestAnimationFrame( animate );

                render();
                // stats.update();

            }

            function render() {

                orbitControl.update();
                renderer.render( scene, camera );

            }
		</script>

	</body>
</html>
