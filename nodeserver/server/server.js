var WebSocketServer = require('ws').Server,//载入websocket模块
wss = new WebSocketServer({ port: 8181 });//分配端口
var tempArr = [];
var collaData = [];
var sentMessage;


var CollaManagerClass = require('../server/CollaManagerClass')//引入collamanagerclass文件

var collaManager = new CollaManagerClass();//创建collamanagerclass对象

wss.on('connection', function (ws) {   //绑定connection事件，处理函数为ws
    var uuid = require('node-uuid');
    var client_uuid = uuid.v4();

    console.log('client connected');
    ws.on('message', function (message) {   //绑定message事件，处理函数为message
        messageMark = message.split('#');
        //console.log(messageMark[4]);
        if(messageMark[0] == 'J')
        {
            collaManager.joinGame(messageMark[1],client_uuid,ws,messageMark[5]);
        }
        else if(messageMark[0] == 'C')
        {
            console.log(messageMark);
            collaManager.createGame(
                messageMark[1],messageMark,client_uuid,ws,messageMark[3],messageMark[4],messageMark[5].split(",")
            );
            //messageMark[4]就是传输时的jigsaw_time
        }
        else if(messageMark[0] == 'I')
        {
            collaManager.moveBlock(messageMark[1],messageMark,message);
        }
        else if(messageMark[0] == 'R')
        {
            collaManager.serverList(ws);
        }
    });
});

// messageMark0--C/J/I
// messageMark1--游戏名称
// messageMark2--一个拼图块的x和z坐标
// messageMark3--拼图id
// messageMark4--时间
// messageMark5--进度