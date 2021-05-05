<?php
namespace model;


class DiceModel {
    private static $diceResult = 'Gameview::diceResult';
    private static $numberInput = 'GameView::numberInput';
    private $gameResult = 'gameresult';
    /**
     * rollDice
     *
     * @return int session containing one random dice between 1-6.
     */
    public function rollDice():int {
        $_SESSION[self::$diceResult] = rand(1,6);
        return $_SESSION[self::$diceResult];
    }

    public function gameRules() {
        if(!isset($_SESSION[$this->gameResult])){

            $_SESSION[$this->gameResult] = 0;
        }
        if($_SESSION[self::$diceResult] == $_POST[self::$numberInput]){
            $_SESSION[$this->gameResult] += 5;
        } 
        if($_SESSION[self::$diceResult]-1 == $_POST[self::$numberInput]){
            $_SESSION[$this->gameResult] += 3;
        }
        if($_SESSION[self::$diceResult]+1 == $_POST[self::$numberInput]){
            $_SESSION[$this->gameResult] += 3;
        }
        else{
            $_SESSION[$this->gameResult] -= 2;
        }

        return $_SESSION[$this->gameResult];
    }
    public function resetScore() {
        $_SESSION[$this->gameResult] = 0;
    }

}