<?php
require '../vendor/autoload.php';

use App\Controller;


$method = $_SERVER['REQUEST_METHOD'];
$request = parse_url($_SERVER['REQUEST_URI'])['path'];
$input = json_decode(file_get_contents('php://input'),true);


$routes = require('./routes.php');
foreach($routes as $route){

  $regex = str_replace('/', '\/', 
    preg_replace('/\{.*\}/', '(\w+)', $route[1]));

  if($route[0] == $method && preg_match("/^$regex$/", $request, $matches)){
    
    $controller = new Controller;
    $func = $route[2];
    $response = $controller->$func($input, ...array_slice($matches, 1));
    
    header('Content-Type: application/json');
    http_response_code(200);
    echo json_encode($response);
    exit;
  }
}

http_response_code(404);
exit;