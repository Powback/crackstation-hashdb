<?php
//ZoomToggle | 3585622080
//-709345216,ZoomToggle,0xD5B84040
define ("FNV_prime_32", 16777619);
define ("FNV_prime_64", 1099511628211);
define ("FNV_prime_128", 309485009821345068724781371);

define ("FNV_offset_basis_32", 5381);
define ("FNV_offset_basis_64", 14695981039346656037);
define ("FNV_offset_basis_128", 144066263297769815596495629667062367629);
include("../int_helper.php");
//64bit: 962683235
//32bit: 1072802250
//echo fnvhash_fnv1("DrivingType");

/**
 *    FNV Hash
 *
 *  Author: Neven Boyanov
 *  Copyright (c) 2009 by Neven Boyanov (Boyanov.Org)
 *  Licensed under GNU/GPLv2 - http://www.gnu.org/licenses/
 *
 *  This program is distributed under the terms of the License,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty
 *  of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See
 *  the License for more details.
 *
 **/

/*
*    Constants
*
*    FNV_PRIME:
*    32 bit FNV_prime = 2^24 + 2^8 + 0x93 = 16777619    ... 1000000000000000110010011
*    64 bit FNV_prime = 2^40 + 2^8 + 0xb3 = 1099511628211    ... 10000000000000000000000000000000110110011
*    128 bit FNV_prime = 2^88 + 2^8 + 0x3b = 309485009821345068724781371    ...
*    OFFSET_BASIS:
*    32 bit offset_basis = 2166136261
*    64 bit offset_basis = 14695981039346656037
*    128 bit offset_basis = 144066263297769815596495629667062367629
*
*    Source: http://www.isthe.com/chongo/tech/comp/fnv/
*/



/*
*    The core of the FNV-1 hash algorithm is as follows:
*
*        hash = offset_basis
*        for each octet_of_data to be hashed
*            hash = hash * FNV_prime
*            hash = hash xor octet_of_data
*        return hash
*
*    Source: http://www.isthe.com/chongo/tech/comp/fnv/
*/
function DoHash($input, $raw)
{
    $FNV_OFFSET_BASIS = 0x1505;
    $FNV_PRIME = 0x21;

    $s_Hash = $FNV_OFFSET_BASIS;
    $s_Input = str_split($input);
    for ($i = 0; $i < strlen($input); $i++)
    {
        $str = ord($s_Input[$i]);

        $s_Hash = ($s_Hash * $FNV_PRIME) ^ $str;
    }
    $s_Hash = $s_Hash & 0x0ffffffff;

    if($raw)
        return ($s_Hash);

    return bin2hex(int_helper::int32($s_Hash));
}

function fnvhash_fnv1($txt)
{
    echo $txt . ": " . bin2hex($txt) . "\n";
    $buf = str_split($txt);
    $hash = 5381;
    foreach ($buf as $chr)
    {
        $hash += intval32bits($hash << 5);
        $hash = intval32bits($hash ^ ord($chr));
    }
    $hash = $hash & 0x0ffffffff;
    return intval32bits($hash);
}


function intval32bits($value)
{
    $value = ($value & 0xFFFFFFFF);

    if ($value & 0x80000000)
        $value = -((~$value & 0xFFFFFFFF) + 1);

    return $value;
}
echo GetResult(684400000000);
function GetResult($input) {
    $var = File("../events_v6.txt");
    //$var = array("a","b","c","d");
        $count = count($var);
        //echo "Count: " . $count . "\n";
        //echo log($input*2+1)/log($count);
       
        $level = floor(log($input)/log($count));
        

        //echo "Level is: " . $level . "\n";
        //sleep(1000);

        $subtract = $level;
        $corInput = $input;

        while($subtract > 0) {
            $corInput = $corInput - $count ** $subtract;
              ///echo "Calculating relative number: " . $corInput . "\n";
            $subtract-=1;
        }
        //echo "Relative pos calculated! It is: " . $corInput . "\n";
        $level = $level+1;
        $i = 0;
        $out = "";


        while( $i < $level ) {
            //echo "i: " . $i . "\n";
            $a = ($count**$i);
            $b = ($corInput/$a);
            $sec = floor($b%$count);
            $out = $var[$sec] . $out;
            //echo "The " . $i . "th number is: " . $sec . " |  " . $var[$sec] . "\n";
            $i+=1;
        }
        //echo $input . " | " . trim(preg_replace('/\s\s+/', '', $out)) . "\n";
        return trim(preg_replace('/\s\s+/', '', $out));
}


?>