<?php
#if (session_status() === PHP_SESSION_NONE) {
session_start();
#}

define("APP_PATH", __DIR__);
define("BASE_URL", "/");
require_once APP_PATH . "/controller/commonFunctions.php";
require_once APP_PATH . "/models/entities/router.php";
require_once APP_PATH . "/controller/userController.php";
require_once APP_PATH . "/controller/estimateController.php";
require_once APP_PATH . "/controller/customerController.php";
require_once APP_PATH . "/controller/homeController.php";
require_once APP_PATH . "/controller/productController.php";
require_once APP_PATH . "/controller/projectsController.php";
require_once APP_PATH . "/controller/testController.php";

$router = new Router();
// $method, $path, $controller, $action

//route test
$router->addRoute('GET', BASE_URL . 'test', 'testController', 'test');

//routes connection
$router->addRoute('GET', BASE_URL, 'UserController', 'formConnectUser');
try {
    $router->addRoute('POST', BASE_URL, 'UserController', 'connectUserController');
} catch (Exception $e) {
    $e->getMessage();
}
$router->addRoute('GET', BASE_URL . 'logout', 'UserController', 'disconnect');

// routes estimate
$router->addRoute('POST', BASE_URL . 'addCustomer', 'customerController', 'addCustomer');
$router->addRoute('GET', BASE_URL . 'searchCustomer', 'customerController', 'searchCustomer');
$router->addRoute('GET', BASE_URL . 'estimate', 'EstimateController', 'estimate');
$router->addRoute('GET', BASE_URL . 'newEstimate', 'EstimateController', 'newEstimatePage');
$router->addRoute('GET', BASE_URL . 'createEstimate', 'EstimateController', 'newEstimate');
$router->addRoute('GET', BASE_URL . 'searchEstimate', 'EstimateController', 'searchEstimateToModify');
$router->addRoute('GET', BASE_URL . 'modifyEstimate', 'EstimateController', 'modifyEstimate');
$router->addRoute('POST', BASE_URL . 'modifyEstimate', 'EstimateController', 'updateEstimate');
$router->addRoute('POST', BASE_URL . 'saveEstimate', 'EstimateController', 'saveEstimate');

//routes profile
$router->addRoute('GET', BASE_URL . 'profile', 'UserController', 'profile');
$router->addRoute('GET', BASE_URL . 'updateProfile', 'UserController', 'updateProfilePage');
$router->addRoute('POST', BASE_URL . 'updateProfile', 'UserController', 'updateProfile');
$router->addRoute('GET', BASE_URL . 'updatePassword', 'UserController', 'updatePasswordPage');
$router->addRoute('POST', BASE_URL . 'updatePassword', 'UserController', 'updatePassword');
$router->addRoute('GET', BASE_URL . 'usersAccount', 'UserController', 'usersAccountPage');
$router->addRoute('POST', BASE_URL . 'addUser', 'UserController', 'addUser');

//routes products
$router->addRoute('GET', BASE_URL . 'products', 'ProductController', 'products');
$router->addRoute('GET', BASE_URL . 'details', 'ProductController', 'details');
$router->addRoute('GET', BASE_URL . 'modify', 'ProductController', 'modifyProductPage');
$router->addRoute('POST', BASE_URL . 'modify', 'ProductController', 'modifyProduct');
$router->addRoute('GET', BASE_URL . 'delete', 'ProductController', 'deleteProduct');
$router->addRoute('POST', BASE_URL . 'create', 'ProductController', 'createProduct');

//routes compta
$router->addRoute('GET', BASE_URL . 'accounting', 'EstimateController', 'accountingPage');
$router->addRoute('GET', BASE_URL . 'estimateToRegister', 'EstimateController', 'estimateToRegister');
$router->addRoute('GET', BASE_URL . 'estimateRegistered', 'EstimateController', 'estimateRegistered');
$router->addRoute('POST', BASE_URL . 'registerdriver', 'estimateController', 'registerEstimate');

//routes projects
$router->addRoute('GET', BASE_URL . 'projects', 'ProjectsController', 'projectsPage');
$router->addRoute('POST', BASE_URL . 'editSituationPage', 'ProjectsController', 'editSituationPage');
$router->addRoute('POST', BASE_URL . 'saveSituation', 'ProjectsController', 'saveSituation');
$router->addRoute('POST', BASE_URL . 'orderPage', 'ProjectsController', 'orderPage');
$router->addRoute('POST', BASE_URL . 'saveOrder', 'ProjectsController', 'saveOrder');
$router->addRoute('POST', BASE_URL . 'resultsPage', 'ProjectsController', 'resultsPage');

//Ajax
$router->addRoute('POST', BASE_URL . 'verifyName', 'ProductController', 'verifyName');

$method = $_SERVER['REQUEST_METHOD'];
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$handler = $router->getHandler($method, $uri);

$controller = new $handler['controller']();
$action = $handler['action'];
$controller->$action();
