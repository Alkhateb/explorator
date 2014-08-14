<?php
$target = "0000000004e1fb00000000000000000000000000000000000000000000000000";
$maxtarget = "00000000ffffffffffffffffffffffffffffffffffffffffffffffffffffffff";
$diff = hexdec($maxtarget) / hexdec($target);
echo $diff;
?>