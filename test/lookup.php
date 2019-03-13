<?php
require_once('../LookupTable.php');
$lookup = new LookupTable("out.fnv", "177557", "FNV");

$results = $lookup->crack($_GET['lookup']);

if (count($results) !== $count || $results[0]->getPlaintext() !== "$word" || $results[0]->isFullMatch() !== true) {
    echo "FAILURE: Expected to crack [$word] but did not.\n";
    exit(1);
} else {
    $cracked = $results[0]->getPlaintext();
    echo "Successfully cracked [$cracked].\n";
}

?>