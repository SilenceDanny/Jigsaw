module.exports = CollaManager;//用户端

var CollaDataClass = require('../server/CollaDataClass');//载入colladataclass模块

function CollaManager()
{
	this.collaDataStorage = [];

	this.createGame = function(gameName, messageMark, client_uuid, ws, jigsaw_id,jigsaw_time,jigsaw_progress)//创建拼图
	{	
		
		this.collaDataStorage.push(new CollaDataClass(gameName,jigsaw_id,jigsaw_time,jigsaw_progress));
		// console.log("CREATE : "+ jigsaw_progress);
		for(var i=this.collaDataStorage.length-1;i>=0;i--)//服务器通过ws将拼图信息传递给用户
		{
			if(this.collaDataStorage[i].gameName == gameName)
			{
				this.collaDataStorage[i].gameInit(messageMark);
				this.collaDataStorage[i].addPlayer(client_uuid,ws);
				// console.log(this.collaDataStorage[i].gameName);//创建完成，拼图游戏启动
				//console.log("更改后的jigsaw_time:"+this.collaDataStorage[i].jigsaw_time);
				//console.log("progress: "+this.collaDataStorage[i].jigsaw_progress);
				break;
			}
		}
	}

	this.joinGame = function(gameName, client_uuid, ws)//加入拼图
	{
		for(var i=0;i<this.collaDataStorage.length;i++)//获得游戏列表数据
		{
			if(this.collaDataStorage[i].gameName == gameName)//名字作为唯一标识
			{
				this.collaDataStorage[i].addPlayer(client_uuid,ws);
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
	            // console.log("sent: "+sentMessage);
	            // ws.send("J#"+sentMessage+"#"+this.collaDataStorage[i].jigsaw_id+"#"+this.collaDataStorage[i].jigsaw_time.toString()
	            // +"#"+this.collaDataStorage[i].collaData[i][3]+"#");//此处注意jigsaw_time的传输方式，必须加上“#”作为标识
	            ws.send("J#"+sentMessage+"#"+this.collaDataStorage[i].jigsaw_id+"#"+this.collaDataStorage[i].jigsaw_time
	            +"#"+this.collaDataStorage[i].jigsaw_progress+"#");//此处注意jigsaw_time的传输方式，必须加上“#”作为标识
	            // console.log("join message: "+"J#"+sentMessage+"#"+this.collaDataStorage[i].jigsaw_id+"#"+this.collaDataStorage[i].jigsaw_time.toString()
	            // +"#"+this.collaDataStorage[i].jigsaw_progress+"#");
	            // console.log(this.collaDataStorage[i].gameName);//加入成功，显示拼图游戏
	            // console.log("joining progress: "+this.collaDataStorage[i].jigsaw_time);
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
				//console.log("messageMark : "+messageMark);
				//this.collaDataStorage[i].jigsaw_progress = messageMark[4];//此时是messagemark有值
				//console.log("after moving progress: "+messageMark[4]);
				//console.log("another after moving progress: "+this.collaDataStorage[i].jigsaw_progress);
				for(var j = 0;j<this.collaDataStorage[i].player.length;j++)
			    {
			        var clientSocket = this.collaDataStorage[i].player[j].ws;
			        if(clientSocket.readyState == 1)
			        {
			            clientSocket.send(message);
			        }
			    }
			    //var a = new Array();
			    //a = message.split("#");
			    //messageMark[4] = a[3];
			    //console.log("message5: "+messageMark[3]);
			    //jigsaw_progress = a[3];
			    this.collaDataStorage[i].jigsaw_progress = messageMark[3];
			    //console.log("messaage[6]: "+message[6]);s
			    //console.log("message[8]: "+message[8]);			
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
			var sentMessage = serverMessage.toString();
			ws.send("R#" + sentMessage);
		}
	}

	this.removePlayer = function(client_uuid)
	{
		for(var i=0;i<this.collaDataStorage.length;i++)
		{
			this.collaDataStorage[i].removePlayer(client_uuid);

			// for(var l=0;l<this.collaDataStorage.length;l++)
			// {
			// 	console.log(this.collaDataStorage[l].player);
			// }
			if(this.collaDataStorage[i].player.length == 0)
			{
				if(this.collaDataStorage[i].isCreated == 0)
				{
					this.collaDataStorage[i].isCreated = 1;
				}
				else if(this.collaDataStorage[i].isCreated == 1)
				{
					this.collaDataStorage.splice(i,1);
				}
			}
		}
	}
}