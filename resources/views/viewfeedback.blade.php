@extends('layouts.app')
<?php
    use App\Feedback;
    $feedbacks =App\Feedback::all();
    $feedbackCnt = count($feedbacks);
?>
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"><h1>My Puzzle</h1></div>
                	@if($feedbackCnt == 0)
                	暂无反馈
                	@endif
                    @for ($i = 0; $i < $feedbackCnt; $i++)
                        <div class="panel-body">
		                    <h1>用户名：{{$feedbacks[$i]->feedbacker}}</h1>
		                    <h2>邮箱：{{$feedbacks[$i]->email}}</h2>
		                    <p>反馈内容：{{$feedbacks[$i]->message}}</p>
		                    <form action="deletefeedback" method="post" accept-charset="utf-8">
		                    	<input type="hidden" name="_token" value="{{ csrf_token() }}">
		                    	<input type="hidden" name="feedback_id" value="{{ $feedbacks[$i]->id }}">
		                    	<button type="submit">删除该反馈</button>
		                    </form>
		                </div>
                    @endfor
			</div>
		</div>
	</div>
</div>
@endsection