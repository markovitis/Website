<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Status;

class HomeController extends Controller
{
#should take $mode, of type string. Function used to be called 'index'
	public function index()
	{


		if (Auth::check()) {

			#should be if ($mode === ...)
			if ('popular' === 'popular')
			{
				# ORDER BY POPULARITY:

				#custom code here to allow all posts on feed:
				$statuses = Status::notReply()->where(function($query) {
					return $query;
				})
				->orderBy('score', 'desc') #order by most likes
				->paginate(6);
			} elseif ('mode' === 'recent')
			{

				#ORDER BY RECENT:

				$statuses = Status::notReply()->where(function($query) {
					return $query;
				})
				->orderBy('created_at', 'desc') #order by most likes
				->paginate(6);
			} else
			{
				# ORDER BY POPULARITY:

				#custom code here to allow all posts on feed:
				$statuses = Status::notReply()->where(function($query) {
					return $query;
				})
				->orderBy('score', 'desc') #order by most likes
				->paginate(6);
			}
			
			return view('timeline.index')
			->with('statuses', $statuses);
		}

		return view('home', ['']);
	}
}


# The following is the original code that limits the feed to just followers. This goes directly inside the public function index()

// if (Auth::check()) {
// 	#where / orWhere limits timeline to just friends.
// 	$statuses = Status::notReply()->where(function($query) {
// 		return $query->where('user_id', Auth::user()->id)->orWhereIn('user_id', Auth::user()->friends()->pluck('id'));
// 	})
// 	->orderBy('created_at', 'desc')
// 	->paginate(6);

// 	return view('timeline.index')
// 	->with('statuses', $statuses);
// }

// return view('home');