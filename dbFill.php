<html>
<?php
require_once('easybitcoin.php');
$ekita = new Bitcoin('teknogeek', 'x', 'localhost', '31222');
$hash = $ekita->getblockhash(5000);

echo '<pre>';
echo print_r($ekita->getblock($hash, true), 1);
echo '</pre>';

$blockCount = $ekita->getblockcount();

$con = mysqli_connect('localhost', 'root', '', 'ekita');

for($i = 0; $i < $blockCount; $i ++)
{

}
?>
</html>