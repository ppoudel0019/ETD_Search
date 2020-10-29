<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Advanced Search</title>

        <!-- Fonts -->

        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <!-- Styles milestone-2-->
        <link rel="stylesheet"  href="{{ asset('/css/StyleSheet.css') }}">
        
        <style>

            
        </style>
    </head>
    
    <body class="antialiased">
    
        
                <h1><form action="/search" method="POST"> 
               
                @csrf
                    <input class="border border-red-500" type="text" name="q" >
                    <input type="submit" value="Search" /> <i class="fa fa-search"></i></h1>
                    </form> 
                    <form action="{{URL::to('/advsearch')}}" method="POST">
                   {{ csrf_field() }}
		            <div class="form-box">
		           <button class ="search-btn" type="submit"> Advanced Search</button>
                     </form>
</div>


<?php

$client = Elasticsearch\ClientBuilder::create()->build();


$title=Request::get('title');
$author=Request::get('author');
$subject=Request::get('subject');
$date=Request::get('date');
$description=Request::get('description');


$q=$title." ".$author." ".$subject." ".$description." ".$date;
echo $q;

$params = [
    'index' => 'projectdata',
    'body'  => [
        'query'=> [
           'bool' => [
               'must' => [
                   'multi_match' => [
                   'query' => $q,
                   'fields' => ['title', 'contributor_author','description_abstract','publisher','type','contributor_department','identifier_uri','relation_haspart']
                   ]
                  ]
               ]
                   ],
      'size'=> 50
           ]
  
  ];

try{
$response = $client->search($params);

$score = $response['hits']['hits'][0]['_score'];

echo"
    <div>
       <b><i><p style='font-size: 15px;'>Total results found: ".sizeof($response['hits']['hits'][0]['_source'])."</p></b></i>
    </div>"
;
foreach( $response['hits']['hits'] as $source){
    echo "
    <div style='marigin: 10%'>
      <div style='border: 2px solid black; margin: 1%'>
        <b><p style='font-size:20px;'>".$source['_source']['title']."</p></b>
        <i><p class='type'>".$source['_source']['contributor_author']."</p></i>
        <p>".$source['_source']['publisher']."</p>
        <br>
        <a href=".$source['_source']['identifier_sourceurl'].">PDF for more details</a>
       
        
      </div>
    </div>";
    // <p> ".$source['_source']['relation_haspart']." </p>
      // foreach($source['relation_haspart'] as $pdf){
      // echo "<p>".$pdf."</p>
      // </div>";
      // }
}      
    
    
$doc = $response['hits']['hits'][0]['_source']['title'];

}
catch(Exception $e) {
    // var_dump($e->getMessage());
}

?>