<?php

// Config
require_once('config/connect.php');

// Models
require_once('model/DatabaseModel.php');

// Views
require_once('view/LoginView.php');
require_once('view/DateTimeView.php');
require_once('view/LayoutView.php');

// Controllers
require_once('controller/LoginController.php');

error_reporting(E_ALL);
ini_set('display_errors', 'On');

$dm = new \model\DatabaseModel();

$lc = new \controller\LoginController();

$v = new \view\LoginView($dm, $lc);
$dtv = new \view\DateTimeView();
$lv = new \view\LayoutView();



$lv->render(false, $v, $dtv, $lc);
