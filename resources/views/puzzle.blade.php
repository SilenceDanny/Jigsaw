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
                camera.position.set( 0, 100, 800 );

                scene = new THREE.Scene();

                // Grid

                // var gridHelper = new THREE.GridHelper( 1000, 10 );
                // gridHelper.position.y = - 120;
                // scene.add( gridHelper );

                // cube

                var geometry = new THREE.BoxGeometry( 100, 20, 100 );

                var textureLoader = new THREE.TextureLoader();

                var imagepath = new Array();
                @for($f = 0; $f < count($ImageData); $f++)
                    imagepath.push('<?php echo $ImageData[$f];?>');
                @endfor

                var materials = new Array();
                for(var i = 0; i < imagepath.length; i++)
                {
                    var tempTexture = textureLoader.load(imagepath[i]);
                    materials[i] = new THREE.MeshBasicMaterial( {map:tempTexture} );
                }

                objects = [];

                for ( var i = 0, l = materials.length; i < l; i ++ ) {

                    var cube = new THREE.Mesh( geometry, materials[ i ] );

                    cube.position.x = ( i % 5 ) * 200 - 400;
                    cube.position.z = Math.floor( i / 5 ) * 200 - 200;

                    objects.push( cube );

                    scene.add( cube );

                }

                var PI2 = Math.PI * 2;
                var program = function ( context ) {

                    context.beginPath();
                    context.arc( 0, 0, 0.5, 0, PI2, true );
                    context.fill();

                };

                // Lights

                scene.add( new THREE.AmbientLight( Math.random() * 0x202020 ) );

                var directionalLight = new THREE.DirectionalLight( Math.random() * 0xffffff );
                directionalLight.position.x = Math.random() - 0.5;
                directionalLight.position.y = Math.random() - 0.5;
                directionalLight.position.z = Math.random() - 0.5;
                directionalLight.position.normalize();
                scene.add( directionalLight );

                pointLight = new THREE.PointLight( 0xffffff, 1 );
                scene.add( pointLight );

                var sprite = new THREE.Sprite( new THREE.SpriteCanvasMaterial( { color: 0xffffff, program: program } ) );
                sprite.scale.set( 8, 8, 8 );
                pointLight.add( sprite );

                renderer = new THREE.CanvasRenderer();
                renderer.setPixelRatio( window.devicePixelRatio );
                renderer.setSize( window.innerWidth, window.innerHeight );
                renderer.setClearColor( 0xf0f0f0 );
                container.appendChild( renderer.domElement );

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

            //

            function animate() {

                requestAnimationFrame( animate );

                render();
                stats.update();

            }

            function render() {

                renderer.render( scene, camera );

            }
        </script>

    </body>
</html>