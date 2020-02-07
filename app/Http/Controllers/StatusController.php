<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use App\Models\User;
use App\Models\Status;
use Illuminate\Http\Request;

class StatusController extends Controller
{
	public function postStatus(Request $request)
	{
		$this->validate($request, [
			'status' => 'required|max:1000',
		]);

		Auth::user()->statuses()->create([
			'body' => $request->input('status'),
		]);

		return redirect()
		->route('home')
		->with('info', 'Your status has been posted');
	}

	public function postReply(Request $request, $statusId)
	{
		$this->validate($request, [
			"reply-{$statusId}" => 'required|max:1000',
		], [
			'required' => 'The reply body is required.'
		]);

		$status = Status::notReply()->find($statusId);

		if (!$status) {
			return redirect()->route('home');
		}

		# This limits posts on Feed to only friends (followers). Don't want this for the general Feed or Friends feed.
		// if (!Auth::user()->isFriendsWith($status->user) && Auth::user()->id !== $status->user->id) {
		// 		return redirect()->route('home');
		// }

		$reply = Status::create([
			'body' => $request->input("reply-{$statusId}"),
		])->user()->associate(Auth::user());

		$status->replies()->save($reply);

		return redirect()->back();
	}

	public function getLike($statusId)
	{
		$status = Status::find($statusId);

		if (!$status) {
			return redirect()->route('home');
		}

		#This limits liking to only friends. Remove in Gugump build.
		// if (!Auth::user()->isFriendsWith($status->user)) {
		// 	return redirect()->route('home');
		// }

		if (Auth::user()->hasLikedStatus($status)) {
			return redirect()->back();
		}

		# In order to check for and remove any unlikes, have to do the opposite of ...->create([]); as above.
		if (Auth::user()->hasUnlikedStatus($status)) {
			$unlikeToRemove = $status->unlikes()->delete([]);

			DB::update("
				UPDATE statuses
				SET score = score + 1
				WHERE id = '".$statusId."'
			");

		} else {
			$like = $status->likes()->create([]);
			Auth::user()->likes()->save($like);

			DB::update("
				UPDATE statuses
				SET score = score + 1
				WHERE id = '".$statusId."'
			");
		}

		return redirect()->back();
	}

	// public function getClearLikesUnlikes($statusId)

	public function getUnlike($statusId)
	{
		$status = Status::find($statusId);

		if (!$status) {
			return redirect()->route('home');
		}

		if (Auth::user()->hasUnlikedStatus($status)) {
			return redirect()->back();
		}

		# In order to check for and remove any likes, have to do the opposite of ...->create([]); as above.
		if (Auth::user()->hasLikedStatus($status)) {
			$likeToRemove = $status->likes()->delete([]);

			DB::update("
				UPDATE statuses
				SET score = score - 1
				WHERE id = '".$statusId."'
			");

		} else {
			$unlike = $status->unlikes()->create([]);
			Auth::user()->unlikes()->save($unlike);

			DB::update("
				UPDATE statuses
				SET score = score - 1
				WHERE id = '".$statusId."'
			");

		}

		return redirect()->back();
	}
}