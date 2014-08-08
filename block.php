<!DOCTYPE html>
<?php
require_once('easybitcoin.php');
$tesla = new Bitcoin('tesla', 'swag', 'localhost', '1857');

if($_GET)
{
    $blockInfo = $tesla->getblock($_GET['hash'], true);
}
else
{
    $blockCount = $tesla->getblockcount();
    $hash = $tesla->getblockhash($blockCount);
    $blockInfo = $tesla->getblock($hash, true);
}

$totalOut = 0;
$transactions = "";
$stakeValue = "";
$addressValue = "";
$stakeAmount = 0;
foreach($blockInfo['tx'] as $tx)
{
    $transactions .= "<tr><td><a href=\"tx.php?id=" . $tx['txid'] . "\">" . substr($tx['txid'], 0, 25) . "...</a></td>";
    if(array_key_exists('coinbase', $tx['vin'][0]))
    {
        $totalOut += $tx['vout'][0]['value'];
        if(array_key_exists('addresses', $tx['vout'][0]['scriptPubKey']))
        {
            $address = $tx['vout'][0]['scriptPubKey']['addresses'][0];
            $stakeValue .=  "<a href=\"address.php?address=" . $address . "\">" . $address . "</a> - ";
        }
        $stakeAmount += $tx['vout'][0]['value'];
        $stakeValue .= $stakeAmount;
        $transactions .= "<td>$stakeAmount</td><td>Stake Reward - $stakeAmount</td><td>$stakeValue</td></tr>";
    }
    else
    {
        foreach($tx['vout'] as $vout)
        {
            //echo "<pre>" . print_r($vout, 1) . "</pre>";
            if(array_key_exists('addresses', $vout['scriptPubKey']))
            {
                $address =  $vout['scriptPubKey']['addresses'][0];
                $addressValue .=  "<a href=\"address.php?address=" . $address . "\">" . $address . "</a> - " . $vout['value'] . "</br>";
            }
            $totalOut += $vout['value'];
        }
        $transactions .= "<td>$totalOut</td><td><a href=\"address.php?address=$address\">$address</a> - $totalOut</td><td>$addressValue</td></tr>";
    }
}
?>
<html>
<head>
    <meta charset="utf-8">
    <title>Block #<?php echo $blockInfo['height']; ?></title>
    <link rel="stylesheet" href="css/bootstrap.css" type="text/css"/>
</head>
<body>
<script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
<script src="js/bootstrap.js"></script>
    <div class="container">
        <h1>Block #<?php echo $blockInfo['height']; ?></h1>
        <div class="navbar">
            <div class="navbar-inner">
                <div class="container">
                    <ul class="nav">
                        <li><a href="index.php#lastblocks">Last Blocks</a>
                        </li>
                        <li><a href="index.php#richlist">Rich list</a></li>
                        <li><a href="index.php#about">About</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <table class="table table-striped" id="blockInfo">
            <tr>
                <td><strong>Hash</strong></td>
                <td><?php echo $blockInfo['hash']; ?></td>
            </tr>
            <?php
            if(array_key_exists('previousblockhash', $blockInfo))
            {
                echo "<tr><td><strong>Previous Block Hash</strong></td><td>";
                echo "<a href=\"block.php?hash=" . $blockInfo['previousblockhash'] . "\">" . $blockInfo['previousblockhash'] . "</a></td></tr>";
            }
            ?>
            <?php
            if(array_key_exists('nextblockhash', $blockInfo))
            {
                echo "<tr><td><strong>Next Block Hash</strong></td><td>";
                echo "<a href=\"block.php?hash=" . $blockInfo['nextblockhash'] . "\">" . $blockInfo['nextblockhash'] . "</a></td></tr>";
            }
            ?>
            <tr>
                <td><strong>Merkle Root</strong></td>
                <td><?php echo $blockInfo['merkleroot']; ?></td>
            </tr>
            <tr>
                <td><strong>Time/Date</strong></td>
                <td><?php echo date('H:i:s m/d/Y', $blockInfo['time']) . " +0000"; ?></td>
            </tr>
            <tr>
                <td><strong>Output Value</strong></td>
                <td><?php echo $totalOut . " TES"; ?></td>
            </tr>
            <tr>
                <td><strong>Difficulty</strong></td>
                <td><?php echo $blockInfo['difficulty']; ?></td>
            </tr>
            <tr>
                <td><strong>Confirmations</strong></td>
                <td><?php echo $blockInfo['confirmations']; ?></td>
            </tr>
        </table>
        <hr>
        <h3>Transactions</h3>
        <table class="table table-striped">
            <tr>
                <th>Transaction ID</th>
                <th>Total Output</th>
                <th>From (amount)</th>
                <th>To (amount)</th>
            </tr>
            <?php echo $transactions; ?>
        </table>
    </div>
</body>
</html>