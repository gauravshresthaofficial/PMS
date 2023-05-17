<?php
include "../../connection.php";

//Delete the medicine from database
if (isset($_POST['action']) && $_POST['action'] == "delete") {
    global $conn;
    $id = $_POST['id'];

    $sql = "Delete from purchases where p_id = $id";
    $result = $conn->query($sql) or die("Sql query failed");
    $conn->close();

    if ($result) {
        echo 1;
    } else {
        echo 0;
    }
}

?>