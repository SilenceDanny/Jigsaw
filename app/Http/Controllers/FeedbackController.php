<?php

namespace App\Http\Controllers;

use App\Puzzle;
use App\Feedback;

use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FeedbackController extends Controller
{
	public function Feedback(Request $request)
	{
		$message = $request->get('message');

	    $feedback = new Feedback;
	    $feedback->feedbacker = Auth::user()->name;
	    $feedback->email = Auth::user()->email;
	    $feedback->message = $message;
	    $feedback->save();

		return view('index');		
	}

	public function DeleteFeedback(Request $request)
	{
		$feedback_id = $request->get("feedback_id");

		Feedback::destroy($feedback_id);

		return view('viewfeedback');		
	}
}