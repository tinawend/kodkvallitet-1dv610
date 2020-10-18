<?php

//INCLUDE THE FILES NEEDED...
require_once('view/LoginView.php');
require_once('view/DateTimeView.php');
require_once('view/LayoutView.php');
require_once('view/GameView.php');
require_once('model/SessionState.php');

//MAKE SURE ERRORS ARE SHOWN... MIGHT WANT TO TURN THIS OFF ON A PUBLIC SERVER
error_reporting(E_ALL);
ini_set('display_errors', 'On');
ini_set('session.use_only_cookies', TRUE);                
ini_set('session.use_trans_sid', FALSE);
ini_set('session.cookie_httponly', TRUE);
ini_set('session.cookie_samesite', 'lax');
ini_set('session.use_strict_mode', TRUE);

session_start();
// // Change this to your connection info.
// $DATABASE_HOST = 'localhost';
// $DATABASE_USER = 'root';
// $DATABASE_PASS = '';
// $DATABASE_NAME = 'login';
// // Try and connect using the info above.
// $con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
// if ( mysqli_connect_errno() ) {
// 	// If there is an error with the connection, stop the script and display the error.
// 	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
// }


$v = new view\LoginView();
$dtv = new view\DateTimeView();
$lv = new view\LayoutView();
$gv = new view\GameView();

$sess = new model\SessionState();

$sess->changeState();
$lv->render($sess->isLoggedIn(), $v, $dtv);

