<?php

class DateTimeView {


	public function show() {

		$date = date('m/d/Y');
		$dayName = date('l');
		$day = date('dS');
		$monthName = date('F');
		$month = date('m');
		$year = date('Y');
		$timeString = $dayName . ', the ' . $day . ' of ' . $monthName . ' ' . $year .', The time is ' . date("H:i:s");

		return '<p>' . $timeString . '</p>';
	}
}