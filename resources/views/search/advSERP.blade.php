<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
@stack("styles")
<script
src="https://code.jquery.com/jquery-3.5.1.js"
integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc="
crossorigin="anonymous"></script>
@stack("scripts")
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.22/datatables.min.css"/>
<link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.22/datatables.min.js"></script>
<style>

.content {
  align:center;
  margin-top: 100px;
  margin-left: 600px;
  margin-bottom: 20px;
  max-width: 500px;
  
  font-size: 30px;
}
.tcontent{
  
  margin: 50px;
  
}
mark{
background: yellow;
color: black;
}


.text {
  display: block;
  width: 100ch;
  overflow: hidden;
  white-space: nowrap;
  text-overflow: ellipsis;
}

.link{
  color:blue;
  font-weight: bold;

}


</style>
<link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>




<body>
    
        <div class="content">
                <form action="/search" method="POST"> 
               
                @csrf
                    <input class="border border-red-500" type="text" name="q" >
                    <input type="submit" value="Search" /> 
                    </form> 
                    <form action="{{URL::to('/advsearch')}}" method="POST">
                   {{ csrf_field() }}
                   <br>
		            
                   <h3><input type="submit" value="Advanced Search" /></button></h3>
                     </form>
</div>
</div>


<?php

require '../vendor/autoload.php';

$client = Elasticsearch\ClientBuilder::create()->build();


$title=Request::get('title');
$author=Request::get('author');
$subject=Request::get('subject');
$date=Request::get('date');
$description=Request::get('description');


$q=$title." ".$author." ".$subject." ".$description." ".$date;


$params = [
    'index' => 'projectdata',
    'body'  => [
        'query'=> [
           'bool' => [
               'must' => [
                   'multi_match' => [
                   'query' => $q,
                   'fields' => ['title', 'contributor_author','description_abstract']
                   ]
                  ]
               ]
                   ],
      'size'=> 50
           ]
  
  ];


$response = $client->search($params);
$score = $response['hits']['hits'][0]['_score'];
$total = $response['hits']['total']['value'];

echo'<div class="tcontent">';

echo "Searched for: ".$q;
echo "<br>";
echo "Total results: ".$total;
echo "<br>";
echo "<br>";


echo '

<table class="table table-borderless" id="dt2">
<thead>
<th></th>



</thead>
<tbody>';

foreach( $response['hits']['hits'] as $source){
$ltitle= (isset($source['_source']['title'])? $source['_source']['title'] : "");
$description= (isset($source['_source']['description_abstract'])? $source['_source']['description_abstract'] : "");

$lauthor = (isset($source['_source']['contributor_author']) ? $source['_source']['contributor_author'] : "");
$lpublisher= (isset($source['_source']['publisher']) ? $source['_source']['publisher'] : "");
$sourceURL = (isset($source['_source']['identifier_uri']) ? $source['_source']['identifier_uri'] : ""); 
echo "<tr><td><u><h5><a role='button' class='btn btn-link' href='".$sourceURL."' target='_blank'><div class='link'>$ltitle</div></u></a><br>$description<br>$lpublisher</td></tr>";
}

echo "</tbody></table>";
$doc = $response['hits']['hits'][0]['_source']['title'];
?>


<script src="https://cdn.jsdelivr.net/mark.js/7.0.0/jquery.mark.min.js"></script>
<script>
$(document).ready( function () 
{

var table = $('#dt2').DataTable( { 
"searching": false,
"lengthMenu": [ 5,10, 25, 50, 75, 100 ],

"initComplete": function( settings, json ) {
$("body").unmark().mark("{{$q}}"); 
    }
});


table.on( 'draw.dt', function () {
$("body").unmark().mark("{{$q}}");
} ); 
}
 );
</script>


