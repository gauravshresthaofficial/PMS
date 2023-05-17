<?php

function addSupplier($s_name, $s_email, $s_number, $s_address)
{
    include "../../connection.php";


    // Prepare the insert statement
    $stmt = $conn->prepare("INSERT INTO suppliers (s_name, s_email, s_address, s_number) VALUES (?, ?, ?, ?)");

    // Bind the parameters to the statement
    $stmt->bind_param("ssss", $s_name, $s_email, $s_address, $s_number);

    //Check for Unique name
    $sql = "Select s_name from suppliers";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            if (strtolower($row['s_name']) == strtolower($s_name)) {
                echo 3;
                return;
            }
        }



        // Execute the statement
        if ($stmt->execute()) {
            echo 1;
        } else {
            echo 0;
        }

        // Close the statement and the connection
        $stmt->close();
        $conn->close();
    }
}
