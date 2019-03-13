<?php
// A continuation of test.sh...

require_once('../LookupTable.php');
require_once('../MoreHashes.php');

/*
if (count($argv) !== 2) {
    echo "Usage: php test.php <hash type>\n";
    exit(1);
}
$argv[1]
*/
$hash_algorithm = "FNV";

$hasher = MoreHashAlgorithms::GetHashFunction($hash_algorithm);

$fh = fopen("words.txt", "r");
if ($fh === false) {
    echo "Error opening words.txt";
    exit(1);
}

while (($line = fgets($fh)) !== false) {
    $word = rtrim($line, "\r\n");

    // words.txt must be in sorted order for this to work!
    $count = 1;
    while (($line = fgets($fh)) !== false) {
        if ($hasher->hash(rtrim($line, "\r\n"), false) !== $hasher->hash($word, false)) {
            fseek($fh, -1 * strlen($line), SEEK_CUR);
            break;
        }
        $count++;
    }

    // Full match.

    if (preg_match('/^-?\d+$/', $word) === 1) {
        $to_crack = bin2hex(pack('N', (intval32bits((int)$word)))); 
    } else if(substr( $word, 0, 2 ) === "0x") {
        $to_crack = bin2hex(pack('N', (intval32bits(hexdec(substr($word, 2))))));
    } else {
        echo "UNKNOWN\n";
        $to_crack = $word;
    }

    for($i2 = 0; $i2 < 1850;) {
        $lookup = new LookupTable("../Databases/FNVHashes_" . $i2 . ".idx", "../events_v7.txt", $hash_algorithm);
        //echo $i2 . "\n";

        $i2++;
        $results = $lookup->crack($to_crack);
        
        if (count($results) === 0) {
            //echo "Unknown: [$to_crack]\n";
        } else {
            for($i = 0; $i < count($results); $i++) {

                $cracked = $results[$i]->getPlaintext();
                //echo $cracked;
                //echo "Successfully cracked! [$to_crack] [$word] : [$cracked].\n";
                $rawhash = $hasher->hash($cracked, false);

             
                if($results[$i]->isFullMatch()) {
                    //echo bin2hex(pack('N', ($rawhash))) . ":" .$cracked . ":  " . $rawhash .":".$i2 ." \n";
                    echo '"' . $rawhash . '": "' . $cracked . "\",\n";
                } else {
                    //if(bin2hex($results[$i]->getRecomputedFullHashBytes())[6] == $to_crack[6]) {
                        //echo '_HALFMATCH_"' . $rawhash . '": "' . $cracked . "\",\n";
                        //echo $i2 . ": WrongMatch: " ;
                        //echo "  in: " . $to_crack . " Found: " . bin2hex($results[$i]->getRecomputedFullHashBytes())." out: " . $cracked . ": ";
                        //echo bin2hex(pack('N', ($rawhash))) . ":" . $rawhash . "\n";
                    //}
                }

            }
        }
        unset($results);
    }
    echo "\n";

}

function hexToStr($hex){
    $string='';
    for ($i=0; $i < strlen($hex)-1; $i+=2){
        $string .= chr(hexdec($hex[$i].$hex[$i+1]));
    }
    return $string;
}

fclose($fh);

?>
