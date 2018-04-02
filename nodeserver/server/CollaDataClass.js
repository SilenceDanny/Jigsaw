module.exports = CollaData;//服务器端

function CollaData(gameName, jigsaw_id, jigsaw_time)//名字是游戏的唯一标识
{
	this.gameName = gameName;//声明拼图游戏名称、创建人、初始场景数据
	this.player = [];
	this.collaData = [];
	this.jigsaw_id = jigsaw_id;
	this.jigsaw_time = jigsaw_time;//声明jigsaw_time

	this.gameInit = function(messageMark)//创建游戏
	{
		var tempArr = messageMark[2].split(',');//用，分割不同拼图的数据
            
        for(var i = 0;i<tempArr.length;i++)
        {
            this.collaData[i] = tempArr[i].split(';');//用；分割单个拼图的ID，X，Y坐标
        }
	}

	this.addPlayer = function(client)//用户加入
	{
		this.player.push(client);//push函数以顺序的方式加入
		
	}

	this.removePlayer = function(client)//用户退出当前游戏
	{
		for(var i = 0; i<this.player.length; i++)
		{
			if(this.player[i][id] == client[id])//第i个用户的拼图id和当前想要退出的拼图id相同时
			{
				this.player.splice(i,1);//splice()函数，从第i个开始删除，删除一个
			}
		}
	}

	this.instruction = function(messageMark)//移动拼图
	{
		for(var i = 0;i<this.collaData.length;i++)
        {
            var tempData = [];
            tempData = messageMark[2].split(';')//分割X和Y坐标
            if(this.collaData[i][0] == tempData[0])
            {
                this.collaData[i][1] = tempData[1];
                this.collaData[i][2] = tempData[2];
            }
        }
	}
}