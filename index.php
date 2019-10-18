<?php

// Config
require_once('config/connect.php');

// Models
require_once('model/DatabaseModel.php');
require_once('model/LoginModel.php');
require_once('model/SessionModel.php');
require_once('model/RegisterModel.php');

require_once('model/UserModel.php');

// Require exceptions
require_once('model/PasswordsDoNotMatchException.php');
require_once('model/UsernameTooShortException.php');
require_once('model/PasswordsTooShortException.php');
require_once('model/UserAlreadyExistsException.php');

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
