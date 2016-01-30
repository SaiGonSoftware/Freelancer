<?php 

$mysql = new mysqli('localhost','root','','freelancer');
$mysql->set_charset('utf8');  
$result = $mysql->query("select * from province");
$rows = array();
while($row = $result->fetch_array(MYSQL_ASSOC)) {
	$rows[] = array_map("htmlspecialchars", $row);
}
echo json_encode($rows);
?>