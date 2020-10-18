<?php
namespace model;


class DiceModel {
    private static $diceResult = 'Gameview::diceResult';
    
    /**
     * rollDice
     *
     * @return int session containing one random dice between 1-6.
     */
    public function rollDice():int {
        $_SESSION[self::$diceResult] = rand(1,6);
        return $_SESSION[self::$diceResult];
    }
}