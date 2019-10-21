<?php

// Config
require_once('config/connect.php');

// Models
require_once('model/DatabaseModel.php');
require_once('model/LoginModel.php');
require_once('model/SessionModel.php');
require_once('model/RegisterModel.php');
require_once('model/DatabaseModel.php');
require_once('model/CalendarModel.php');

require_once('model/User.php');
require_once('model/RegisterNewUser.php');

// Require exceptions
require_once('model/Exceptions.php');

// Views
require_once('view/LoginView.php');
require_once('view/DateTimeView.php');
require_once('view/LayoutView.php');
require_once('view/RegisterView.php');
require_once('view/RegisterView.php');
require_once('view/CalendarView.php');

// Controllers
require_once('controller/LoginController.php');
require_once('controller/RegisterController.php');
require_once('controller/MainController.php');
require_once('controller/CalendarController.php');

// Config
require_once('config/Constants.php');

error_reporting(E_ALL);
ini_set('display_errors', 'On');

session_start();

// try {
//     $mc = new \controller\MainController();

//     $mc->renderView();
// } catch (\Exception $e) {
//     echo 'Caught exception: ',  $e->getMessage(), "<br> index.php";
// }

$mc = new \controller\MainController();

$mc->renderView();
