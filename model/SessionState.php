<?php
namespace model;
require_once('model/CookieModel.php');
require_once('controller/LoginController.php');
require_once('view/LoginView.php');
class SessionState {

    private $message = '';
	private $salted = "rjdjsoojnnm334kjsjfjf9865vdjdpj2jd9WpQ";
    private static $state = "LoggedIn";
    private static $login = 'LoginView::Login';
	private static $logout = 'LoginView::Logout';
    private static $cookieName = 'LoginView::CookieName';
    private static $cookiePassword = 'LoginView::CookiePassword';
    private static $name = 'LoginView::UserName';
    private static $password = 'LoginView::Password';
    private static $sesUsername = "Username";


    
    /**
     * changeState to true or false.
     *
     * @return void
     */
    public function changeState(){
        $log = new \controller\LoginController();
        $v = new \view\LoginView();
        $cm = new CookieModel();
        if($log->successLogin() || isset($_SESSION[self::$sesUsername])){
            $log->ifLoggedIn();
    
            $_SESSION[self::$state] = true;
            $_SESSION[self::$sesUsername] = $log->correctUsername();

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


    
    
    /**
     * isLoggedIn
     *
     * @return bool session containing a bool value.
     */
    public function isLoggedIn():bool {
        if(isset($_SESSION[self::$state])){
            return $_SESSION[self::$state];
        }
        else {
            return $_SESSION[self::$state] = false;
        }
    }
    
}

