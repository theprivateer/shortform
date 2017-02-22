<?php

namespace App\Http\Controllers\Communities;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SyndicationController extends Controller
{
    public function store(Request $request)
    {

    }

    public function edit()
    {
        return view('communities.syndication.edit');
    }
}
