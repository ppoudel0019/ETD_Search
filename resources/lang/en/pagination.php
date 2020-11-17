<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Pagination Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used by the paginator library to build
    | the simple pagination links. You are free to change them to anything
    | you want to customize your views to better match your application.
    |
    */

    'previous' => '&laquo; Previous',
    'next' => 'Next &raquo;',

];

/*


<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script
  src="https://code.jquery.com/jquery-3.5.1.js"
  integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc="
  crossorigin="anonymous"></script>
  
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.22/datatables.min.css"/>
 
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.22/datatables.min.js"></script>
    <style>
        mark{
            background: orange;
            color: black;
        }
    </style>
<!-- </style> -->
       <body>
       <form action="{{URL::to('/search')}}" method="POST" role="search">
        {{ csrf_field() }}
		  <div class="form-box">
		  <input type ="text" class="search" name="q" placeholder = "Search a book"> 
		  <button class ="search-btn" type="submit"> Search</button>
      </form>
      </div>
        <br>
        <br>
      <form action="{{URL::to('/advanced_search')}}" method="POST">
        {{ csrf_field() }}
		  <div class="form-box">
		  <button class ="search-btn" type="submit"> Advanced Search</button>
      </form>
      </div>
      <br>
      <!-- <form action="{{URL::to('/uploadfile')}}" method="POST">
        {{ csrf_field() }} -->
		  <!-- <div class="form-box">
		  <button class ="search-btn" type="submit"> Upload file</button> -->
      <!-- </form> -->
      
       <!-- <form action="{{URL::to('/search')}}" method="POST" role="search">
       
		  <div class="form-box">
		  <input type ="text" class="search" placeholder = "Search a book">
          <button class ="search-btn" type="button"> Search</button>
          </form> -->
          <!-- <button class ="search-btn" type="button"> Advanced Search</button> -->
      
                </div>
                </body>

<?php
// require '/usr/local/var/elasticsearch/examples-elasticsearch/vendor/autoload.php';
// require _DIR_.'../vendor/autoload.php';
require '/Users/anuradhamantena/WP/vendor/autoload.php';
// require 'vendor/autoload.php';
// use Elasticsearch\ClientBuilder;
$client = Elasticsearch\ClientBuilder::create()
//->setHosts($hosts)
->build();
$params = [
  'index' => 'projectdata',
//   "id" => "vXVDbXUB4eFHAaQOxlg-",
  'body'  => [
      'query'=> [
         'bool' => [
             'must' => [
                 'multi_match' => [
                 'query' => $q ?? '',
                 'fields' => ['title', 'degree_name', 'degree_level', 'description_abstract','publisher','type','contributor_department','identifier_uri','relation_haspart']
                 ]
                ]
             ]
                 ],
    'size'=> 1000
         ]
];
// try{
$response = $client->search($query);
$score = $response['hits']['hits'][0]['_score'];
$total = $response['hits']['total']['value'];
// echo"
//     <div>
//        <b><i><p style='font-size: 15px;'>Total results found: $total</p></b></i>
//     </div>"
// ;
// foreach( $response['hits']['hits'] as $source){
//   $ltitle= (isset($source['_source']['title'])? $source['_source']['title'] : "");
//   $ldeg= (isset($source['_source']['degree_grantor'])? $source['_source']['degree_grantor'] : "");
//   $lauthor = (isset($source['_source']['contributor_author']) ? $source['_source']['contributor_author'] : "");
//   $lpublisher= (isset($source['_source']['publisher']) ? $source['_source']['publisher'] : "");
//   $labs= (isset($source['_source']['description_abstract']) ? $source['_source']['description_abstract'] : "");
//   $lpdf= (isset($source['_source']['identifier_sourceurl']) ? $source['_source']['identifier_sourceurl'] : "");
//     echo "
//     nintest
//     <div style='marigin: 10%'>
//       <div style='border: 2px solid black; margin: 1%'>
//         <b><p style='font-size:20px;'>".$ltitle."</p></b>
//         <i><p class='type'>".$lauthor."</p></i>
//         <i><p class='type'>".$ldeg."</p></i>
//         <i><p>".$lpublisher."</p><i>
//         <a href=".$lpdf.">PDF details</a>
//         <br>
//         <p> ".$labs." </p>
        
//       </div>
//     </div>";


    // <p> ".$source['_source']['relation_haspart']." </p>
      // foreach($source['relation_haspart'] as $pdf){
      // echo "<p>".$pdf."</p>
      // </div>";
      // }
// } 
// }
// catch(Exception $e) {
//     // var_dump($e->getMessage());
// }     
 echo '
<table class="table table-stripped" id="dt1">
<thead>
<th>title</th>
<th>author</th>
<th>publisher</th>
<th>university</th>
</thead>
<tbody>';
  foreach( $response['hits']['hits'] as $source){
     $ltitle= (isset($source['_source']['title'])? $source['_source']['title'] : "");
  $ldeg= (isset($source['_source']['degree_grantor'])? $source['_source']['degree_grantor'] : "");
  $lauthor = (isset($source['_source']['contributor_author']) ? $source['_source']['contributor_author'] : "");
  $lpublisher= (isset($source['_source']['publisher']) ? $source['_source']['publisher'] : "");
  echo "<tr><td>".$ltitle."</td><td>".$lauthor."</td><td>".$ldeg."</td><td>".$lpublisher."</td></tr>";
}
  echo "</tbody></table>";
   
    
// $doc = $response['hits']['hits'][0]['_source']['title'];

// echo"--> in SERP";
//print_r($doc)
// echo "<h3>We indexed these.</h3>";
// print_r($params);
// echo "<h3><Response/h3>";
// print_r($response);
// echo "<br>";
?>
<script src="https://cdn.jsdelivr.net/mark.js/7.0.0/jquery.mark.min.js"></script>
<script>
$(document).ready( function () {
  var table = $('#dt1').DataTable( {
    "initComplete": function( settings, json ) {
      $("body").unmark().mark("{{$sparam}}"); 
    }
  });
  table.on( 'draw.dt', function () {
      $("body").unmark().mark("{{$sparam}}");
  } );      
} );
</script>




<script
        src="https://code.jquery.com/jquery-3.4.1.min.js"
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
        crossorigin="anonymous"></script>
    <script src="{{ asset('js/auto-complete.min.js') }}"></script>s
    <script>
        $(document).ready(function() {
            new autoComplete({
                selector: '#keyword-input',
                minChars: -1,
                source: async function(term, suggest){
                    term = term.toLowerCase();

                    let choices = await $.ajax({
                        method: 'GET',
                        url: '{{ url('api/auto-completes') }}?keyword=' + term
                    });
                    suggest(choices);
                }
            });
        })
    </script>