var gameinittool = function(mode, xMarker, zMarker, checkarray)
{
	console.log("good");
	var num = new Array();
    for(var i = 1;i<=1024;i++)
    {
        if(i<10)
        {
            num.push("00"+i);
        }
        else if(i<100)
        {
            num.push("0"+i);
        }
        else
        {
            num.push(""+i);
        }
    }
    for(var p = 0;p < mode; p++)
    {
    	checkarray[0].push(num[p]);
    }
	if(mode%2 == 1)
	{
		xMarker[0] = 0;
		zMarker[0] = 0;
		var cordnate = 30;
		var cordnate_2 = 0;
		var side = Math.sqrt(mode);
		for(var i = 1;i < side; i++)
		{
			xMarker[i] = cordnate;
			zMarker[i] = cordnate;
			if(i%2 == 0)
			{
				cordnate = cordnate + 30;
			}
		}
		cordnate = -(cordnate - 30);
		cordnate_2 = cordnate;
		for(var j = 0;j < mode; j++)
		{
			checkarray[1].push(cordnate);
			checkarray[2].push(cordnate_2);
			checkarray[3].push(0);
			checkarray[4].push(0);
			cordnate_2 = cordnate_2 + 30;
			if(j%side == side - 1)
			{
				cordnate = cordnate + 30;
				cordnate_2 = -cordnate_2 + 30;
			}
			

		}

	}
	else if(mode%2 == 0)
	{
		var cordnate = 15;
		var cordnate_2 = 0;
		var side = Math.sqrt(mode);
		for(var i = 0;i < side/2;i++)
		{
			xMarker[i] = cordnate;
			zMarker[i] = cordnate;
			cordnate = cordnate + 30;
		}
		cordnate = -(cordnate - 30);
		cordnate_2 = cordnate;
		for(var j = 0;j < mode; j++)
		{
			checkarray[1].push(cordnate);
			checkarray[2].push(cordnate_2);
			checkarray[3].push(0);
			checkarray[4].push(0);
			cordnate_2 = cordnate_2 + 30;
			if(j%side == side - 1)
			{
				cordnate = cordnate + 30;
				cordnate_2 = -cordnate_2 + 30;
			}
			
		}
	}
}