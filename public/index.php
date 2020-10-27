<?php

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

/*
|--------------------------------------------------------------------------
| Check If Application Is Under Maintenance
|--------------------------------------------------------------------------
|
| If the application is maintenance / demo mode via the "down" command we
| will require this file so that any prerendered template can be shown
| instead of starting the framework, which could cause an exception.
|
*/

if (file_exists(__DIR__.'/../storage/framework/maintenance.php')) {
    require __DIR__.'/../storage/framework/maintenance.php';
}

/*
|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
|
| Composer provides a convenient, automatically generated class loader for
| this application. We just need to utilize it! We'll simply require it
| into the script here so we don't need to manually load our classes.
|
*/

require __DIR__.'/../vendor/autoload.php';
$client = Elasticsearch\ClientBuilder::create()->build();

$json = '{
    "query" : {
        "match" : {
            "description" : "foot"
        }
    }
}';

$params = [
    'index' => 'images',
    'body'  => $json
];

$query = $client->search($params);

if($query['hits']['total'] >=1)
    {
      $results = $query['hits']['hits'];
    }
  

if(isset($results)) {
    foreach($results as $r) {
        echo $r['_source']['description'] ;
     echo nl2br("\r\n");
    }

//echo $results['hits']['hits'][0]['_source']['description'];
//echo nl2br("\r\n");
    }




//$doc   =$results['hits']['hits'][0]['_source']['figid'];


//print_r($doc);

//print_r($doc);


//print_r($description);
/*
|--------------------------------------------------------------------------
| Run The Application
|--------------------------------------------------------------------------
|
| Once we have the application, we can handle the incoming request using
| the application's HTTP kernel. Then, we will send the response back
| to this client's browser, allowing them to enjoy our application.
|
*/

$app = require_once __DIR__.'/../bootstrap/app.php';

$kernel = $app->make(Kernel::class);

$response = tap($kernel->handle(
    $request = Request::capture()
))->send();

$kernel->terminate($request, $response);
