<?php

require_once('../MoreHashes.php');

$hash_algos = MoreHashAlgorithms::GetHashAlgoNames();

foreach ($hash_algos as $algo) {
    $hasher = MoreHashAlgorithms::GetHashFunction($algo);
    echo $algo . "\t" . $hasher->hash("Disabled", false) . "\t" . $hasher->hash("Disabled", false);
    echo "\n";
}

?>
