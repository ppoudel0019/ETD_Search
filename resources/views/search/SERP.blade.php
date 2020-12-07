<div style="margin-left:10%;margin-top:1%;">
@if (Route::has('login'))
                <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
                    @auth
                        <a href="{{ url('user/profile') }}" class="text-sm text-gray-700 underline">Profile</a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm text-gray-700 underline">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 underline">Register</a>
                        @endif
                    @endif
                </div>
                @endif

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

.NEWCLASS {
    font-family: FontAwesome;
}

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

.container {
  display: float;
  margin:5px;
}



</style>
<link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>

<script>
var recognition = new webkitSpeechRecognition();

recognition.onresult = function(event) { 
  var saidText = "";
  for (var i = event.resultIndex; i < event.results.length; i++) {
    if (event.results[i].isFinal) {
      saidText = event.results[i][0].transcript;
    } else {
      saidText += event.results[i][0].transcript;
    }
  }
  // Update Textbox value
  document.getElementById('speechText').value = saidText;
 
  // Search Posts
  searchPosts(saidText);
}

function startRecording(){
  recognition.start();
}

</script>
    
        <div class="content">
                <form action="/search" method="POST"> 
               
                @csrf
                <input class="border border-red-500" id='speechText' type="text" name="q" >
                <input class="NEWCLASS btn btn-warning" type='button' id='start' value='&#xf130;' onclick='startRecording();'>
                <input type="submit" value="Search" /> 
                    </form> 
                    <form action="{{URL::to('/advsearch')}}" method="POST">
                   {{ csrf_field() }}
                   <br>
		            
                   <h6><input type="submit" value="Advanced Search" /></h6>
                     </form> 
</div>
</div>


<?php

require '../vendor/autoload.php';

$q=Request('q');

$sql = "INSERT INTO history (title)
 VALUES ($q)"; 

$client = Elasticsearch\ClientBuilder::create()

->build();
$params = [
     'index' => 'projectdata',
      'body' => [
'query'=> [
     'bool' => [
        'must' => [
          'multi_match' => [
                'query' => 
                       $q ?? '',
                 'fields' => ['title', 'description_abstract','publisher','type','contributor_department','handle']
             ]
           ]
         ]
       ],

    'size'=> 100
   ]
];

$response = $client->search($params);

$total = $response['hits']['total']['value'];

echo'<div class="tcontent">';
echo "Searched for: ".$q;
echo "<br>";
echo "Total results: ".$total;
echo "<br>";
echo "<br>";

//table for results
echo '
<table class="table table-borderless" id="dt2">
<thead>
<th></th>
</thead>
<tbody>';



foreach( $response['hits']['hits'] as $source){
$title= (isset($source['_source']['title'])? $source['_source']['title'] : "");
$description= (isset($source['_source']['description_abstract'])? $source['_source']['description_abstract'] : "");
$publisher= (isset($source['_source']['publisher']) ? $source['_source']['publisher'] : "");
$sourceURL = (isset($source['_source']['identifier_uri']) ? $source['_source']['identifier_uri'] : ""); 
$pnum = (isset($source['_source']['handle']) ? $source['_source']['handle'] : ""); 

//$ploc = (isset($source['_source']['relation_haspart']) ? array($source['_source']['relation_haspart']) : "");


//table
echo "<tr><td><u><h5><a role='button' class='btn btn-link' href='".$sourceURL."' target='_blank'><div class='link'>$title</div></u></a>";



//$href="/dissertation/".$pnum."/".$pdfloc;
//echo $href;
//echo $pnum;
//$pdfloc=print_r($ploc,true);
//print_r(array_values($ploc));
//echo'<br>';
//var_dump($ploc);

$path="/Users/poojapoudel/desktop/webpro/public/dissertation/".$pnum."/";
//echo $path;


//scanning all directories
$dir=scandir($path); 


foreach($dir as $file){
  $fname=$path.$file;
  //echo $fname;
}

//if the file is pdf 
if(mime_content_type($fname)=='application/pdf')
{

$name="/dissertation/".$pnum."/".$file;

?>
<div class="container">
<x-jet-button class="ml-4">
<a  href='<?php echo $name; ?>'download>Download</a>
</x-jet-button>
</div>

<?php
}



if (Auth::check())
  { 
 ?>

<form method="POST" action="history" >
            @csrf
          
<input type="hidden" name="title" value="<? echo $title?>" />  
<input type="hidden" name="sourceURL" value="<? echo $sourceURL?>" />  
<input type="hidden" name="description" value="<? echo $description?>" />  
<input type="hidden" name="publisher" value="<? echo $publisher?>" /> 

<div class="container">
    <x-jet-button class="ml-4">
                 {{ __('Save') }}
                </x-jet-button>
             </div>   
                </form>
    
<?php
  }

  echo"<br>$description<br>$publisher<br>
  </td></tr>";

}
echo "</tbody></table>"; 
//table ends



//JS for pagination and highlight

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


</body>
</html>