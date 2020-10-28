<?php

//require __DIR__.'/../vendor/autoload.php';
$client = Elasticsearch\ClientBuilder::create()->build();

$q=Request::get('q');

$params = [
        'index' => 'images',
        'body'  => [
            'query' => [
                'match' => [
                    'description' => $q
                ]
            ]
        ]
    ];


$query = $client->search($params);

if($query['hits']['total'] >=1)
    {
      $results = $query['hits']['hits'];
    }
  

if(isset($results)) {
    foreach($results as $r) {
    // echo $r['_source']['description'] ;
     echo nl2br("\r\n");
     
     $id= $r['_source']['patentID'];
     $str2 = substr($id, 1);
     $d=$r['_source']['figid'];
     echo $d;
     if ($d<=9){
     $fullid=$str2."-D0000".$d; 
           }       
     else{$fullid=$str2."-D000".$d; }

     $full="images\U$fullid.png";
     echo '<img class="grid-image" src="'.$full.'" width="100" height="100">';
     echo nl2br("\r\n");
     
     echo nl2br("\r\n\n\n");

//$image="images\USD0871716-20200107-D00005.png";
//echo '<img src="'.$image.'">';

    }
}


?>
