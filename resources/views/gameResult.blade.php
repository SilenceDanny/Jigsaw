@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Game Result</div>
                 <?php
                    use App\PuzzleRank;
                    $rankList =PuzzleRank::where('puzzle_id',$puzzle_id)
                                            ->orderby('time','asc')
                                            ->take(30)
                                            ->get();
                ?>
                @if(count($rankList)==0)
                    <div style="font-size:20px;line-height: 50px;color: #fff;font-weight: 600;background-color: #2C3E50">NO RECORD !</div>
                @endif
                @for ($i = 0; $i < count($rankList); $i++)
                    <?php
                        $rankHour = 0;
                        $rankMinute = 0;
                        $rankSecond = 0;
                        $rankTime = "";

                        $tempTime = $rankList[$i]->time;
                        $rankHour = floor($tempTime/3600);
                        $rankMinute = floor(($tempTime%3600)/60);
                        $rankSecond = floor($tempTime%60);
                        $rankTime = $rankTime.($rankHour<10?"0".$rankHour:$rankHour);
                        $rankTime = $rankTime.":";
                        $rankTime = $rankTime.($rankMinute<10?"0".$rankMinute:$rankMinute);
                        $rankTime = $rankTime.":";
                        $rankTime = $rankTime.($rankSecond<10?"0".$rankSecond:$rankSecond);
                    ?>
                    @if($rankList[$i]->player_id == Auth::user()->id)
                        <div class="panel-body" style="font-size: 30px">{{$i+1}}:{{$rankList[$i]->player_name}}</div>
                        <div class="panel-body" style="font-size: 30px">{{$rankTime}}</div>
                    @else
                        <div class="panel-body">{{$i+1}}:{{$rankList[$i]->player_name}}</div>
                        <div class="panel-body">{{$rankTime}}</div>
                    @endif
                @endfor

                <a href="/"><button>Return</button></a>
            </div>
        </div>
    </div>
</div>
@endsection
