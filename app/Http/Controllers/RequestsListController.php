<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use App\Http\Requests;
use App\Interview;
use App\User;
use Auth;

class RequestsListController extends Controller
{
    public function requestsList(User $user)
    {
        if (Auth::check()) {
            // echo 'Auth user id: ' . Auth::user()->id . '<br>';

            if ($user->isSalesAdmin(Auth::user()->id)) {
                $interviews = Interview::where('s_status', 'Confirmed')
                    ->where('stage_1', 'y')
                    ->where('status', '')
                    ->where('i_date', '>', date('Y-m-d'))
                    ->whereIn('user_id', $user->getMembers('saless'))
                    ->orderBy('id', 'desc')
                    ->get();
            } elseif ($user->isMKTGAdmin(Auth::user()->id)) {
                $interviews = Interview::where('s_status', 'Confirmed')
                    ->where('stage_1', 'y')
                    ->where('status', '')
                    ->where('i_date', '>', date('Y-m-d'))
                    ->whereIn('user_id', $user->getMembers('mktg'))
                    ->orderBy('id', 'desc')
                    ->get();
            }
            // elseif ($user->isProgAdmin(Auth::user()->id)) {
            //     $interviews = Interview::where('s_status', 'Confirmed')
            //         ->where('stage_1', 'y')
            //         ->where('status', '')
            //         ->whereIn('user_id', $user->progMember)
            //         ->orderBy('id', 'desc')
            //         ->get();
            // }
            else {
                $interviews = Interview::where('s_status', 'Confirmed')
                    ->where('stage_1', 'y')
                    ->where('status', '')
                    ->where('i_date', '>', date('Y-m-d'))
                    ->orderBy('id', 'desc')
                    ->get();
            }
        } else {
            $interviews = Interview::where('s_status', 'Confirmed')
                ->where('stage_1', 'y')
                ->where('status', '')
                ->where('i_date', '>', date('Y-m-d'))
                ->orderBy('id', 'desc')
                ->get();
        }

        return view('interview.request_list', compact('interviews'));
    }
}
