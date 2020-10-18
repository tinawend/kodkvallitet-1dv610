<?php

namespace view;

require_once('model/DiceModel.php');

class GameView {
	private static $playGame = 'GameView::playGame';
    private static $messageId = 'GameView::Message';
    private static $numberInput = 'GameView::numberInput';
    private static $diceResult = 'Gameview::diceResult';
	
	/**
	 * response
	 *
	 * @return void BUT writes to standard output
	 */
	public function response() {
        $message = 'Type a number and press Roll Dice to start a new game!';
        $response = $this->generateGameFormHTML($message);
        

        return $response;

    }    
    /**
     * generateGameFormHTML
     *
     * @param  mixed $message
     * @return void BUT writes to standard output
     */
    public function generateGameFormHTML($message) {
        return '
            <form action="?playGame" method="post"> 
            <fieldset>
            <legend>Play a game of dice</legend>
            <p id="' . self::$messageId . '">' . $message . '</p>
            <input id = "' . self::$numberInput . '" type="number" maxlength="1" name="' . self::$numberInput . '"/>
            <input id="' . self::$playGame . '" type="submit" name="' . self::$playGame . '" value="Roll Dice" />
            </fieldset>
            </form>
            ';
    }
    
    /**
     * playGame
     *
     * @return void but returns HTML img element.
     */
    public function playGame() {
        $pdc = new \model\DiceModel();
        if(isset($_POST[self::$playGame]) && $_POST[self::$playGame]) {
            if($_POST[self::$numberInput] > 6 || $_POST[self::$numberInput] < 1) {
                return '<p>Please type a number between 1-6</p>';
            }else{
                
                return '<img src="view/images/dice' . $pdc->rollDice() . '.jpg"/>';
            }
        }

    }    
    /**
     * gameResult
     *
     * @return void but returns HTML element.
     */
    public function gameResult() {
        if(isset($_POST[self::$playGame]) && $_POST[self::$playGame]) {
  
            if($_SESSION[self::$diceResult] == $_POST[self::$numberInput]){
            return '<h2>you win!</h2>';
            } else {
                return '<h2>You lose, try again!</h2>';
            }
        }
    }
}