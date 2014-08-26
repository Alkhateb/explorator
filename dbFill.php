<html>
<?php
require_once('easybitcoin.php');
$tesla = new Bitcoin('tesla', 'swag', 'localhost', '1857');

$credFile = file_get_contents('mysql.properties');
$credRows = explode("\r\n", $credFile);
foreach($credRows as $value)
{
    $valueSplit = explode("::", $value);
    $creds[$valueSplit[0]] = $valueSplit[1];
}

$db = new PDO($creds["serverInfo"], $creds["username"], $creds["password"]);

for($i = 0; $i < $tesla->getblockcount(); $i++)
{
    $hash = $tesla->getblockhash($i);
    $blockData = $tesla->getblock($hash, true);

    foreach($blockData['tx'] as $tx)
    {
        foreach($tx['vout'] as $out)
        {
            if(array_key_exists('addresses', $out['scriptPubKey']))
            {
                $db->exec("INSERT INTO `addresses` (address, balance) VALUES ('".$out['scriptPubKey']['addresses'][0]."', '".$out['value']."') ON DUPLICATE KEY UPDATE balance = balance + " . $out['value']);
            }
        }
    }
    //$stmt = $db->prepare("SELECT * FROM table WHERE id=:id AND name=:name");
    //$stmt->execute(array(':id' => $id, ':name' => $name));
    //$testRows = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
</html>