<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use App\Http\Requests;
use App\Interview;
use App\User;
use App\Dj;
use Auth;
use DB;
use Mail;
use App\Http\Requests\StoreInterviewRequest;
use App\Http\Requests\uploadRequest;

class InterviewController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => [
            'showCalendar',
            'detail',
        ]]);
    }

    public function showCalendar($y = null, $m = null)
    {
        if (is_null($y)) {
            $y = date('Y');
        }

        if (is_null($m)) {
            $m = date('m');
        }

        if ($m == 01) {
            $last_year = $y - 1;
            $last_month = 12;
        } else {
            $last_year = $y;
            $last_month = $m - 1;
        }

        $last_month_btn = '/' . $last_year . '/' . str_pad($last_month, 2, "0", STR_PAD_LEFT);

        if ($m == 12) {
            $next_year = $y + 1;
            $next_month = '01';
        } else {
            $next_year = $y;
            $next_month = $m + 1;
        }

        $next_month_btn = '/' . $next_year . '/' . str_pad($next_month, 2, "0", STR_PAD_LEFT);

        // 星期中的第幾天，數字表示
        $the_day_of_the_week = date('w', mktime(0, 0, 0, $m, 1, $y));

        // 月份，完整的文本格式，例如 January 或者 March
        $m_full_text = date('F', mktime(0, 0, 0, $m, 1, $y));

        $d_day = date("Y-m-d", strtotime( "-$the_day_of_the_week days", strtotime("$y-$m-01") ));
        $d_last_day = date("Y-m-d", strtotime( "+41 days", strtotime($d_day) ));

        $interviews_in_this_month = DB::table('interviews')
            ->join('users', 'users.id', '=', 'interviews.user_id')
            ->orderBy(DB::raw('CAST(i_time AS UNSIGNED)'))
            ->whereBetween('i_date', [$d_day, $d_last_day])
            ->select('interviews.*', 'users.name')
            ->get();

        $all_interviews = array();

        foreach ($interviews_in_this_month as $interview) {
            $all_interviews[$interview->i_date][] = $interview;
        }

        return view(
            'interview.show_calendar',
            compact(
                'y',
                'm',
                'last_month_btn',
                'next_month_btn',
                'm_full_text',
                'the_day_of_the_week',
                'd_day',
                'all_interviews'
            )
        );
    }

    public function create(Request $request, $ymd = null)
    {
        if (!is_null($ymd)) {
            $ymd = $request->segment('2');
        }

        $client_list = DB::table('interviews')
            ->select(DB::raw('i_client, COUNT(`i_client`)'))
            ->where('user_id', '=', Auth::user()->id)
            ->groupBy('i_client')
            ->orderBy(DB::raw('COUNT(`i_client`)'), 'desc')
            ->take(16)
            ->get();

        // 取得 Programming user list
        $prog_user = User::where('department', 'prog')->get();

        foreach ($prog_user as $u) {
            $prog_user_arr[] = $u->id;
        }

        // id -> 28 (simon)
        $prog_user_arr[] = 28;

        // booking event 每週數量
        $booking_date = substr($ymd, 0, 4) . '-' . substr($ymd, 4, 2) . '-' . substr($ymd, 6, 2);
        $monday = date('Y-m-d', strtotime("$booking_date this week"));
        $friday = date('Y-m-d', strtotime("$booking_date this week +4 days"));

        $booking_in_this_week = DB::table('interviews')
            ->select('id')
            ->where('i_date', '>=', $monday)
            ->where('i_date', '<=', $friday)
            ->whereNotIn('user_id', $prog_user_arr)
            ->get();

        $booking_num_in_this_week = count($booking_in_this_week);

        return view(
            'interview.interview_create',
            compact('ymd', 'client_list', 'booking_num_in_this_week')
        );
    }

    // -----
    public function dj_not_here($r)
    {
        $h = explode(':', trim($r->time));

        $dj_not_here = Dj::where('date', trim($r->date))
            ->where('start_hour', '<=', $h[0])
            ->where('end_hour', '>', $h[0])
            ->get();

        return $dj_not_here;
    }
    // -----

    public function store(StoreInterviewRequest $request)
    {
        // -----
        $dj_not_here = $this->dj_not_here($request);

        if (count($dj_not_here) > 0) {
            foreach ($dj_not_here as $d) {
                return redirect('/create')->withInput()->withErrors($d->msg);
            }
        }
        // -----

        $i = new Interview;

        $i->contact = trim($request->contact);
        $i->i_date = trim($request->date);
        $i->i_time = trim($request->time);
        $i->i_client = trim($request->client);
        $i->s_status = trim($request->s_status);
        $i->i_type = trim($request->i_type);
        $i->language = trim($request->language);
        $i->tp = trim($request->tp);
        $i->interviewee = trim($request->interviewee);
        $i->additional = trim($request->additional);
        $i->pr = trim($request->pr);

        User::findOrFail(Auth::user()->id)->hasManyInterviews()->save($i);

        return redirect('/user')->with('status', 'Booking OK!');
    }

    public function listInterview(User $user)
    {
        if ($user->isAdmin(Auth::user()->id)) {
            $interviews = Interview::orderBy('id', 'desc')->paginate(50);
            $interviews_for_warning = Interview::orderBy('id', 'desc')->take(300)->get();
            $interviews_count = Interview::orderBy('id', 'desc')->count();

            return view(
                'interview.interview_list_admin',
                compact('interviews', 'interviews_count', 'interviews_for_warning')
            );
        } else {
            $interviews = Interview::where('user_id', Auth::user()->id)
                ->orderBy('id', 'desc')
                ->paginate(50);

            $interviews_count = Interview::where('user_id', Auth::user()->id)
                ->orderBy('id', 'desc')
                ->count();

            $interviews_greater_than_today = Interview::where('user_id', '<>', Auth::user()->id)
                ->where('i_date', '>', date("Y-m-d"))
                ->get();

            return view(
                'interview.interview_list',
                compact('interviews', 'interviews_count', 'interviews_greater_than_today')
            );
        }
    }

    public function detail(Interview $interview, User $user)
    {
        if (Auth::check()) {
            if ($user->isAdmin(Auth::user()->id)) {
                $department = 'admin';
            } elseif ($user->isSales(Auth::user()->id)) {
                $department = 'sales';
            } elseif ($user->isMKTG(Auth::user()->id)) {
                $department = 'mktg';
            } elseif ($user->isProg(Auth::user()->id)) {
                $department = 'prog';
            } else {
              $department = '';
            }
        } else {
            $department = '';
        }

        return view('interview.interview_detail', compact('interview', 'department'));
    }

    public function edit(Interview $interview, User $user)
    {
        $this->authorize('edit', $interview);

        if ($user->isAdmin(Auth::user()->id)) {
            return view('interview.interview_edit_admin', compact('interview'));
        } else {
            if ($interview->status == 'Approved') {
                return redirect()
                    ->back()
                    ->with('status', 'Booking has been approved, can NOT edit!!');
            }

            return view('interview.interview_edit', compact('interview'));
        }
    }

    public function update(Interview $interview, StoreInterviewRequest $request, User $user)
    {
        $this->authorize('update', $interview);

        // -----
        $dj_not_here = $this->dj_not_here($request);

        if (count($dj_not_here) > 0) {
            foreach ($dj_not_here as $d) {
                return redirect()->back()->withInput()->withErrors($d->msg);
            }
        }
        // -----

        $interview->contact = trim($request->contact);
        //
        if ($user->isAdmin(Auth::user()->id) || $interview->stage_1 != 'y') {
            $interview->i_date = trim($request->date);
            $interview->i_time = trim($request->time);
            $interview->i_client = trim($request->client);
        }
        //
        $interview->s_status = trim($request->s_status);
        $interview->i_type = trim($request->i_type);
        $interview->language = trim($request->language);
        $interview->tp = trim($request->tp);
        $interview->interviewee = trim($request->interviewee);
        $interview->additional = trim($request->additional);
        $interview->pr = trim($request->pr);

        if ($user->isAdmin(Auth::user()->id)) {
            $interview->stage_1 = trim($request->stage_1);
            $interview->department_status = trim($request->department_status);
            $interview->status = trim($request->status);
        }

        $interview->save();

        if ($request->status == 'Approved' || $request->status == 'Rejected') {
            // send email to Applicant
            $u_data = User::findOrFail($interview->user_id);

            Mail::queue(
                'email.prog',
                ['u_data' => $u_data, 'i' => $interview],
                function($message) use($u_data, $interview) {
                    $message
                        ->to($u_data->email)
                        ->subject('Programming ' . $interview->status . ' // Client: ' . $interview->i_client . ' (ID: ' . $interview->id . ')');
                }
            );
        }

        return redirect()
            ->action('InterviewController@detail', ['id' => $interview->id])
            ->with('status', 'Update OK!');
    }

    function destroy(Interview $interview, User $user)
    {
        $this->authorize('destroy', $interview);

        if ($user->isAdmin(Auth::user()->id)) {
            Interview::destroy($interview->id);
            return redirect('/user')->with('status', 'Delete OK!');
        } else {
            if ($interview->status == 'Approved') {
                return redirect()
                    ->back()
                    ->with('status', 'Booking has been approved, can NOT delete!!');
            }

            Interview::destroy($interview->id);

            return redirect('/user')->with('status', 'Delete OK!');
        }
    }

    public function upload(uploadRequest $request, Interview $interview)
    {
        $this->authorize('upload', $interview);

        $f = $request->file('file');

        $f->move(
            '/var/www/html/interview/public/download',
            $request->i_id . '.' . $f->getClientOriginalExtension()
        );

        $interview->file_name = $request->i_id . '.' . $f->getClientOriginalExtension();
        $interview->file = 'y';

        if ($f->getClientSize() > 1048575) {
            $interview->file_size = number_format(($f->getClientSize() / 1048576), 1, '.', '') . " MB";
        } elseif ($f->getClientSize() > 1023) {
            $interview->file_size = number_format(($f->getClientSize() / 1024), 1, '.', '') . " KB";
        }

        $interview->file_datetime = date("Y-m-d H:i:s");

        $interview->save();

        return redirect()->back()->with('status', 'Uploading OK!!');
    }
}
