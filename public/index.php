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
//*$client = Elasticsearch\ClientBuilder::create()->build();



/*$client = Elasticsearch\ClientBuilder::create()->build();

$extension="json";
// $folder_name=11042;

$main_dir= new RecursiveDirectoryIterator('/Users/poojapoudel/desktop/dissertation');
// $path = '/Users/anuradhamantena/WP/dissertation/';
// $c=0;
foreach (new RecursiveIteratorIterator($main_dir) as $key => $folder_name) {

    $ext = pathinfo($folder_name, PATHINFO_EXTENSION);
    if($ext == $extension) {
        // $file = '11042/11042.json';
        $json = file_get_contents($folder_name);
        // print($json);
        $params = [
  'index' => 'projectsdata',
  'body'  => $json
        ];

        try{
            $response = $client->index($params);
        } catch(Exception $e) {

            }
        }
    }
      function sendResponseToElasticSearch($params){
          $client = $GLOBALS["client"];
          print_r($client);
      }

*/
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
