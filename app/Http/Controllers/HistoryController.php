<?php


namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\History;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\Builder;






class HistoryController extends Controller
{
    
public function store(Request $request)
{


    $request->validate([
        'title' => 'required',
        ]);
    $input=[];
    $input = $request->all();
     $input['title'] = $request->get('q');  
     history::create($input);

     return $history;
 
}
}