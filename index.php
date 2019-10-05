<?php

// Config
require_once('config/connect.php');

// Models
require_once('model/DatabaseModel.php');
require_once('model/LoginModel.php');

// Views
require_once('view/LoginView.php');
require_once('view/DateTimeView.php');
require_once('view/LayoutView.php');

// Controllers
require_once('controller/LoginController.php');

error_reporting(E_ALL);
ini_set('display_errors', 'On');

$dbm = new \model\DatabaseModel();
$lm = new \model\LoginModel();

$v = new \view\LoginView($dbm);
$dtv = new \view\DateTimeView();
$lv = new \view\LayoutView();

$lc = new \controller\LoginController($v, $lm, $dbm);

$lc->login();

$lv->render(false, $v, $dtv, $lc);
