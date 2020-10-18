<?php
namespace view;
require_once('controller/RegisterController.php');
class RegisterView {

	private static $name = 'RegisterView::UserName';
    private static $password = 'RegisterView::Password';
    private static $passwordRepeat = 'RegisterView::PasswordRepeat';
	private static $cookieName = 'RegisterView::CookieName';
	private static $cookiePassword = 'RegisterView::CookiePassword';
	private static $messageId = 'RegisterView::Message';
	private static $register = 'RegisterView::Register';
	private static $sesUsername = "Username";

	/**
	 * Create HTTP response
	 *
	 * Should be called after a register attempt has been determined
	 *
	 * @return  void BUT writes to standard output!
	 */
	public function response() {
		$message = '';

		if($_SERVER['REQUEST_METHOD'] == 'POST' && strlen($_POST[self::$name]) < 3) {
			$message .= 'Username has too few characters, at least 3 characters.';
		}
		if($_SERVER['REQUEST_METHOD'] == 'POST' && strlen($_POST[self::$password]) < 6) {
			$message .= 'Password has too few characters, at least 6 characters.';
		}

		if(isset($_POST[self::$register]) && strlen($_POST[self::$name]) >= 3 && strlen($_POST[self::$password]) >= 6 && $_POST[self::$password] == $_POST[self::$passwordRepeat]) {
			$rc = new \controller\RegisterController();
			$rc->saveUser();
		}

		$response = $this->generateRegisterFormHTML($message);
		return $response;
	}

	/**
	* Generate HTML code for register form.
	* @param $message, String output message
	* @return  void, BUT writes to standard output!
	*/
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

	

	/**
	 * getRequestUserName
	 *
	 * @return void session containing string of username for register input.
	 */
	private function getRequestUserName() {
		if(isset($_POST[self::$register]) && !empty($_POST[self::$name])) {
			$_SESSION[self::$sesUsername] = $_POST[self::$name];
			return $_SESSION[self::$sesUsername];
		}

	}
} 

