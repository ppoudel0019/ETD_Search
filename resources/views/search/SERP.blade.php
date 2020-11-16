
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Search Page</title>

        <!-- Styles milestone-2-->
        <link rel="stylesheet"  href="{{ asset('/css/StyleSheet.css') }}">
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
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
		           <button class ="search-btn" type="submit">Advanced Search</button>
                     </form>
</div>


<?php

$client = Elasticsearch\ClientBuilder::create()->build();

$q=Request::get('q');

$params = [
  'index' => 'projectdata',
  'body'  => [
      'query'=> [
         'bool' => [
             'must' => [
                 'multi_match' => [
                 'query' => $q,
                 'fields' => ['description_abstract','title','contributor_author','contributor_department','subject','type','handle','publisher','contributor_comitteemember']
                 ]
                ]
             ]
                 ],
                 'size'=> 100
         ]

];

try{
$response = $client->search($params);

$score = $response['hits']['hits'][0]['_score'];
$doc = $response['hits']['total']['value'];

echo "Searched for: ".$q;
echo "<br>";
echo "Total results: ".$doc;
foreach( $response['hits']['hits'] as $source){
    echo "
    <div style='marigin: 10%'>
      <div style='border: 0.1px  margin: 3%'>

      <a href=".$source['_source']['identifier_sourceurl']."><p style='font-size:20px;'>".$source['_source']['title']."</p></b></a>
      <p class='type'>".$source['_source']['contributor_author']."</p>
      <p>".$source['_source']['publisher']."</p>
    
        <br>
      </div>
    </div>";
    
}      
    
    
$doc = $response['hits']['total']['value'];

}
catch(Exception $e) {
   
}

?>

</body>
</html>