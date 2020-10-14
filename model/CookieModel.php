<?php
namespace model;

class CookieModel {
    private static $cookieName = 'LoginView::CookieName';
    private static $cookiePassword = 'LoginView::CookiePassword';
    private static $name = 'LoginView::UserName';
    private static $password = 'LoginView::Password';
    private $salted = "hej";

public function setCookies() {
        setcookie(self::$cookieName, $_POST[self::$name], time() + (86400 * 30));
        setcookie(self::$cookiePassword,hash('sha256', $this->salted.$_POST[self::$password]), time() + (86400 * 30));
}

public function DeleteCookies() {
    session_unset();
    session_destroy();
    setcookie(self::$cookieName, "", time() - 3600);
    setcookie(self::$cookiePassword, "", time() - 3600);
}
}