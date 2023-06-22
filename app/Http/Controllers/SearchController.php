<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use App\Http\Requests;
use App\Interview;
use App\Http\Requests\SearchInterviewRequest;
use DB;

class SearchController extends Controller
{
    public function search()
    {
        return view('interview.search');
    }

    public function searchOutput(SearchInterviewRequest $request)
    {
        $interviews = Interview::whereBetween('i_date', [$request->date1, $request->date2])
            ->orderBy('i_date', 'asc');

        return view('interview.search', compact('interviews'));
    }
}
