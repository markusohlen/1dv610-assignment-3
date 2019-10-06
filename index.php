<?php

// Config
// require_once('config/connect.php');

// Models
require_once('./model/DatabaseModel.php');
require_once('./model/LoginModel.php');
require_once('./model/SessionModel.php');

// Views
require_once('./view/LoginView.php');
require_once('./view/DateTimeView.php');
require_once('./view/LayoutView.php');

// Controllers
require_once('./controller/LoginController.php');

error_reporting(E_ALL);
ini_set('display_errors', 'On');

session_start();

$dbm = new \model\DatabaseModel();
$lm = new \model\LoginModel();
$sm = new \model\SessionModel();

$v = new \view\LoginView($dbm);
$dtv = new \view\DateTimeView();
$lv = new \view\LayoutView();

$lc = new \controller\LoginController($v, $lm, $dbm, $sm);

$lc->login();

$lv->render($sm->getLoggedIn(), $v, $dtv, $lc);

var_dump($_SESSION);