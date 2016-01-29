<?php

$con=mysqli_connect("localhost",'root', '','freelancer');

$query = "select * from tag";

$result = mysqli_query($con,$query);

$rows = array();
while($r = mysqli_fetch_array($result)) {
    $rows[] = $r;
}
echo json_encode($rows);

?>