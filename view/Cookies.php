<?php

namespace view;

require_once('controller/LoginController.php');
require_once('view/LoginView.php');
class Cookies {

    private static $cookieName = 'LoginView::CookieName';
	private static $cookiePassword = 'LoginView::CookiePassword';
    private $salted = "rjdjsoojnnm334kjsjfjf9865vdjdpj2jd9WpQ";

    public function cookieName() {
        return $_COOKIE[self::$cookieName];
    }
    
    public function cookiePassword() {
        return $_COOKIE[self::$cookiePassword];
    }

    public function issetCookieName(){
        return isset($_COOKIE[self::$cookieName]);
    }

    public function issetCookiePassword(){
        return isset($_COOKIE[self::$cookiePassword]);
    }

    public function hashPassword() {
        $log = new \controller\LoginController();
        return hash('sha256', $this->salted.$log->correctPassword());
    }
	/**
     * setCookies
     *
     * @return void
     */
    public function setCookies() {
        $lw = new \view\LoginView();
		setcookie(self::$cookieName, $lw->postName(), time() + (86400 * 30));
		setcookie(self::$cookiePassword, hash('sha256', $this->salted.$lw->postPassword()), time() + (86400 * 30));
}

   /**
     * DeleteCookies and destroy session.
     *
     * @return void
     */
    public function deleteCookies() {
        session_unset();
        session_destroy();
        setcookie(self::$cookieName, "", time() - 3600);
        setcookie(self::$cookiePassword, "", time() - 3600);
    }
}