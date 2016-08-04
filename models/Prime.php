<?php
/**
* Prime Class
* contains prime counting functions
* prime number project
* prudy
* august 2016
*/
class Prime extends \Phalcon\Mvc\Model
{
    /**
    * atkins
    * returns all primes for a given range
    * @param int $start starting point default 2 (optional)
    * @param int $end   ending point default 1000 (optional)
    *
    * @return array
    */
    public function atkins($start=2, $end=1000) {
	$i = 2;
        //pre-populate the array with all the numbers
	$arrPrimes = array();
	for($j = 2; $j <= $end; $j++) {
            $arrPrimes[$j] = $j;
        }//end for loop

	//now since we're starting with a known prime 2
        //start looping through and unsetting all multiples of it
        //going up to the end value.
        //we'll keep unsetting all multipes of a non prime, leaving
        //only primes in our array.
        while($i * $i <= $end) {
            if(isset($arrPrimes[$i])) {
                $k = $i;
                while ($k * $i <= $end) {
                    unset($arrPrimes[$k * $i]);
                    $k++;
                } //end nested while
            }//end if
            $i++;
        }//end while  

	//now given how the multiples work, the function above HAS to start at 2
        //otherwise, its going to be no worky worky
        //so to apply the range function, we'll run through at 2 (above)
        //and just chop off the front part.
        //the function above guarantees us order, so we can do this fast
	if ($start != 2) {
	    foreach ($arrPrimes as $key) {
		if ($key < $start) {
		    unset($arrPrimes[$key]);
		} else {
		    break;
		}
            }
	}

        return $arrPrimes;
    }//end function
}//end class
