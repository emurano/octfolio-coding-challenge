<?php

use EricMurano\Controllers\TransactionReportController;
use EricMurano\Core\Configuration\AppConfiguration;
use EricMurano\Core\Database\DatabaseFactory;
use EricMurano\Core\Http\HttpRequest;
use EricMurano\Core\Http\SiteMetadata;
use EricMurano\Core\Http\HttpResponse;

require_once '../vendor/autoload.php';

$appConfig = new AppConfiguration(dirname(__FILE__) . '/../config.ini');
$dbFactory = new DatabaseFactory($appConfig);
//$dbConnection = new PDO(
//    $appConfig->getSetting('database.type')
//        . ':dbname=' . $appConfig->getSetting('database.name')
//        . ';host=' . $appConfig->getSetting('database.host')
//        . ';port=' . $appConfig->getSetting('database.port'),
//    $appConfig->getSetting('database.user'),
//    $appConfig->getSetting('database.password')
//);
$request = new HttpRequest($_GET, $_SERVER);
$siteMetadata = new SiteMetadata($_SERVER);

// If the client is request the home page, give them the react application
if ($request->path() == '/') {
    $baseUrl = $siteMetadata->baseUrl('/');
    $dataUrl = $baseUrl . '/api/data';
    include '../resources/views/index.php';

} else if ($request->path() == '/api/data') {
    $response = new HttpResponse();
    $controller = new TransactionReportController($dbFactory);
    $controller->handleGet($request, $response, $siteMetadata);
    $response->sendToClient();
} else {
    echo "Show them a 404";
}
