<?php
namespace model;


class DiceModel {
    private static $diceResult = 'Gameview::diceResult';
    private static $numberInput = 'GameView::numberInput';
    private $gameResult = 'gameresult';
    private static $startScore = 0;
    private static $highestScore = 5;
    private static $middleScore = 3;
    private static $lowestScore = 2;
    /**
     * rollDice
     *
     * @return int session containing one random dice between 1-6.
     */
    public function rollDice():int {
        $_SESSION[self::$diceResult] = rand(1,6);
        return $_SESSION[self::$diceResult];
    }

    /**
     * gameRules
     * @return int session containing the calculated game result
     */
    public function gameRules() {
        if(!isset($_SESSION[$this->gameResult])){

            $_SESSION[$this->gameResult] = self::$startScore;
        }
        if($_SESSION[self::$diceResult] == $_POST[self::$numberInput]){
            $_SESSION[$this->gameResult] += self::$highestScore;
        } 
        if($_SESSION[self::$diceResult]-1 == $_POST[self::$numberInput]){
            $_SESSION[$this->gameResult] += self::$middleScore;
        }
        if($_SESSION[self::$diceResult]+1 == $_POST[self::$numberInput]){
            $_SESSION[$this->gameResult] += self::$middleScore;
        }
        else{
            $_SESSION[$this->gameResult] -= self::$lowestScore;
        }

        return $_SESSION[$this->gameResult];
    }

  
    public function resetScore() {
        $_SESSION[$this->gameResult] = self::$startScore;
    }

}