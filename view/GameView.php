<?php

namespace view;

class GameView {
	private static $playGame = 'GameView::playGame';
    private static $messageId = 'GameView::Message';
    private static $numberInput = 'GameView::numberInput';


	public function response() {
		// if(isset($_GET['playGame'])) {
        $message = 'Press Play Game to start a new game!';
        $response = $this->generateGameFormHTML($message);
        
        // }
        return $response;

    }
    public function generateGameFormHTML($message) {
        return '
            <form action="?playGame" method="post"> 
            <fieldset>
            <legend>Play a game of dice</legend>
            <p id="' . self::$messageId . '">' . $message . '</p>
            <input id = "' . self::$numberInput . '" type="text" name="' . self::$numberInput . '"/>
            <input id="' . self::$playGame . '" type="submit" name="' . self::$playGame . '" value="Play Game" />
            </fieldset>
            </form>
            ';
    }

    public function playGame() {
        if(isset($_POST[self::$playGame]) && $_POST[self::$playGame]) {

            return '<img src="view/images/dice' . $this->randomDice() . '.jpg"/>';

        }

    }
    public function gameResult(){
        if(isset($_POST[self::$playGame]) && $_POST[self::$playGame]) {
            if($_SESSION['diceResult'] == $_POST[self::$numberInput]){
            return '<h2>you win!</h2>';
            } else {
                return '<h2>You lose, try again!</h2>';
            }
        }
    }

    public function randomDice() {
        $_SESSION['diceResult'] = rand(1,6);
        return $_SESSION['diceResult'];
    }
}