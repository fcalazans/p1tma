<!--TMA
Student Name: Fabio H. Calazans Silveira.
Student ID: 13503878
Username: fcalaz01
Modulo Name: Web Programming using PHP - P1.
Tutor: Ian Hollender.
-->
<?php

    // Function that validates the header and display the information.
    function validateHeader($modCode, $modTitle, $modTutor, $modDate) {

        // Variable global headerErrorCheck is used to flag errors for the analytical section.
        global $headerErrorCheck;
        $headerErrorCheck = 0;

        // Substring the data from module code and display code and error messages.
        if (trim($modCode) == '') {
            echo "Module Code : " . $modCode . " : ERROR - MODULE CODE EMPTY<br/>";
            $headerErrorCheck++;

        } else if (!in_array(substr($modCode, -2), ['T1', 'T2', 'T3']) && (!in_array(substr($modCode, 2), ['PP', 'P1', 'DT'])) || !in_array(substr($modCode, 2, -2), ['1617', '1718', '1819', '1920'])) {
            echo "Module Code : " . $modCode . " : ERROR - MODULE CODE INVALID<br/>";
            $headerErrorCheck++;

        } else {
            echo "Module Code : " . $modCode . " <br/>";
        }
        // Display module title and error messages.
        if (trim($modTitle) == '') {
            echo "Module Title : " . $modTitle . " : ERROR - MODULE TITLE EMPTY<br/>";
            $headerErrorCheck++;
        } else {
            echo "Module Title : " . $modTitle . " <br/>";
        }

        // Display tutor data and error message.
        if (trim($modTutor) == '') {
            echo "Tutor : " . $modTutor . " : ERROR - MODULE TUTOR EMPTY<br/>";
            $headerErrorCheck++;
        } else {
            echo "Tutor : " . $modTutor . "<br/>";
        }

        // Display marked date data.
        trim($modDate);
        $timeTemp = array_pad(explode('/', $modDate), 6, null);
        trim($timeTemp[0]);
        trim($timeTemp[1]);
        trim($timeTemp[2]);
        $timeTemp2 = checkdate((int) $timeTemp[1], (int) $timeTemp[0], (int) $timeTemp[2]);

        if (trim($modDate == '' || $modDate < 10)) {
            echo "Marked date : : ERROR - MARKED DATE EMPTY<br/>";
            $headerErrorCheck++;
        } else if (!$timeTemp2) {
            echo "Marked date : " . $modDate . " : ERROR - DATE INVALID<br/>";
            $headerErrorCheck++;
        } else {
            echo "Marked date : " . $modDate . "<br/>";
        }

    }

    // Function that find errors on the student and marks data and display flag error messages.
    function studentData($arrID, $arrMark) {

        // Loop over the student and mark data.
        for ($i = 0; $i < count($arrID); $i++) {
            if (strlen($arrID[$i]) != 8 || !is_numeric($arrID[$i]) || !is_numeric($arrMark[$i]) || $arrMark[$i] > 100 || $arrMark[$i] < 0) {
                echo $arrID[$i] . " : " . $arrMark[$i] . " : ERROR NOT TO BE INCLUDED</br>";
            } else {
                echo $arrID[$i] . " : " . $arrMark[$i] . "</br>";
            }
        }
    }

    // Function that analyze the correct data from students and marks to display only the valid information.
    function studentDataIncluded($arrID, $arrMark) {

        // Loop over the Students data and check requirements to display data.
        for ($i = 0; $i < count($arrID); $i++) {
            if (strlen($arrID[$i]) != 8 || !is_numeric($arrID[$i]) || !is_numeric($arrMark[$i]) || $arrMark[$i] > 100 || $arrMark[$i] < 0) {
            } else {
                echo $arrID[$i] . " : " . $arrMark[$i] . "</br>";
            }
        }
    }

    // Function that analyses statistical data section of the documents.
    function analytics($arrID, $arrMark) {

        // Use of a global variable to hold data from errors on the header.
        global $headerErrorCheck;

        // Initialization variables and array.
        $studentMarks = array();
        $distinction = 0;
        $merit = 0;
        $pass = 0;
        $fail = 0;

        // Loop through the students data and marks.
        for ($i = 0; $i < count($arrID); $i++) {
            if ((strlen($arrID[$i]) == 8) && is_numeric($arrID[$i]) && is_numeric($arrMark[$i]) && $arrMark[$i] < 100 && $arrMark[$i] > 0) {
                $studentMarks[] = $arrMark[$i];
                if ($arrMark[$i] > 70) {
                    $distinction++;
                } else if ($arrMark[$i] >= 60 and $arrMark[$i] < 70) {
                    $merit++;
                } else if ($arrMark[$i] >= 40 and $arrMark[$i] < 60) {
                    $pass++;
                } else {
                    $fail++;
                }
            }
        }

        // Statistical numbers #.
        echo "<p>Mean: " . (int) mmmr($studentMarks, "mean") . "</br>";
        echo "Mode: " . (int) mmmr($studentMarks, "mode") . "</br>";
        echo "Range: " . (int) mmmr($studentMarks, "range") . "</br></p>";

        // Statistical error header section #.
        echo "<p># of students: " . count($studentMarks) . "</br>";
        echo "# of Header Errors: $headerErrorCheck</br>";

        // Statistical error student section #.
        $studentErrors = count($arrMark) - (int) count($studentMarks);
        echo "# of Student data Errors: " . $studentErrors . "</br></p>";

        // Display Statistical Analysis of the module marks.
        echo "<p>Grade Distribution of module marks...</p>";

        // Display data.
        echo "Dist: " . $distinction . "<br>";
        echo "Merit: " . $merit . "<br>";
        echo "Pass: " . $pass . "<br>";
        echo "Fail: " . $fail . "<br></Dist:>";
    }

    /*
    -x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x
    Function from Tutor
     */

    #Web Programming using PHP (P1) - TMA Functions file to be included in TMA web pages.

    function mmmr($array, $output = 'mean') {
        #Provides basic statistical functions - default is mean; other $output parameters are; 'median', 'mode' and 'range'.
        #Ian Hollender 2016 - adapted from the following, as it was an inaccurate solution
        #http://phpsnips.com/45/Mean,-Median,-Mode,-Range-Of-An-Array#tab=snippet
        #Good example of PHP overloading variables with different data types - see the Mode code
        if (!is_array($array)) {
            echo '<p>Invalid parameter to mmmr() function: ' . $array . ' is not an array</p>';
            return false; #input parammeter is not an array
        } else {
            switch ($output) { #determine staistical output required
            case 'mean': #calculate mean or average
                $count = count($array);
                    $sum = array_sum($array);
                    $total = $sum / $count;
                    break;
                case 'median': #middle value in an ordered list; caters for odd and even lists
                    $count = count($array);
                    sort($array); #sort the list of numbers
                    if ($count % 2 == 0) { #even list of numbers
                    $med1 = $array[$count / 2];
                        $med2 = $array[($count / 2) - 1];
                        $total = ($med1 + $med2) / 2;
                    } else { #odd list of numbers
                    $total = $array[($count - 1) / 2];
                    }
                    break;
                case 'mode': #most frequent value in a list; N.B. will only find a unique mode or no mode;
                    $v = array_count_values($array); #create associate array; keys are numbers in array, values are counts
                    arsort($v); #sort the list of numbers in ascending order

                    if (count(array_unique($v)) == 1) { #all frequency counts are the same, as array_unique returns array with all duplicates removed!
                    return 'No mode';
                    }
                    $i = 0; #used to keep track of count of associative keys processes
                    $modes = '';
                    foreach ($v as $k => $v) { #determine if a unique most frequent number, or return NULL by only looking at first two keys and frequency numbers in the sorted array
                    if ($i == 0) { #first number and frequency in array
                    $max1 = $v; #highest frequency of first number in array
                    $modes = $k . ' ';
                        $total = $k; #first key is the most frequent number;
                    }
                        if ($i > 0) { #second number and frequency in array
                        $max2 = $v; #highest frequency of second number in array
                        if ($max1 == $max2) { #two or more numbers with same max frequency; return NULL
                        $modes = $modes . $k . ' ';
                        } else {
                            break;
                        }
                        }
                        $i++; #next item in $v array to be counted
                    }
                    $total = $modes;
                    break;
                case 'range': #highest value - lowest value
                    sort($array); #find the smallest number
                    $sml = $array[0];
                    rsort($array); #find the largest number
                    $lrg = $array[0];
                    $total = $lrg - $sml; #calculate the range
                    break;
                default:
                    echo '<p>Invalid parammeter to mmmr() function: ' . $output . '</p>';
                    $total = 0;
                    return false;
            }
            return $total;
        }
}
