<?php
namespace view;
class DateTimeView {
	/**
	 * show date and time
	 *
	 * @return string string of HTML.
	 */
	public function show():string {

		$date = date('m/d/Y');
		$dayName = date('l');
		$day = date('jS');
		$monthName = date('F');
		$month = date('m');
		$year = date('Y');
		$timeString = $dayName . ', the ' . $day . ' of ' . $monthName . ' ' . $year .', The time is ' . date("H:i:s");

		return '<p>' . $timeString . '</p>';
	}
}