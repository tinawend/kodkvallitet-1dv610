<?php
namespace controller;
require_once('model/SessionState.php');
require_once('view/LoginView.php');
require_once('view/Cookies.php');

class LoginController {   
    // private static $login = 'LoginView::Login';
	private static $logout = 'LoginView::Logout';
    /**
     * correctUsername
     *
     * @return string string containg correct username.
     */
    public function correctUsername():string {
        $strJsonFileContents = file_get_contents("users.json");
        $array = json_decode($strJsonFileContents, true);
        return $array['username'];
    }    
   
    /**
     * correctPassword
     *
     * @return string string containing correct password.
     */
    public function correctPassword():string {
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
        $c = new \view\Cookies();
		return $c->cookieName() == $this->correctUsername() && $c->cookiePassword() == $c->hashPassword();
    }
    
    /**
     * successLogin
     *
     * @return void
     */
    public function successLogin() {
        $lw = new \view\LoginView();
		return $lw->issetPostLogin() && $lw->postName() == $this->correctUsername() && $lw->postPassword() == $this->correctPassword();
    }
        
    /**
     * checkCookies
     *
     * @param  mixed $message
     * @return void
     */
    public function checkCookies(&$message) {
        $lw = new \view\LoginView();
        $ss = new \model\SessionState();
        $c = new \view\Cookies();
		if(!$ss->isUsernameSetSession() && $this->successCookieLogin()) {
            $lw->loggedInCookieMessage($message);
		}
		if($c->cookieName() != $this->correctUsername() || $c->cookiePassword() != $c->hashPassword()) {
            $lw->wrongCookieMessage($message);
		}
	}
    
    /**
     * ifNotLoggedIn try to login.
     *
     * @param  mixed $message
     * @return void
     */
    public function ifNotLoggedIn(&$message) {
        $lw = new \view\LoginView();
		if($lw->issetPostLogin() && empty($lw->postName())){
            $lw->missingUsernameMessage($message);
		}
		elseif($lw->issetPostLogin() && empty($lw->postPassword())) {
            $lw->missingPasswordMessage($message);
		}
		elseif($lw->issetPostLogin() && $lw->postName() == $this->correctUsername() && $lw->postPassword() != $this->correctPassword()) {
            $lw->wrongCredentialsMessage($message);
		}
		elseif($lw->issetPostLogin() && $lw->postName() != $this->correctUsername() && $lw->postPassword() == $this->correctPassword()) {
            $lw->wrongCredentialsMessage($message);
        }
        elseif($lw->issetPostLogin() && $lw->postName() == $this->correctUsername() && $lw->postPassword() == $this->correctPassword()){
            $lw->welcomeMessage($message);
        }

    }

    
        
    /**
     * ifLoggedIn keep me logged in by setting cookies.
     *
     * @return void
     */
    public function ifLoggedIn() {
        $c = new \view\Cookies();
        $lw = new \view\LoginView();
        if($lw->postKeep()) {
            $c->setCookies();
        }
    }
    
    /**
     * LoggingOut
     *
     * @param  mixed $message
     * @return void
     */
    public function loggingOut(&$message) {
            $lw = new \view\LoginView();
            $c = new \view\Cookies();
            $c->deleteCookies();
            $lw->byeMessage($message);

    }
}