<?php
header('Access-Control-Allow-Origin: *');
require 'Slim/Slim.php';
\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();
$app->contentType('application/json');
$app->get('/getcareers(/)', function() {
    require 'projects/school/functions.php';
    $result = getcareers();
    echo $result;
});
$app->get('/getsubjects(/)', function() {
    require 'projects/school/functions.php';
    $result = getsubjects();
    echo $result;
});
$app->post('/newstudent(/)', function() {
    require 'projects/school/functions.php';
    $result = newstudent();
    echo $result;
});
$app->get('/getsubjectsearch(/)', function() {
    require 'projects/school/functions.php';
    $result = getsubjectsearch();    
    echo $result;
});/*
$app->post('/ligarValores(/)',function(){
require 'project/procedimientos/functions.php';
$result = ligarValores();
echo $result;
});

$app->get('/selectDpt(/)', function() {
    require 'projects/procedimientos/functions.php';
    $response = selectDpt();
    echo $response;
});
$app->get('/selectPdt(/)', function() {
    require 'projects/procedimientos/functions.php';
    $response = selectPdt();
    echo $response;
});
$app->get('/',function(){
   $response = array('status'=>true);
   echo json_encode($response);
});*/
$app->run();
?>
