<?php

require_once('config/connect.php');

require_once('model/DatabaseModel.php');

require_once('view/LoginView.php');
require_once('view/DateTimeView.php');
require_once('view/LayoutView.php');

error_reporting(E_ALL);
ini_set('display_errors', 'On');

$dm = new \model\DatabaseModel();

$v = new \view\LoginView($dm);
$dtv = new \view\DateTimeView();
$lv = new \view\LayoutView();


$lv->render(false, $v, $dtv);
