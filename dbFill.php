<html>
<?php
require_once('easybitcoin.php');
$tesla = new Bitcoin('tesla', 'swag', 'localhost', '1857');

$tx = $tesla->gettransaction('6a668098447c9f4121533ed96dbe390efe4329b708d0bce8f58efbcd31aed2d0');

echo '<pre>';
echo print_r($tx, 1);
echo '</pre>';
//$con = mysqli_connect('localhost', 'root', '', 'tesla');
?>
</html>