<?php

// Config
require_once('config/connect.php');

// Models
require_once('model/DatabaseModel.php');
require_once('model/LoginModel.php');
require_once('model/SessionModel.php');
require_once('model/RegisterModel.php');

// Views
require_once('view/LoginView.php');
require_once('view/DateTimeView.php');
require_once('view/LayoutView.php');
require_once('view/RegisterView.php');
require_once('view/RegisterView.php');

// Controllers
require_once('controller/LoginController.php');
require_once('controller/RegisterController.php');

error_reporting(E_ALL);
ini_set('display_errors', 'On');

session_start();

$dbm = new \model\DatabaseModel();
$lm = new \model\LoginModel();
$sm = new \model\SessionModel();
$rm = new \model\RegisterModel();

$v = new \view\LoginView($dbm);
$rv = new \view\RegisterView($dbm);
$dtv = new \view\DateTimeView();
$lv = new \view\LayoutView();
$rv = new \view\RegisterView();

$lc = new \controller\LoginController($v, $lm, $dbm, $sm);
$rc = new \controller\RegisterController($rv, $rm, $dbm);

$lc->login();
$rc->register();

$lv->render($sm->getLoggedIn(), $v, $dtv, $lc, $rv);

var_dump($_SESSION);