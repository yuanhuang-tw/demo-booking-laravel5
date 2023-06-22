<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use App\Http\Requests;
use App\Dj;
use App\Http\Requests\DjRequest;

class DjController extends Controller
{
		public function dj()
		{
				// 管理者權限才可執行

				return view('interview.dj');
		}

		public function djStore(DjRequest $request)
		{
				// 管理者權限才可執行

				$d = new Dj;

				$d->date = trim($request->date);
				$d->start_hour = trim($request->start_hour);
				$d->end_hour = trim($request->end_hour);
				$d->msg = trim($request->msg);

				$d->save();

				return redirect('/dj/list')->with('status', 'Submit OK!');
		}

		public function djList()
		{
				// 管理者權限才可執行

				$msg = Dj::orderBy('id', 'desc')->paginate(30);

				return view('interview.dj_list', compact('msg'));
		}

		function djDestroy(Dj $dj)
		{
				// 管理者權限才可執行

				Dj::destroy($dj->id);

				return redirect('/dj/list')->with('status', 'Delete OK!');
		}
}
