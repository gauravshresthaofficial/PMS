<?php
include "../../connection.php";

$cid = $_POST['cid'];

$sql = "UPDATE customer SET active = 0 WHERE c_id = $cid";
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
