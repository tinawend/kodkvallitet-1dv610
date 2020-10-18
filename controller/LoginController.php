<?php
namespace controller;
require_once('model/SessionState.php');

class LoginController {
    private static $login = 'LoginView::Login';
	private static $logout = 'LoginView::Logout';
	private static $name = 'LoginView::UserName';
    private static $password = 'LoginView::Password';
    private static $cookieName = 'LoginView::CookieName';
    private static $cookiePassword = 'LoginView::CookiePassword';
    private static $sesUsername = "Username";
    private static $keep = 'LoginView::KeepMeLoggedIn';
    private $salted = "rjdjsoojnnm334kjsjfjf9865vdjdpj2jd9WpQ";
    private $message = '';

    
   
    /**
     * correctUsername
     *
     * @return array array containg correct username.
     */
    public function correctUsername():array {
        $strJsonFileContents = file_get_contents("users.json");
        $array = json_decode($strJsonFileContents, true);
        return $array['username'];
    }    
   
    /**
     * correctPassword
     *
     * @return array array containing correct password.
     */
    public function correctPassword():array {
        $strJsonFileContents = file_get_contents("users.json");
        $array = json_decode($strJsonFileContents, true);
        return $array['password'];
    }
    
    /**
     * successCookieLogin
     *
     * @return void
     */
    public function successCookieLogin() {
		return $_COOKIE[self::$cookieName] == $this->correctUsername() && $_COOKIE[self::$cookiePassword] == hash('sha256', $this->salted.$this->correctPassword());
    }
    
    /**
     * successLogin
     *
     * @return void
     */
    public function successLogin() {
		return isset($_POST[self::$login]) && $_POST[self::$name] == $this->correctUsername() && $_POST[self::$password] == $this->correctPassword();
    }
        
    /**
     * checkCookies
     *
     * @param  mixed $message
     * @return void
     */
    public function checkCookies(&$message) {
		if(!isset($_SESSION[self::$sesUsername]) && $this->successCookieLogin()) {	
			$message = 'Welcome back with cookie';
		}
		if($_COOKIE[self::$cookieName] != $this->correctUsername() || $_COOKIE[self::$cookiePassword] != hash('sha256', $this->salted.$this->correctPassword())) {
			$message = 'Wrong information in cookies';
		}
	}
    
    /**
     * ifNotLoggedIn try to login.
     *
     * @param  mixed $message
     * @return void
     */
    public function ifNotLoggedIn(&$message) {

		if(isset($_POST[self::$login]) && empty($_POST[self::$name])){
			$message .= 'Username is missing';
		}
		elseif(isset($_POST[self::$login]) && empty($_POST[self::$password])) {
			$message .= 'Password is missing';
		}
		elseif(isset($_POST[self::$login]) && $_POST[self::$name] == $this->correctUsername() && $_POST[self::$password] != $this->correctPassword()) {
			$message .= 'Wrong name or password';
		}
		elseif(isset($_POST[self::$login]) && $_POST[self::$name] != $this->correctUsername() && $_POST[self::$password] == $this->correctPassword()) {
			$message .= 'Wrong name or password';
        }
        elseif(isset($_POST[self::$login]) && $_POST[self::$name] == $this->correctUsername() && $_POST[self::$password] == $this->correctPassword()){
            $message .= 'Welcome';
        }

    }
        
    /**
     * ifLoggedIn keep me logged in by setting cookies.
     *
     * @return void
     */
    public function ifLoggedIn(){
        $cm = new \model\CookieModel();
        if(!empty($_POST[self::$keep])) {
            $cm->setCookies();
        }
    }
    
    /**
     * LoggingOut
     *
     * @param  mixed $message
     * @return void
     */
    public function LoggingOut(&$message){

        $cm = new \model\CookieModel();
        $cm->DeleteCookies();
        $message = 'Bye bye!';
    }
}