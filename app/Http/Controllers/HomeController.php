<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Pusher\Pusher;

class HomeController extends Controller
{
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}

	/**
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		return view('home');
	}

	public function authenticate(Request $request)
	{
		$socketId = $request->socket_id;
		$channelName = $request->channel_name;

		$pusher = new Pusher('c6924610367b87a3fe9f', '34db91cd9c99b8b29b17', '604040', [
			'cluster' => 'ap2',
			'encrypted' => true
		]);

		$presence_data = [
			'name' => auth()->user()->name
		];
		$key = $pusher->presence_auth($channelName, $socketId, auth()->id(), $presence_data);

		return response($key);
	}
}
