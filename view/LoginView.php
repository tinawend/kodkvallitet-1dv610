<?php

namespace view;
require_once('view/GameView.php');
require_once('view/RegisterView.php');
require_once('model/CookieModel.php');
require_once('model/SessionState.php');
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
	private static $sesUsername = "Username";
	private $message = '';



	
	/**
	 * Create HTTP response
	 *
	 * Should be called after a login attempt has been determined
	 *
	 * @return  void BUT writes to standard output and cookies!
	 */
	public function response() {
		if(isset($_GET['playGame'])) {
		$gv = new \view\GameView();
		$response = $gv->response();
		}
		elseif(isset($_GET['register'])) {
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
					$log->LoggingOut($this->message, $response);
					$response = $this->generateLoginFormHTML();
				}
			}else{
					$response = $this->generateLoginFormHTML();
			}
		
	}
		return $response;
	}

		
	/**
	 * renderRegisterOrLogin  renders HTML link to register or login.
	 *
	 * @return string string of HTML.
	 */
	public function renderRegisterOrLogin():string {
		if(!isset($_GET['register'])) {
		  return '<a href="?register">Register a new user</a>';
		} else {
		  return '<a href="?">Back to login</a>';
		}
	  }
	  
	  
	  /**
	   * renderPlayDice renders HTML link to play dice game or login.
	   *
	   * @return string string of HTML.
	   */
	  public function renderPlayDice():string {
		$sess = new \model\SessionState();

		  if($sess->isLoggedIn() == true){
			if(!isset($_GET['playGame'])) {
			  return '<a href="?playGame">Play a game of dice</a>';
			}else {
			  return '<a href="?">Back to login</a>';
			}
			}
		}
	/**
	* Generate HTML code on the output buffer for the logout button
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
	* Generate HTML code for Login form.
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

	
	
	/**
	 * getRequestUserName
	 *
	 * @return string session containing string of username for login input.
	 */
	private function getRequestUserName():string {
		if(isset($_POST[self::$login]) && !empty($_POST[self::$name])) {
			$_SESSION[self::$sesUsername] = $_POST[self::$name];
			return $_SESSION[self::$sesUsername];
		}

	}
	
}