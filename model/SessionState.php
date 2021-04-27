<?php
namespace model;
require_once('controller/LoginController.php');
require_once('view/LoginView.php');
class SessionState {

    private static $state = "LoggedIn";

	private static $logout = 'LoginView::Logout';
    private static $cookieName = 'LoginView::CookieName';
    private static $cookiePassword = 'LoginView::CookiePassword';

    private static $sesUsername = "Username";


    
    /**
     * changeState to true or false.
     *
     * @return void
     */
    public function changeState(){
        $log = new \controller\LoginController();
       
        if($log->successLogin()){
            $log->ifLoggedIn();
    
            $_SESSION[self::$state] = true;
            $_SESSION[self::$sesUsername] = $log->correctUsername();

        }
        
        if(isset($_COOKIE[self::$cookieName]) && isset($_COOKIE[self::$cookiePassword]) && $log->successCookieLogin()){
            
                $_SESSION[self::$state] = true;
			
			
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

    public function isUsernameSetSession() {
        return isset($_SESSION[self::$sesUsername]);
    }
    
}

