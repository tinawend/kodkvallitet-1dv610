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
    private $salted = "hej";
    private $message = '';


    public function correctUsername() {
        $strJsonFileContents = file_get_contents("users.json");
        $array = json_decode($strJsonFileContents, true);
        return $array['username'];
    }
    public function correctPassword() {
        $strJsonFileContents = file_get_contents("users.json");
        $array = json_decode($strJsonFileContents, true);
        return $array['password'];
    }

    public function successCookieLogin() {
		return $_COOKIE[self::$cookieName] == $this->correctUsername() && $_COOKIE[self::$cookiePassword] == hash('sha256', $this->salted.$this->correctPassword());
    }

    public function successLogin() {
		return isset($_POST[self::$login]) && $_POST[self::$name] == $this->correctUsername() && $_POST[self::$password] == $this->correctPassword();
    }
    
    public function checkCookies(&$message) {
		if(!isset($_SESSION[self::$sesUsername]) && $this->successCookieLogin()) {	
			$message = 'Welcome back with cookie';
		}
		if($_COOKIE[self::$cookieName] != $this->correctUsername() || $_COOKIE[self::$cookiePassword] != hash('sha256', $this->salted.$this->correctPassword())) {
			$message = 'Wrong information in cookies';
		}
	}

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
            // }

    }
    
    public function ifLoggedIn(){
        $cm = new \model\CookieModel();
            if(!empty($_POST[self::$keep])) {
                $cm->setCookies();
            }
    }

    public function LoggingOut(&$message){
        // $v = new \view\LoginView();
        $cm = new \model\CookieModel();
        // if(isset($_SESSION[self::$sesUsername]) || isset($_COOKIE[self::$cookieName]) && isset($_COOKIE[self::$cookiePassword])) {			
        //     $response = $v->generateLogoutButtonHTML();
        //     if(isset($_POST[self::$logout]) && $_POST[self::$logout]) {
            $cm->DeleteCookies();
            $message = 'Bye bye!';
            // $response = $v->generateLoginFormHTML();
            // }
        // }else{
        //     $response = $v->generateLoginFormHTML();
        // }
        // return $response;
    }
}