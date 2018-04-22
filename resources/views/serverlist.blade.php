@extends('layouts.app')

<?php
    use App\Puzzle;
    $puzzles =App\Puzzle::all();
    $puzzleCnt = count($puzzles);
?>
<div class="container">
    <button onclick="window.location.reload()">Refresh</button>
    <div class="row">
        <h2>Game in Process List</h2>
        <div id="server"></div>
    </div>

    <div class="row">
        <h2>Input and Click picture to create</h2>
        @if($puzzleCnt>0)            
            @for ($i = 0; $i < $puzzleCnt; $i++)
                <?php
                $puzzle_choosen = $i;
                ?>
                <div class="col-sm-6 col-md-3 wow fadeInLeft">
                    <div class="block">
                        <form name="createColla" action="createGame" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="Name" value={{$puzzles[$puzzle_choosen]->puzzle_name}}>
                            <input type="hidden" name="ID" value={{$puzzles[$puzzle_choosen]->puzzle_id}}>
                            <input type="hidden" name="Path" value={{$puzzles[$puzzle_choosen]->path}}>
                            <input type="hidden" name="Mode" value={{$puzzles[$puzzle_choosen]->mode}}>
                            <input type="image" src={{$puzzles[$puzzle_choosen]->path}} style="width: 200px; height: 200px">
                            <input type="text" name="gameName" placeholder="Input game name here...">
                        </form>
                        <h2>{{$puzzles[$puzzle_choosen]->puzzle_name or 'Default'}}</h4>
                        <h4>{{$puzzles[$puzzle_choosen]->mode or 'Default'}} Pieces</h4>
                                        
                     </div>
                </div>
            @endfor
        @endif                
    </div>

    <form id="joinSubmit" hidden="hidden" action="joinGame" method="post" accept-charset="utf-8">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input id="serverNameSub" type="hidden" name="gameName" value="">
        <input id="puzzle_idSub" type="hidden" name="puzzle_id" value="">
    </form>
</div>

<script type="text/javascript" charset="utf-8" async defer>
    var puzzles = eval('<?php echo json_encode($puzzles);?>');
    var serverList = [];

    var list;

    var ws = new WebSocket("ws://192.144.138.57:8181");
    ws.onopen = function (e) {
        console.log('Connection to server opened');
            ws.send("R#");
        }
    ws.onmessage = function(e)
    {
        tempData = e.data;
        requestData = tempData.split('#');
        if(requestData[0] == 'R')
        {
            var tempServer = [];
            tempServer = requestData[1].split(',');
                            
            for(var i=0;i<tempServer.length;i++)
            {
                serverList[i] = tempServer[i].split(';');
            }
            console.log(serverList);
            list = document.getElementById('server');

            for(var j=0;j<serverList.length;j++)
            {
                var holder = document.createElement('div');
                var item;
                var image = document.createElement('img');
                
                var button = document.createElement('button');
                button.innerText = "Join<  "+serverList[j][0] + "  >";
                button.value = serverList[j][0] + "#" + serverList[j][1];
                button.id = j;
                button.onclick = function(){joinCollaGame()} ;

                for(var k=0;k<puzzles.length;k++)
                {
                    if(puzzles[k].puzzle_id == serverList[j][1])
                    {
                        image.src = puzzles[k].path;
                        image.style= "width: 200px; height: 200px";
                    }
                }

                if(list!=null)
                {
                    list.appendChild(image);
                    holder.appendChild(button);
                    list.appendChild(holder);    
                }
                 
            }
        }
    }    
</script>



<script type="text/javascript" charset="utf-8" async defer>
    function joinCollaGame()
    {
        var btn = document.getElementsByTagName("button");
        document.body.onclick = function(event){
            var id = event.target.id;
            var clickedB = document.getElementById(id);

            var form = document.getElementById('joinSubmit');
            var serverNameSub = document.getElementById('serverNameSub');
            var puzzle_idSub = document.getElementById('puzzle_idSub');
            var buttonValue = clickedB.value.split('#');
            serverNameSub.value = buttonValue[0];
            puzzle_idSub.value = buttonValue[1];

            form.submit();
        }
    }
</script>