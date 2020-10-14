<?php
namespace view;
class RegisterView {

	private static $name = 'RegisterView::UserName';
    private static $password = 'RegisterView::Password';
    private static $passwordRepeat = 'RegisterView::PasswordRepeat';
	private static $cookieName = 'RegisterView::CookieName';
	private static $cookiePassword = 'RegisterView::CookiePassword';
	private static $messageId = 'RegisterView::Message';
	private static $register = 'RegisterView::Register';
	private static $sesUsername = "Username";


	public function response() {
		$message = '';

		if($_SERVER['REQUEST_METHOD'] == 'POST' && strlen($_POST[self::$name]) < 3) {
			$message .= 'Username has too few characters, at least 3 characters.';
		}
		if($_SERVER['REQUEST_METHOD'] == 'POST' && strlen($_POST[self::$password]) < 6) {
			$message .= 'Password has too few characters, at least 6 characters.';
		}

		$response = $this->generateRegisterFormHTML($message);
		return $response;
	}

    public function generateRegisterFormHTML($message) {
		return '
			<form action="?register" method="post" > 
				<fieldset>
					<legend>Register a new user - write Username and password</legend>
					<p id="' . self::$messageId . '">' . $message . '</p>
					
					<label for="' . self::$name . '">Username :</label>
					<input type="text" id="' . self::$name . '" name="' . self::$name . '" value= "' . $this->getRequestUserName() . '" />

					<label for="' . self::$password . '">Password :</label>
                    <input type="password" id="' . self::$password . '" name="' . self::$password . '" />
                    
					<label for="' . self::$passwordRepeat . '">Password :</label>
					<input type="password" id="' . self::$passwordRepeat . '" name="' . self::$passwordRepeat . '" />
					
					<input id="' . self::$register . '" type="submit" name="' . self::$register . '" value="Register" />
				</fieldset>
			</form>
		';
	}

	private function getRequestUserName() {
		//RETURN REQUEST VARIABLE: USERNAME
		if(isset($_POST[self::$register]) && !empty($_POST[self::$name])) {
			$_SESSION[self::$sesUsername] = $_POST[self::$name];
			return $_SESSION[self::$sesUsername];
		}

	}
} 

