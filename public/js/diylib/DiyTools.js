document.write("<script language=javascript src=’/js/three.js’></script>");
document.write("<script language=javascript src=’/js/ObjLoader.js’></script>");
document.write("<script language=javascript src=’/js/MTLLoader.js’></script>");
document.write("<script language=javascript src=’/js/DSSLoader.js’></script>");

function DiyTools (){
	this.PuzzleInit = function(objects,scene,mode) {




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
            mtlLoader.setPath( options.mtlPath );//设置mtl文件路径
            mtlLoader.load( options.mtlFileName, function( materials ) 
            {
                materials.preload();
                var objLoader = new THREE.OBJLoader();
                objLoader.setMaterials( materials );//设置三维对象材质库
                objLoader.setPath( options.objPath );//设置obj文件所在目录
                objLoader.load( options.objFileName, function ( object ) 
                {
                    if(typeof options.completeCallback=="function")
                    {
                        options.completeCallback(object);

                    }
                }, 
                function ( xhr ) 
                {
                    if ( xhr.lengthComputable ) 
                    {
                        var percentComplete = xhr.loaded / xhr.total * 100;
                        if(typeof options.progress =="function")
                        {
                            options.progress( Math.round(percentComplete, 2));
                        }
                    }
                }, 
                function(error)
                {

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


        for(var i = 1; i<=xLength; i++){
                for(var j = 1; j<=yLength; j++){
                    var mtlPath = prefix + i + "_" + j + ".mtl";
                    var objPath = prefix + i + "_" + j + ".obj";

                    createMtlObj({
                    mtlPath: "objFolder/" + OBJMTL_Path,
                    mtlFileName: mtlPath,
                    objPath:"objFolder/" + OBJMTL_Path,
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
                            child.position.x = (Math.random()-0.5)*500;
                            child.position.z = (Math.random()-0.5)*500;
                            objects.push(child);
                        }
                    });
                    // console.log(objects);
                    scene.add(object);//添加到场景中
                    }
                    })
                }
            }


	}
}