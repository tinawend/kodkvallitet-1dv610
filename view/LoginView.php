<?php

namespace view;
require_once('view/GameView.php');
require_once('view/RegisterView.php');
require_once('view/Cookies.php');
require_once('model/SessionState.php');
require_once('controller/LoginController.php');

class LoginView {
	private static $login = 'LoginView::Login';
	private static $logout = 'LoginView::Logout';
	private static $name = 'LoginView::UserName';
	private static $password = 'LoginView::Password';
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
			$sess = new \model\SessionState();
			$log = new \controller\LoginController();
			$c = new \view\Cookies();

			$log->ifLoggedIn($this->message);
			$log->ifNotLoggedIn($this->message);
			if($c->issetCookieName() && $c->issetCookiePassword()){
				$log->checkCookies($this->message);
			}

			if($sess->isLoggedIn() || $c->issetCookieName() && $c->issetCookiePassword()) {			
				$response = $this->generateLogoutButtonHTML();
				if(isset($_POST[self::$logout]) && $_POST[self::$logout]) {
					$log->loggingOut($this->message);
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
	   * @return void but returns HTML.
	   */
	public function renderPlayDice() {
		$sess = new \model\SessionState();

		if($sess->isLoggedIn()){
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
	 * @return void session containing string of username for login input.
	 */
	private function getRequestUserName() {
		if(isset($_POST[self::$login]) && !empty($_POST[self::$name])) {
			$_SESSION[self::$sesUsername] = $_POST[self::$name];
			return $_SESSION[self::$sesUsername];
		}

	}


	// messages
	public function loggedInCookieMessage(&$message) {
		$message = 'Welcome back with cookie';
	}

	public function wrongCookieMessage(&$message) {
		$message = 'Wrong information in cookies';
	}
	
	public function missingUsernameMessage(&$message) {
		$message .= 'Username is missing';
	}

	public function missingPasswordMessage(&$message) {
		$message .= 'Password is missing';
	}

	public function wrongCredentialsMessage(&$message) {
		$message .= 'Wrong name or password';
	}

	public function welcomeMessage(&$message) {
		$message .= 'Welcome';
	}

	public function byeMessage(&$message) {
		$message = 'Bye bye!';
	}

	// posts
	public function issetPostLogin() {
		return isset($_POST[self::$login]);
	}

	public function postName() {
		return $_POST[self::$name];
	}

	public function postPassword() {
		return $_POST[self::$password];
	}

	public function postKeep() {
		return !empty($_POST[self::$keep]);
	}
}