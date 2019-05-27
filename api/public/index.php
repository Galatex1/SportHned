<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';
require '../includes/DbOperations.php';

$app = new \Slim\App([
    'settings'=>[
        'displayErrorDetails'=>true,
    ]
]);

 //$route = $app->getContainer()->get('request')->getUri()->getPath();

 //var_dump($route);

$DB = DbOperations::getDB(); 

function haveEmptyParameters($required_params, $request, $response){
    $error = false; 
    $error_params = '';
    $request_params = $request->getParsedBody(); 
    foreach($required_params as $param){
        if(!isset($request_params[$param]) || strlen($request_params[$param])<=0){
            $error = true; 
            $error_params .= $param .', ';
        }
    }
    if($error){
        $error_detail = array();
        $error_detail['error'] = true; 
        $error_detail['message'] = 'Required parameters ' . substr($error_params, 0, -2) . ' are missing or empty';
        $response->write(json_encode($error_detail));
    }
    return $error; 
}



$app->group('/api', function () use ($app, $DB) {

    $app->get('/', function(Request $request, Response $response) use ($DB){
        $file =  __DIR__ . "/UI/userInterface.php";
        $response->write(file_get_contents($file));
        return $response->withHeader('Content-type', 'text/html')
                        ->withStatus(201);
    });
        
    $app->group('/user', function () use ($app, $DB) {
        require __DIR__ . '/../src/routes/user.php';
    });

});



$app->run();