<?php

// Config
require_once('config/connect.php');

// Models
require_once('model/DatabaseModel.php');
require_once('model/LoginModel.php');
require_once('model/SessionModel.php');
require_once('model/RegisterModel.php');
require_once('model/DatabaseModel.php');
require_once('model/User.php');
require_once('model/RegisterNewUser.php');
require_once('model/Exceptions.php');
require_once('model/Note.php');

// Views
require_once('view/LoginView.php');
require_once('view/DateTimeView.php');
require_once('view/LayoutView.php');
require_once('view/RegisterView.php');
require_once('view/RegisterView.php');
require_once('view/CalendarView.php');
require_once('view/DayView.php');

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

$mc = new \controller\MainController();

$mc->renderView();
