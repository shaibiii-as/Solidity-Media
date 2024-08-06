<?php





$method = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];


$data = array(
    'method' => $method,
    'uri' => $uri,
    'data' => $_POST
);

file_put_contents('./log_webhook_'.date("j.n.Y").'.log',json_encode($data).PHP_EOL, FILE_APPEND);

echo true;die();