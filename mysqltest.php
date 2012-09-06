<?php
echo "testing connection";
$link = mysql_connect('localhost','simu','simu');
if (!$link) { die('Could not connect to MySQL: ' . mysql_error());} echo 'Connection OK';
mysql_close($link);

?>