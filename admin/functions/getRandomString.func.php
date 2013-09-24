<?php
function getRandomString ($length = 10) {

    // init
    $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
    $string = '';

    // get string
    for ($i = 0; $i < $length; $i++) {
	$string .= $characters[mt_rand(0, (strlen($characters)-1))];
    }

    return $string;
}
?>
