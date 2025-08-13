<?php
header('Content-Type: text/html; charset=UTF-8');
mb_internal_encoding('UTF-8');
mb_http_output('UTF-8');

require_once "Controller/controller.php";
require_once "Model/Database.php";

$host = 'localhost';
$dbname = 'polyshop';
$username = 'root';
$password = '';

$db = new Database($host, $dbname, $username, $password);
$dbConnection = $db->connect();

$controller = new PageController($dbConnection);

$page = $_GET['page'] ?? 'home';
$controller->renderPage($page);

$db->disconnect();
?>
