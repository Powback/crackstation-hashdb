<?php
$var = File("abc.txt");
//$var = array("a","b","c","d");
$count = count($var);
echo "Count: " . $count . "\n";
GetResult(47732);
function GetResult($input) {
    $var = File("abc.txt");
    //$var = array("a","b","c","d");
    $count = count($var);
    echo "Count: " . $count . "\n";
    echo log($input*2+1)/log($count);
    $level = floor(round(log($input*2+1)/log($count),6));
    $level2 =floor(round(log($input*2+1)/log($count),6));

    echo "Level is: " . $level . "\n";


    $subtract = $level -1;
    $corInput = $input;

    while($subtract > 0) {
        $corInput = $corInput - $count ** $subtract;
        echo "Calculating relative number: " . $corInput . "\n";
        $subtract-=1;
    }
    echo "Relative pos calculated! It is: " . $corInput . "\n";

    $i = 0;
    $out = "";

    $corInputNullBased = $corInput - 1;

    while( $i < $level + 1) {

        $a = ($count**$i);
        $b = ($corInputNullBased/$a);
        $sec = floor($b%$count);
        $out = $var[$sec-1] . $out;
        echo "The " . $i . "th number is: " . $sec . "/ " . $var[$sec-1] . "\n";
        $i+=1;
    }

    echo "The final result is: " . trim(preg_replace('/\s\s+/', '', $out)) . "\n";
}

?>