<?php
include 'connection.php';
    $stock_id = 1002;
    $date = "2023/4/6";
    $exp_date = date('Y-m-d', strtotime($date));
    $qty = "200";
    $mrp = "100";
    $rate = "20";
    
    // Prepare the SQL query
    $stmt = $conn->prepare("UPDATE medicine_stock SET exp_date = ?, qty = ?, mrp = ?, rate = ? WHERE medicine_stock.stock_id = ?");
    
    // Bind the parameters to values
    $stmt->bind_param('siddi', $exp_date, $qty, $mrp, $rate, $stock_id);

    
    // Execute the prepared statement
    if ($stmt->execute()) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $stmt->error;
    }

    ?>