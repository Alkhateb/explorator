<?php
require_once('easybitcoin.php');
$ekita = new Bitcoin('teknogeek', 'x', 'localhost', '31222');
$single = $_GET['single'];
$blockCount = $ekita->getblockcount();

$lastBlocks = "";
if($single == "false")
{
    for($i = $blockCount; $i > $blockCount - 10; $i--)
    {
        $blockHash = $ekita->getblockhash($i);
        $info = $ekita->getblock($blockHash);

        $lastBlocks .= "<tr><td>" . $info['height'] . "</td><td>" . number_format($info['difficulty'], 3) . "</td><td>" . $info['confirmations'] . "</td></tr>";
    }
}
else
{
    $blockHash = $ekita->getblockhash($blockCount);
    $info = $ekita->getblock($blockHash);

    $lastBlocks = "<tr><td>" . $info['height'] . "</td><td>" . number_format($info['difficulty'], 3) . "</td><td>" . $info['confirmations'] . "</td></tr>";
}
echo $lastBlocks;