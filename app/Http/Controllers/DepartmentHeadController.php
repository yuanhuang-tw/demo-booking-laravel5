<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use App\Http\Requests;
use App\Interview;
use App\User;
use Auth;
use Mail;

class DepartmentHeadController extends Controller
{
    function sendToDepartmentHead(Interview $interview, User $user)
    {
        $this->authorize('send_to_department_head', $interview);

        if ($interview->s_status == 'Confirmed' && $interview->stage_1 != 'y') {
            if ($user->isSales(Auth::user()->id)) {
                $interview->stage_1 = 'y';
                $interview->stage_1_datetime = date("Y-m-d H:i:s");

                $interview->save();

                // send to Sales DH
                // $u_data = User::findOrFail($user->salesMember[0]);
                $u_data = User::findOrFail($user->getMembers('sales')[0]);

                Mail::queue(
                    'email.sendtohead',
                    ['u_data' => $u_data, 'i' => $interview],
                    function($message) use($u_data, $interview) {
                        $message
                            ->to($u_data->email)
                            ->subject('[Sales] Request Form // Client: ' . $interview->i_client . ' (ID: ' . $interview->id . ')');
                    }
                );
            }

            if ($user->isMKTG(Auth::user()->id)) {
                $interview->stage_1 = 'y';
                $interview->stage_1_datetime = date("Y-m-d H:i:s");

                $interview->save();

                // send to MKTG DH
                // $u_data = User::findOrFail($user->MKTGMember[0]);
                $u_data = User::findOrFail($user->getMembers('mktg')[0]);

                Mail::queue(
                    'email.sendtohead',
                    ['u_data' => $u_data, 'i' => $interview],
                    function($message) use($u_data, $interview) {
                        $message
                            ->to($u_data->email)
                            ->subject('[MKTG] Request Form // Client: ' . $interview->i_client . ' (ID: ' . $interview->id . ')');
                    }
                );
            }

            if ($user->isProg(Auth::user()->id)) {
                $interview->stage_1 = 'y';
                $interview->stage_1_datetime = date("Y-m-d H:i:s");

                $interview->save();

                // send to Prog DH
                // $u_data = User::findOrFail($user->progMember[0]);
                $u_data = User::findOrFail($user->getMembers('prog')[0]);

                Mail::queue(
                    'email.sendtohead',
                    ['u_data' => $u_data, 'i' => $interview],
                    function($message) use($u_data, $interview) {
                        $message
                            ->to($u_data->email)
                            ->subject('[Prog] Request Form // Client: ' . $interview->i_client . ' (ID: ' . $interview->id . ')');
                        // $message->to('yvonne@icrt.com.tw')->subject('[Prog] Request Form // Client: ' . $interview->i_client . ' (ID: ' . $interview->id . ')');
                    }
                );
            }

            return redirect()->back()->with('status', 'Send Request Form OK!');
        }

        return redirect()->back();
    }

    public function departmentHeadApprove(Interview $interview, User $user)
    {
        $this->authorize('department_head_control', $interview);

        if (
            $interview->s_status == 'Confirmed'
            && $interview->stage_1 == 'y'
            && $interview->department_status != 'Approved'
        ) {
            $interview->department_status = 'Approved';
            $interview->department_datetime = date("Y-m-d H:i:s");

            $interview->save();

            // send email to prog
            // $u_data = User::findOrFail($user->progMember[0]);
            $u_data = User::findOrFail($user->getMembers('prog')[0]);

            Mail::queue(
                'email.sendtoprog',
                ['u_data' => $u_data, 'i' => $interview],
                function($message) use($u_data, $interview) {
                    $message
                        ->to($u_data->email)
                        ->subject('Request Form // Client: ' . $interview->i_client . ' (ID: ' . $interview->id . ')');
                    // $message->to('yvonne@icrt.com.tw')->subject('Request Form // Client: ' . $interview->i_client . ' (ID: ' . $interview->id . ')');
                }
            );

            // send email to Applicant
            $applicant_data = User::findOrFail($interview->user_id);

            Mail::queue(
                'email.sendtoapplicant',
                ['applicant_data' => $applicant_data, 'i' => $interview],
                function($message) use($applicant_data, $interview) {
                    $message
                        ->to($applicant_data->email)
                        ->subject('Department Head Approved // Client: ' . $interview->i_client . ' (ID: ' . $interview->id . ')');
                }
            );

            return redirect()
                ->action('InterviewController@detail', ['id' => $interview->id])
                ->with('status', 'Request Form Approved!');
        }

        return redirect()
            ->action('InterviewController@detail', ['id' => $interview->id]);
    }

    public function departmentHeadReject(Interview $interview, User $user)
    {
        $this->authorize('department_head_control', $interview);

        if (
            $interview->s_status == 'Confirmed'
            && $interview->stage_1 == 'y'
            && $interview->department_status != 'Rejected'
        ) {
            $interview->department_status = 'Rejected';
            $interview->department_datetime = date("Y-m-d H:i:s");

            $interview->save();

            // send email to Applicant
            $applicant_data = User::findOrFail($interview->user_id);

            Mail::queue(
                'email.sendtoapplicant',
                ['applicant_data' => $applicant_data, 'i' => $interview],
                function($message) use($applicant_data, $interview) {
                    $message
                        ->to($applicant_data->email)
                        ->subject('Department Head Rejected // Client: ' . $interview->i_client . ' (ID: ' . $interview->id . ')');
                }
            );

            return redirect()
                ->action('InterviewController@detail', ['id' => $interview->id])
                ->with('status', 'Request Form Rejected!');
        }

        return redirect()
            ->action('InterviewController@detail', ['id' => $interview->id]);
    }
}
