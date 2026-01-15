<?php
$db = new mysqli('localhost', 'root', '', 'archivo_db');
if ($db->connect_error) { die("Error: " . $db->connect_error); }
$db->set_charset("utf8");
?>