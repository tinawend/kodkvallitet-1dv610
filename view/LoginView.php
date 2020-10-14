<?php

namespace view;
require_once('view/RegisterView.php');
// require_once('model/CookieModel.php');
// require_once('model/SessionState.php');
require_once('controller/LoginController.php');

class LoginView {
	private static $login = 'LoginView::Login';
	private static $logout = 'LoginView::Logout';
	private static $name = 'LoginView::UserName';
	private static $password = 'LoginView::Password';
	private static $cookieName = 'LoginView::CookieName';
	private static $cookiePassword = 'LoginView::CookiePassword';
	private static $keep = 'LoginView::KeepMeLoggedIn';
	private static $messageId = 'LoginView::Message';
	// private static $state = "LoggedIn";
	private static $sesUsername = "Username";
	private $message = '';
	// private $salted = "hej";
	// public $username = 'tw222eu';
	// public $passwrd = '12345';


	
	/**
	 * Create HTTP response
	 *
	 * Should be called after a login attempt has been determined
	 *
	 * @return  void BUT writes to standard output and cookies!
	 */
	public function response() {
		// $message = '';
		if(isset($_GET['register'])) {
			$r = new \view\RegisterView();
			$response = $r->response();
		} else {
			$log = new \controller\LoginController();
			$log->ifLoggedIn($this->message);
			$log->ifNotLoggedIn($this->message);

			if(isset($_COOKIE[self::$cookieName]) && isset($_COOKIE[self::$cookiePassword])){
				$log->checkCookies($this->message);
			}

			if(isset($_SESSION[self::$sesUsername]) || isset($_COOKIE[self::$cookieName]) && isset($_COOKIE[self::$cookiePassword])) {			
				$response = $this->generateLogoutButtonHTML();
				if(isset($_POST[self::$logout]) && $_POST[self::$logout]) {
					$log->LoggingOut($this->message);
					$response = $this->generateLoginFormHTML();
				}
			}else{
					$response = $this->generateLoginFormHTML();
			}
		
	}
		return $response;
	}

	
	public function renderRegisterOrLogin() {
		if(!isset($_GET['register'])) {
		  return '<a href="?register">Register a new user</a>';
		} else {
		  return '<a href="?">Back to login</a>';
		}
	  }
	/**
	* Generate HTML code on the output buffer for the logout button
	* @param $message, String output message
	* @return  void, BUT writes to standard output!
	*/
	public function generateLogoutButtonHTML() {
		return '
		<form  method="post" >
				<p id="' . self::$messageId . '">' . $this->message .'</p>
				<input type="submit" name="' . self::$logout . '" value="logout"/>
				</form>
		';
	}
	
	/**
	* Generate HTML code on the output buffer for the logout button
	* @param $message, String output message
	* @return  void, BUT writes to standard output!
	*/
	public function generateLoginFormHTML() {
		return '
			<form method="post" > 
				<fieldset>
					<legend>Login - enter Username and password</legend>
					<p id="' . self::$messageId . '">' . $this->message . '</p>
					
					<label for="' . self::$name . '">Username :</label>
					<input type="text" id="' . self::$name . '" name="' . self::$name . '" value= "' . $this->getRequestUserName() . '" />

					<label for="' . self::$password . '">Password :</label>
					<input type="password" id="' . self::$password . '" name="' . self::$password . '" />

					<label for="' . self::$keep . '">Keep me logged in  :</label>
					<input type="checkbox" id="' . self::$keep . '" name="' . self::$keep . '" />
					
					<input type="submit" name="' . self::$login . '" value="login" />
				</fieldset>
			</form>
		';
	}


	
	//CREATE GET-FUNCTIONS TO FETCH REQUEST VARIABLES
	private function getRequestUserName() {
		//RETURN REQUEST VARIABLE: USERNAME
		if(isset($_POST[self::$login]) && !empty($_POST[self::$name])) {
			$_SESSION[self::$sesUsername] = $_POST[self::$name];
			return $_SESSION[self::$sesUsername];
		}

	}
	
}