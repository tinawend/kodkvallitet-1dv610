<?php
require_once('view/RegisterView.php');


class LoginView {
	private static $login = 'LoginView::Login';
	private static $logout = 'LoginView::Logout';
	private static $name = 'LoginView::UserName';
	private static $password = 'LoginView::Password';
	private static $cookieName = 'LoginView::CookieName';
	private static $cookiePassword = 'LoginView::CookiePassword';
	private static $keep = 'LoginView::KeepMeLoggedIn';
	private static $messageId = 'LoginView::Message';
	private static $state = "LoggedIn";
	private static $sesUsername = "Username";
	private $message = '';
	private $salted = "hej";
	public $username = 'tw222eu';
	public $passwrd = '12345';


	public function successLogin() {
		return isset($_POST[self::$login]) && $_POST[self::$name] == $this->username && $_POST[self::$password] == $this->passwrd;
	}

	public function successCookieLogin() {
		return $_COOKIE[self::$cookieName] == $this->username && $_COOKIE[self::$cookiePassword] == hash('sha256', $this->salted.$this->passwrd);
	}

	public function checkCookies() {
		if(!isset($_SESSION[self::$sesUsername]) && $this->successCookieLogin()) {	
			$this->message = 'Welcome back with cookie';
		}
		if($_COOKIE[self::$cookieName] != $this->username || $_COOKIE[self::$cookiePassword] != hash('sha256', $this->salted.$this->passwrd)) {
			$this->message = 'Wrong information in cookies';
		}
	}


	public function stateChanger() {
		 $_SESSION[self::$state] = false;

		if($this->successLogin() || isset($_SESSION["Username"])) {
			if($this->isLoggedIn() == false) {
				
				if($this->successLogin()) {
				$this->message .= 'Welcome';
				}
			}				
			$_SESSION[self::$state] = true;
			$_SESSION[self::$sesUsername] = $this->username;

		} else {
			$_SESSION[self::$state] = false;
		}
		
		if(isset($_COOKIE[self::$cookieName]) && isset($_COOKIE[self::$cookiePassword])) {
			if($this->successCookieLogin()) {
				$_SESSION[self::$state] = true;
			}
			$this->checkCookies();
		}

		if(isset($_POST[self::$logout]) && $_POST[self::$logout]) {
			$_SESSION[self::$state] = false;
		}
	}

	public function isLoggedIn() {
		return $_SESSION[self::$state];
	}
	
	public function setCookies() {
			setcookie(self::$cookieName, $_POST[self::$name], time() + (86400 * 30));
			setcookie(self::$cookiePassword,hash('sha256', $this->salted.$_POST[self::$password]), time() + (86400 * 30));
	}
	
	public function DeleteCookies() {
		session_unset();
		session_destroy();
		setcookie(self::$cookieName, "", time() - 3600);
		setcookie(self::$cookiePassword, "", time() - 3600);
	}

	
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
			$r = new RegisterView();
			$response = $r->response();
		} else {

			if($this->isLoggedIn() == false) {

				if(isset($_POST[self::$login]) && empty($_POST[self::$name])){
					$this->message .= 'Username is missing';
				}
				elseif(isset($_POST[self::$login]) && empty($_POST[self::$password])) {
					$this->message .= 'Password is missing';
				}
				elseif(isset($_POST[self::$login]) && $_POST[self::$name] == $this->username && $_POST[self::$password] != $this->passwrd) {
					$this->message .= 'Wrong name or password';
				}
				elseif(isset($_POST[self::$login]) && $_POST[self::$name] != $this->username && $_POST[self::$password] == $this->passwrd) {
					$this->message .= 'Wrong name or password';
				}
			}
			elseif($this->isLoggedIn() == true) {
				if(!empty($_POST[self::$keep])) {
					$this->setCookies();
				}
			}

			if(isset($_SESSION[self::$sesUsername]) || isset($_COOKIE[self::$cookieName]) && isset($_COOKIE[self::$cookiePassword])) {			
				$response = $this->generateLogoutButtonHTML();
				if(isset($_POST[self::$logout]) && $_POST[self::$logout]) {
							$this->DeleteCookies();
							$this->message = 'Bye bye!';
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
	private function generateLogoutButtonHTML() {
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
	private function generateLoginFormHTML() {
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