<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\Builder;



class ImageController extends Controller
{
    public function search(Request $request)
{
    $q= $request->input('q');
    //echo $q;
    return view('search.SERP')->with($q);   
}


public function advsearch(Request $request)
{
    $q= $request->input('q');
    //echo $q;
    return view('search.adv')->with($q);   
}



public function advSERP(Request $request)
{
    $q= $request->input('q');
    //echo $q;
    return view('search.advSERP')->with($q);   
}




}
