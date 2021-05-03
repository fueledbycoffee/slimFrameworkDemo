<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Http\Response as Response;

require __DIR__ . '../../vendor/autoload.php';

// $config['displayErrorDetails'] = true;
$config['db']['host'] = "localhost";
$config['db']['user'] = "root";
$config['db']['pass'] = "YouShallNotPass";
$config['db']['dbname'] = "studentManagerDb";

$app = new \Slim\App(["settings" => $config]);
$container = $app->getContainer();


$container['db'] = function ($c) {
  $db = $c['settings']['db'];
  $pdo = new PDO(
    "mysql:host=" . $db['host'] . ";" .
    "dbname=" . $db['dbname'] . ";",
    $db['user'],
    $db['pass']
  );

  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
  return $pdo;
};

$app->get('/students', function(Request $request, Response $response) {
  $mapper = new StudentMapper($this->db);
  $students = $mapper->getStudents(true);

  return $response->withJson($students, 200);
});

$app->get('/students/{id}', function(Request $request, Response $response,array $args) {
  $id = $args["id"];
  $mapper = new StudentMapper($this->db);
  $student = $mapper->getStudentById($id, TRUE);

  return $response->withJson($student, 200);
});

$app->post('/students', function(Request $request, Response $response,array $args) {
  $body = $request->getBody();

  $content = $body->read($request->getHeader("Content-Length")[0]);

  $obj = json_decode($content, TRUE);
  
  $student = new StudentEntity($obj);
  $mapper = new StudentMapper($this->db);
  $rep = $mapper->create($student, TRUE);

  return $response->withJson(["message" => $rep], 200);
});


$app->run();
