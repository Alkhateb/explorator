<?php
require_once('easybitcoin.php');
$tesla = new Bitcoin('tesla', 'swag', 'localhost', '1857');
$single = $_GET['single'];
$blockCount = $tesla->getblockcount();

$lastBlocks = "";
if($single == "false")
{
    for($i = $blockCount; $i > $blockCount - 10; $i--)
    {
        $blockHash = $tesla->getblockhash($i);
        $info = $tesla->getblock($blockHash);

        $lastBlocks .= "<tr><td>" . $info['height'] . "</td><td>" . number_format($info['difficulty'], 3) . "</td><td>" . $info['confirmations'] . "</td></tr>";
    }
}
else
{
    $blockHash = $tesla->getblockhash($blockCount);
    $info = $tesla->getblock($blockHash);

    $lastBlocks = "<tr><td>" . $info['height'] . "</td><td>" . number_format($info['difficulty'], 3) . "</td><td>" . $info['confirmations'] . "</td></tr>";
}
echo $lastBlocks;