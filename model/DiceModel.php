<?php
namespace model;


class DiceModel {
    private static $diceResult = 'Gameview::diceResult';
    private static $numberInput = 'GameView::numberInput';

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
        if(!isset($_SESSION['gameresult'])){

            $_SESSION['gameresult'] = 0;
        }
        if($_SESSION[self::$diceResult] == $_POST[self::$numberInput]){
            $_SESSION['gameresult'] += 5;
        } 
        if($_SESSION[self::$diceResult]-1 == $_POST[self::$numberInput]){
            $_SESSION['gameresult'] += 4;
        }
        if($_SESSION[self::$diceResult]+1 == $_POST[self::$numberInput]){
            $_SESSION['gameresult'] += 4;
        }
        else{
            $_SESSION['gameresult'] -= 1;
        }

        return $_SESSION['gameresult'];
    }
    public function resetScore() {
        session_unset();
        session_destroy();
    }

}