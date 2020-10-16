<?php
namespace model;
require_once('model/CookieModel.php');
require_once('controller/LoginController.php');
require_once('view/LoginView.php');
class SessionState {

    private $message = '';
	private $salted = "hej";
	public $username = 'tw222eu';
    public $passwrd = '12345';
    private static $state = "LoggedIn";
    private static $login = 'LoginView::Login';
	private static $logout = 'LoginView::Logout';
    private static $cookieName = 'LoginView::CookieName';
    private static $cookiePassword = 'LoginView::CookiePassword';
    private static $name = 'LoginView::UserName';
    private static $password = 'LoginView::Password';
    private static $sesUsername = "Username";



    public function changeState(){
        $log = new \controller\LoginController();
        $v = new \view\LoginView();
        $cm = new CookieModel();
        if($log->successLogin() || isset($_SESSION["Username"])){
            $log->ifLoggedIn();
    
            $_SESSION[self::$state] = true;
            $_SESSION[self::$sesUsername] = $this->username;

        }
        
        if(isset($_COOKIE[self::$cookieName]) && isset($_COOKIE[self::$cookiePassword])){
            if($log->successCookieLogin()) {
                $_SESSION[self::$state] = true;
			}
			
        }

        if(isset($_POST[self::$logout]) && $_POST[self::$logout]){

            $_SESSION[self::$state] = false;
        }

    }



    public function isLoggedIn() {
        if(isset($_SESSION[self::$state])){
            return $_SESSION[self::$state];
        }
        else {
            return $_SESSION[self::$state] = false;
        }
    }
    
}

