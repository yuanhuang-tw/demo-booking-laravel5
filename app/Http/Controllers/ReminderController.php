<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use App\Http\Requests;
use App\Interview;
use App\User;
use Mail;

class ReminderController extends Controller
{
		function reminder()
		{
				$check_day = strtotime("+14 Day");

				$interviews = Interview::where('i_date', date("Y-m-d", $check_day))->where('status', '')->get();

				foreach ($interviews as $i) {
						$u_data = User::findOrFail($i->user_id);

						Mail::queue('email.reminder', ['u_data' => $u_data, 'i' => $i], function($message) use($u_data, $i) {
								$message->to($u_data->email)->subject('Interview Reminder // Client: ' . $i->i_client);
						});
				}
		}
}
