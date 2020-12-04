<?php


namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\History;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\Builder;






class HistoryController extends Controller
{
    



    public function create()
{
    
    return view('search.save');   
}

public function display()
{
    
    return view('search.mySearch');   
}





public function save(Request $request)
{
    $q= $request->input('q');
    return view('search.save')->with($q);   
}

public function remove(Request $request)
{
    

    $q= $request->input('q');

    
    return view('search.remove')->with($q);  

    
}


/*
public function advSERP(Request $request)
{
    $q= $request->input('q');
    //echo $q;
    return view('search.advSERP')->with($q);   
}


$history=new History;
    $history->title=request('title');
    $history->sourceURL=request('SourceURL');
    //$q= $request->input('title');
    //echo $q;
   
$request->validate([
        'title' => 'required',
        ]);
    $input=[];
    $input = $request->all();
     $input['title'] = $request->get('q');  
     history::create($input);

     return $history;
 
}





    public function create()
    {
        $history= new History;


        $history->title="what";
       $history->save(); 
       return Redirect::back();
    }
*/








}