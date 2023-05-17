<?php
// data.php

// Your database connection code here
include "../../connection.php";

// Example code to retrieve the number of rows in each table
function getRowCount($tableName)
{
    global $conn;
    $stmt = $conn->prepare("SELECT COUNT(*) as count FROM $tableName");
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $rowCount = $row['count'];
    $stmt->close();

    return $rowCount;
}

// Usage example
$customer_num = getRowCount("customer");
$medicine_num = getRowCount("medicine");
$supplier_num = getRowCount("suppliers");
$invoice_num = getRowCount("invoice");

// Example usage for purchases table
$purchasesTotal = getTodayTotal("purchases", "purchase_date");
// echo "Today's Purchases Total: $purchasesTotal" . PHP_EOL;

// Example usage for invoice table
$salesTotal = getTodayTotal("invoice", "invoice_date");
// echo "Today's Sales Total: $salesTotal" . PHP_EOL;


// Call the function to get the total expired medicine
$totalExpiredMedicine = getTotalExpiredMedicine();

// Call the function to get the total out of stock medicine
$OutOfStockMedicine = getOutOfStockMedicine();

// Prepare the data to be sent back as a JSON response
$responseData = array(
    'customer_num' => $customer_num,
    'medicine_num' => $medicine_num,
    'supplier_num' => $supplier_num,
    'invoice_num' => $invoice_num,
    'purchasesTotal' => $purchasesTotal,
    'salesTotal' => $salesTotal,
    'totalExpiredMedicine' => $totalExpiredMedicine,
    'outOfStockMedicine' => $OutOfStockMedicine
    // Add more lines for other tables if needed
);

// Send the response as JSON
header('Content-Type: application/json');
echo json_encode($responseData);
exit;



function getTotalExpiredMedicine()
{
    global $conn;

    // Set the timezone to Kathmandu
    date_default_timezone_set('Asia/Kathmandu');

    // Get today's date
    $today = date("Y-m-d");

    // Perform the query to find the total expired medicine
    $stmt = $conn->prepare("SELECT COUNT(*) AS total_expired
                           FROM medicine_stock
                           WHERE exp_date < ?");

    $stmt->bind_param("s", $today);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the query executed successfully
    if ($result) {
        $row = $result->fetch_assoc();
        $totalExpired = $row['total_expired'];

        // Check if the total expired is null (no records found)
        if ($totalExpired === null) {
            // Return 0 if no records found for today
            return 0;
        }

        return $totalExpired;
    } else {
        echo "Error executing the query: " . $stmt->error;
        return 0;
    }
}

function getTodayTotal($tableName, $dateColumn)
{
    global $conn;

    // Set the timezone to Kathmandu
    date_default_timezone_set('Asia/Kathmandu');

    // Get today's date
    $today = date("Y-m-d");

    // Prepare the SQL query based on the table name and date column
    $stmt = $conn->prepare("SELECT SUM(total) AS total_amount FROM $tableName WHERE $dateColumn = ?");
    $stmt->bind_param("s", $today);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the query executed successfully
    if ($result) {
        // Fetch the row containing the total amount
        $row = $result->fetch_assoc();

        // Retrieve the total amount
        $totalAmount = $row['total_amount'];

        // Check if the total amount is null (no records found)
        if ($totalAmount === null) {
            // Return 0 if no records found for today
            return 0;
        }

        // Return the total amount
        return $totalAmount;
    } else {
        // Handle query error
        echo "Error executing the query: " . $stmt->error;
        return 0;
    }

    // Close the prepared statement
    $stmt->close();
}

function getOutOfStockMedicine()
{
    global $conn;

    // Get the count of out-of-stock medicines from medicine_stock
    $stockQuery = "SELECT COUNT(*) AS total_out_of_stock
                   FROM medicine_stock
                   WHERE qty = 0";

    $stockResult = $conn->query($stockQuery);
    if (!$stockResult) {
        echo "Error executing the query: " . $conn->error;
        return 0;
    }

    // Fetch the count of out-of-stock medicines
    $row = $stockResult->fetch_assoc();
    $totalOutOfStock = $row['total_out_of_stock'];

    // Get the count of medicines from medicine that are not in medicine_stock
    $medicineQuery = "SELECT COUNT(*) AS total_not_in_stock
                      FROM medicine
                      WHERE med_name NOT IN (
                          SELECT med_name
                          FROM medicine_stock
                      )";

    $medicineResult = $conn->query($medicineQuery);
    if (!$medicineResult) {
        echo "Error executing the query: " . $conn->error;
        return 0;
    }

    // Fetch the count of medicines from medicine that are not in medicine_stock
    $row = $medicineResult->fetch_assoc();
    $totalNotInStock = $row['total_not_in_stock'];

    // Calculate the total count of out-of-stock medicines
    $totalOutOfStockMedicine = $totalOutOfStock + $totalNotInStock;

    // Return 0 if no medicine is out of stock
    return $totalOutOfStockMedicine > 0 ? $totalOutOfStockMedicine : 0;
}
