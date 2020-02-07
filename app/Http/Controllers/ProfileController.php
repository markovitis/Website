<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
	public function getProfile($username)
	{
		$user = User::where('username', $username)->first();

		if (!$user) {
			abort(404);
		}

		$statuses = $user->statuses()->notReply()->get();

		return view('profile.index')
		->with('user', $user)
		->with('statuses', $statuses)
		->with('authUserIsFriend', Auth::user()->isFriendsWith($user));
	}

	public function getEdit()
	{
		return view('profile.edit');
	}

	public function postEdit(Request $request)
	{
		$this->validate($request, [
			'first_name' => 'alpha|max:50',
			'last_name' => 'alpha|max:50',
			'location' => 'max:50',
			'party' => 'alpha|max:50',
		]);

		dd('all ok');
	}
}