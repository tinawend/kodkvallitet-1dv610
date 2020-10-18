<?php
namespace model;

class CookieModel {
    private static $cookieName = 'LoginView::CookieName';
    private static $cookiePassword = 'LoginView::CookiePassword';
    private static $name = 'LoginView::UserName';
    private static $password = 'LoginView::Password';
    private $salted = "rjdjsoojnnm334kjsjfjf9865vdjdpj2jd9WpQ";

    /**
     * setCookies
     *
     * @return void
     */
    public function setCookies() {
            setcookie(self::$cookieName, $_POST[self::$name], time() + (86400 * 30));
            setcookie(self::$cookiePassword,hash('sha256', $this->salted.$_POST[self::$password]), time() + (86400 * 30));
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