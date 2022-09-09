<?php

function sortStr($str) {
 
    $strArr = str_split($str);
    /* Sort the array using sort() method. */
    sort($strArr);

    /* Implode the sorted array. */
    $str = implode($strArr);

    return $str;
   
}
