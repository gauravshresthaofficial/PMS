<?php
include "../../connection.php";

$sid = $_POST['sid'];

$sql = "UPDATE suppliers SET active = 0 WHERE s_id = $sid";
$result = $conn->query($sql) or die ("Sql query failed");
$conn->close();

if($result)
{
    echo 1;
}
else
{
    echo 0;
}
