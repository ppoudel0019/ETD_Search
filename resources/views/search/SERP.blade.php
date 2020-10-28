
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Main Page</title>

        <!-- Fonts -->

        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <!-- Styles milestone-2-->
        <link rel="stylesheet"  href="{{ asset('/css/StyleSheet.css') }}">
        
        <style>
       
        
        
            
        </style>
    </head>
    
    <body class="antialiased">
    
        <div class="relative flex items-top justify-center min-h-screen bg-gray-100  sm:items-center sm:pt-0">
        <div class="center-screen">

        <div class="relative flex items-top justify-center min-h-screen bg-gray-100  sm:items-center sm:pt-0">
        <div class="center-screen">
                <h1><form action="/search" method="POST"> 
               
                @csrf
                    <input class="border border-red-500" type="text" name="q" >
                    <input type="submit" value="Search" /> <i class="fa fa-search"></i></h1>
                    </form> 
</div>


<?php

//require __DIR__.'/../vendor/autoload.php';
$client = Elasticsearch\ClientBuilder::create()->build();

$q=Request::get('q');

$params = [
    'scroll' => '30s',          // how long between scroll requests. should be small!
    'size'   => 50,
        'index' => 'images',
        'body'  => [
            'query' => [
                'match' => [
                    'description' => $q
                ]
            ]
        ]
    ];

//$query = $client->search($params);
$response = $client->search($params);

$maxScore = $response['hits']['max_score'];
echo $maxScore;
echo nl2br("\r\n");


while (isset($response['hits']['hits']) && count($response['hits']['hits']) > 0) {
    $results = $response['hits']['hits'];

    // **
    // Do your work here, on the $response['hits']['hits'] array
    foreach($results as $r){
    
    echo $r['_source']['description']; 
    echo nl2br("\r\n");
     $id= $r['_source']['patentID'];
     $str2 = substr($id, 1);
     $d=$r['_source']['figid'];
     echo $d;
     if ($d<=5){
     $fullid=$str2."-D0000".$d; }       
     else{$fullid=$str2."-D000".$d; }

     $full="images\U$fullid.png";
     echo '<img class="grid-image" src="'.$full.'" width="150" height="150">';
     echo nl2br("\r\n");
    
    echo nl2br("\r\n");
    ;}


    // When done, get the new scroll_id
    // You must always refresh your _scroll_id!  It can change sometimes
    $scroll_id = $response['_scroll_id'];

    // Execute a Scroll request and repeat
    $response = $client->scroll([
        'body' => [
            'scroll_id' => $scroll_id,  //...using our previously obtained _scroll_id
            'scroll'    => '30s'        // and the same timeout window
        ]
    ]);
}




?>

                                  
</body>
</html>

