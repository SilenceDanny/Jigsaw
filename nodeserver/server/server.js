var WebSocketServer = require('ws').Server,//载入websocket模块
wss = new WebSocketServer({ port: 8181 });//分配端口
var tempArr = [];
var collaData = [];
var sentMessage;
// var clientIndex = 0;
// var clients = [];

var CollaManagerClass = require('../server/CollaManagerClass')//引入collamanagerclass文件

var collaManager = new CollaManagerClass();//创建collamanagerclass对象

wss.on('connection', function (ws) {   //绑定connection事件，处理函数为ws
    var uuid = require('node-uuid');
    var client_uuid = uuid.v4();
    // clientIndex +=1;
    // clients.push({"id":client_uuid,"ws":ws});
    console.log('client connected');
    ws.on('message', function (message) {   //绑定message事件，处理函数为message
        messageMark = message.split('#');
        if(messageMark[0] == 'J')
        {
            collaManager.joinGame(messageMark[1],client_uuid,ws);
        }
        else if(messageMark[0] == 'C')
        {
            collaManager.createGame(messageMark[1],messageMark,client_uuid,ws);
        }
        else if(messageMark[0] == 'I')
        {
            collaManager.moveBlock(messageMark[1],messageMark,message);
        }
    });
});

// function IBroadcast(message){
//     for(var i = 0;i<clients.length;i++)
//     {
//         var clientSocket = clients[i].ws;
//         if(clientSocket.readyState == 1)
//         {
//             clientSocket.send(message);
//         }
//     }
// }

// if(messageMark[0] == 'J')
        // {
        //     var tempMessage = [];
        //     for(var i = 0; i<collaData.length;i++)
        //     {
        //         tempMessage.push(collaData[i][0]+";"+collaData[i][1]+";"+collaData[i][2]);
        //     }
        //     sentMessage = tempMessage.toString();
        //     console.log(sentMessage);
        //     ws.send("J#"+sentMessage);
        // }
        // else if(messageMark[0] == 'C')
        // {

        //     tempArr = messageMark[1].split(',');
            
        //     for(var i = 0;i<tempArr.length;i++)
        //     {
        //         collaData[i] = tempArr[i].split(';');
        //     }
        //     console.log(collaData);
        // }
        // else if(messageMark[0] == 'I')
        // {
        //     for(var i = 0;i<collaData.length;i++)
        //     {
        //         var tempData = [];
        //         tempData = messageMark[1].split(';')
        //         if(collaData[i][0] == tempData[0])
        //         {
        //             collaData[i][1] = tempData[1];
        //             collaData[i][2] = tempData[2];
        //         }
        //     }
        //     IBroadcast(message);