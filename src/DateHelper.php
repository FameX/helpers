<?php
declare(strict_types=1);

namespace Famex\Helpers;

class DateHelper {
    /**
     * Get human readable time difference between 2 dates
     *
     * Return difference between 2 dates in year, month, hour, minute or second
     * The $precision caps the number of time units used: for instance if
     * $time1 - $time2 = 3 days, 4 hours, 12 minutes, 5 seconds
     * - with precision = 1 : 3 days
     * - with precision = 2 : 3 days, 4 hours
     * - with precision = 3 : 3 days, 4 hours, 12 minutes
     *
     * From: http://www.if-not-true-then-false.com/2010/php-calculate-real-differences-between-two-dates-or-timestamps/
     * From: https://gist.github.com/ozh/8169202
     *
     * @param  int|string  $time1  a time (string or timestamp)
     * @param  int|string  $time2  a time (string or timestamp)
     * @param  integer  $precision  Optional precision
     * @return string time difference
     * @throws DateHelperException
     */
	public static function getDateDiff($time1, $time2, int $precision = 2): string
    {
		// If not numeric then convert timestamps
		if( !is_int( $time1 ) ) {
			$t1 = strtotime( $time1 );
            if( $t1 === false ) {
                throw new DateHelperException('Unable to parse date: '.$time1);
            }
            $time1 = $t1;
		}
		if( !is_int( $time2 ) ) {
			$t2 = strtotime( $time2 );
            if( $t2 === false ) {
                throw new DateHelperException('Unable to parse date: '.$time2);
            }
            $time2 = $t2;
		}
 
		// If time1 > time2 then swap the 2 values
		if( $time1 > $time2 ) {
			list( $time1, $time2 ) = [$time2, $time1];
		}
 
		// Set up intervals and diffs arrays
		$intervals = ['year', 'month', 'day', 'hour', 'minute', 'second'];
		$diffs = [];
 
		foreach( $intervals as $interval ) {
			// Create temp time from time1 and interval
			$ttime = strtotime( '+1 ' . $interval, $time1 );
			// Set initial values
			$add = 1;
			$looped = 0;
			// Loop until temp time is smaller than time2
			while ( $time2 >= $ttime ) {
				// Create new temp time from time1 and interval
				$add++;
				$ttime = strtotime( "+" . $add . " " . $interval, $time1 );
				$looped++;
			}
 
			$t = strtotime( "+" . $looped . " " . $interval, $time1 );
            if($t === false) {
                throw new DateHelperException('Unable to parse date: '.$time1);
            }
            $time1 = $t;
			$diffs[ $interval ] = $looped;
		}
 
		$count = 0;
		$times = array();
		foreach( $diffs as $interval => $value ) {
			// Break if we have needed precission
			if( $count >= $precision ) {
				break;
			}
			// Add value and interval if value is bigger than 0
			if( $value > 0 ) {
				if( $value !== 1 ){
					$interval .= "s";
				}
				// Add value and interval to times array
				$times[] = $value . " " . $interval;
				$count++;
			}
		}
 
		// Return string with times
		return implode( ", ", $times );
	}
}