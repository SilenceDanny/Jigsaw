module.exports = CollaManager;//用户端

var CollaDataClass = require('../server/CollaDataClass');//载入colladataclass模块

function CollaManager()
{
	this.collaDataStorage = [];

	this.createGame = function(gameName, messageMark, client_uuid, ws, jigsaw_id,jigsaw_time)//创建拼图
	{	
		
		this.collaDataStorage.push(new CollaDataClass(gameName,jigsaw_id,jigsaw_time));
		for(var i=this.collaDataStorage.length-1;i>=0;i--)//服务器通过ws将拼图信息传递给用户
		{
			if(this.collaDataStorage[i].gameName == gameName)
			{
				this.collaDataStorage[i].gameInit(messageMark);
				this.collaDataStorage[i].addPlayer({"id":client_uuid,"ws":ws});
				// console.log(this.collaDataStorage[i].gameName);//创建完成，拼图游戏启动
				//console.log("更改后的jigsaw_time:"+this.collaDataStorage[i].jigsaw_time);
				break;
			}
		}
	}

	this.joinGame = function(gameName, client_uuid, ws)//加入拼图
	{
		console.log("test");
		for(var i=0;i<this.collaDataStorage.length;i++)//获得游戏列表数据
		{
			if(this.collaDataStorage[i].gameName == gameName)//名字作为唯一标识
			{
				this.collaDataStorage[i].addPlayer({"id":client_uuid,"ws":ws});
				var tempMessage = [];
	            for(var j = 0; j<this.collaDataStorage[i].collaData.length;j++)
	            {
	                tempMessage.push(this.collaDataStorage[i].collaData[j][0]
	                	+";"+
	                	this.collaDataStorage[i].collaData[j][1]
	                	+";"+
	                	this.collaDataStorage[i].collaData[j][2]);
	            }
	            sentMessage = tempMessage.toString();
	            console.log(sentMessage);
	            ws.send("J#"+sentMessage+"#"+this.collaDataStorage[i].jigsaw_id+"#"+this.collaDataStorage[i].jigsaw_time.toString());//此处注意jigsaw_time的传输方式，必须加上“#”作为标识
	            console.log(this.collaDataStorage[i].gameName);//加入成功，显示拼图游戏
	            //console.log(this.collaDataStorage[i].jigsaw_time);
	            break;
			}
		}
	}

	this.moveBlock = function(gameName, messageMark, message)//移动拼图
	{
		for(var i=this.collaDataStorage.length-1;i>=0;i--)
		{
			if(this.collaDataStorage[i].gameName == gameName)
			{
				this.collaDataStorage[i].instruction(messageMark);
				for(var j = 0;j<this.collaDataStorage[i].player.length;j++)
			    {
			        var clientSocket = this.collaDataStorage[i].player[j].ws;
			        if(clientSocket.readyState == 1)
			        {
			            clientSocket.send(message);
			        }
			    }
			    console.log(message);				
				break;
			}
		}
	}

	this.serverList = function(ws)
	{
		var serverMessage = [];
		if(this.collaDataStorage.length>0)
		{
			for(var i=0;i<this.collaDataStorage.length;i++)
			{
				serverMessage.push(this.collaDataStorage[i].gameName+";"+this.collaDataStorage[i].jigsaw_id);
			}
			console.log(serverMessage);
			var sentMessage = serverMessage.toString();
			ws.send("R#" + sentMessage);
		}
	}
}