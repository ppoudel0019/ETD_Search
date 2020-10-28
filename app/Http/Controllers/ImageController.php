<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;



class ImageController extends Controller
{
    public function search(Request $request)
{
    $q= $request->input('q');
    //echo $q;
    return view('search.SERP')->with($q);

   
    
    
}
}
