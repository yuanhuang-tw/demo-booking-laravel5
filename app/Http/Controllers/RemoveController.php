<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use App\Http\Requests;
use App\Interview;
use App\User;

class RemoveController extends Controller
{
		public function remove(User $user)
		{
				// 管理者權限才可執行

				$d = strtotime("-1 Day");
				$d2 = strtotime("-60 Day");

				Interview::where('i_date', '<=', date("Y-m-d", $d))->where('i_date', '>=', date("Y-m-d", $d2))
																													 ->where('status', '')
																													 ->delete();

				return redirect('/user')->with('status', 'Remove OK!');
		}
}
