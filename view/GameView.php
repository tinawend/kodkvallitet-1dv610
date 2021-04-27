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

            <p>The Rules of the game:</p>
            <p>The closer to the dice result you can guess the bigger score you get</p>
            <p>Same number = 5 pointz</p>
            <p>one above or under = 4 points</p>
            <p>carefull! all other guesses will give you -1 point</p>
            <p>if you reach 20 points you win, if you reach -10 points you loose!</p>

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
        $pdc = new \model\DiceModel();
        if(isset($_POST[self::$playGame]) && $_POST[self::$playGame]) {
            $score = $pdc->gameRules();
            if($score == 20){
                $pdc->resetScore();
                return '<h2>You win!</h2>';
            }
            if($score == -10){
                $pdc->resetScore();
                return '<h2>You Loose!</h2>';
            }
            return '<h2>your score is '. $score .' !</h2>';
        }
    }
}