@extends('layouts.app')
<?php
    use App\Puzzle;
    $puzzles =App\Puzzle::all();
    $puzzleCnt = count($puzzles);
?>
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"><h1>My Puzzle</h1></div>
                @if($puzzleCnt>0)
                    @for ($i = 0; $i < $puzzleCnt; $i++)
                        <?php
                            $puzzle_choosen = $i;
                        ?>
                        @if($puzzles[$puzzle_choosen]->owner_id == Auth::user()->id)
                        <div class="panel-body">
		                    <div class="block" style="float: left;margin-left: 60px;">
		                        <form name="playExists" action="playExists" method="POST" enctype="multipart/form-data">
		                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
		                            <input type="hidden" name="Name" value={{$puzzles[$puzzle_choosen]->puzzle_name}}>
		                            <input type="hidden" name="ID" value={{$puzzles[$puzzle_choosen]->puzzle_id}}>
		                            <input type="hidden" name="Path" value={{$puzzles[$puzzle_choosen]->path}}>
		                            <input type="hidden" name="Mode" value={{$puzzles[$puzzle_choosen]->mode}}>
		                            <input type="image" src='{{$puzzles[$puzzle_choosen]->path}}' style="width: 200px; height: 200px">
		                        </form>
		                    </div>
		                	<div class="block" style="margin-left: 300px;">
		                		<h2>Name:{{$puzzles[$puzzle_choosen]->puzzle_name or 'Default'}}</h2>
		                        <h4>Mode:{{$puzzles[$puzzle_choosen]->mode or 'Default'}} Pieces</h4>
		                    </div>
		                </div>
		                @endif
                    @endfor
                @endif  
			</div>
		</div>
	</div>
</div>
@endsection