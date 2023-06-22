<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use DB;
// use App\Ac;

class User extends Authenticatable
{
    // -----
    public function getMembers($department)
    {
        $department_member = array();
        $d_head_id = '';

        $members = DB::table('users')
            ->select('id')
            ->where('department', $department)
            ->get();

        $d_head = DB::table('users')
            ->select('id')
            ->where('department_head', $department)
            ->get();

        foreach ($members as $m) {
            $department_member[] = $m->id;
            // echo $m->id . '<br>';
        }

        foreach ($d_head as $d_h) {
            $d_head_id = $d_h->id;
        }

        array_unshift($department_member, $d_head_id);

        return array_unique($department_member);
    }

    public function getAdmin()
    {
        $a_member = array();

        $admin_member = DB::table('users')
            ->select('id')
            ->where('admin', 'y')
            ->get();

        foreach ($admin_member as $a) {
            $a_member[] = $a->id;
        }

        return $a_member;
    }
    // -----

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
        // 'name', 'email', 'password', 'department', 'department_head', 'admin'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function hasManyInterviews()
    {
        return $this->hasMany('App\Interview', 'user_id', 'id');
    }

    public function isAdmin($u)
    {
        $admin_members = $this->getAdmin();

        return in_array($u, $admin_members);
    }

    public function ac($u, $u_id)
    {
        $sales = array();

        $ac_data = Ac::where('ac', $u)->get();

        if (count($ac_data) > 0) {
            foreach ($ac_data as $a) {
                $sales[] = $a->sales;
            }

            if (in_array($u_id, $sales)) {
                return true;
            }
        }
    }

    // ----- Sales -----
    public function isSales($u)
    {
        $members = $this->getMembers('sales');

        return in_array($u, $members);
    }

    public function isSalesAdmin($u)
    {
        $members = $this->getMembers('sales');

        return in_array($u, array($members[0]));
    }
    // ----- Sales -----

    // ----- MKTG -----
    public function isMKTG($u)
    {
        $members = $this->getMembers('mktg');

        return in_array($u, $members);
    }

    public function isMKTGAdmin($u)
    {
        $members = $this->getMembers('mktg');

        return in_array($u, array($members[0]));
    }
    // ----- MKTG -----

    // ----- Prog -----
    public function isProg($u)
    {
        $members = $this->getMembers('prog');

        return in_array($u, $members);
    }

    public function isProgAdmin($u)
    {
        $members = $this->getMembers('prog');

        return in_array($u, array($members[0]));
    }
    // ----- Prog -----
}
