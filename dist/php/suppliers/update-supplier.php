<?php
include "../../connection.php";

// Set the parameters
$s_id = trim($_POST['s_id']);
$s_name = ucwords(strtolower(trim($_POST['s_name'])));
$s_email = strtolower(trim($_POST['s_email']));
$s_address = ucwords(strtolower(trim($_POST['s_address'])));
$s_number = trim($_POST['s_number']);

// Check if any field is empty
if (empty($s_name) || empty($s_email) || empty($s_address) || empty($s_number)) {
    echo 3; // Return 3 for all fields required
    exit();
}

// Check if the phone number is in the correct format
if (!preg_match('/^(\+977-)?(\d{1,3}-)?\d{7,}$/', $s_number)) {
    echo 4; // Return 4 for invalid phone number format
    exit();
}

// Check if the email is in the correct format
if (!filter_var($s_email, FILTER_VALIDATE_EMAIL)) {
    echo 6; // Return 6 for invalid email format
    exit();
}

// Check if the name already exists
$nameCheckStmt = $conn->prepare("SELECT s_id FROM suppliers WHERE s_name = ? AND s_id != ?");
$nameCheckStmt->bind_param("si", $s_name, $s_id);
$nameCheckStmt->execute();
$nameCheckStmt->store_result();

if ($nameCheckStmt->num_rows > 0) {
    echo 2; // Return 2 if name already exists
    exit();
}

$nameCheckStmt->close();

// Check if the email already exists
$emailCheckStmt = $conn->prepare("SELECT s_id FROM suppliers WHERE s_email = ? AND s_id != ?");
$emailCheckStmt->bind_param("si", $s_email, $s_id);
$emailCheckStmt->execute();
$emailCheckStmt->store_result();

if ($emailCheckStmt->num_rows > 0) {
    echo 7; // Return 7 if email already exists
    exit();
}

$emailCheckStmt->close();

// Prepare the update statement
$stmt = $conn->prepare("UPDATE suppliers SET s_name=?, s_email=?, s_address=?, s_number=? WHERE s_id=?");

// Bind the parameters to the statement
$stmt->bind_param("ssssi", $s_name, $s_email, $s_address, $s_number, $s_id);

// Execute the statement
if ($stmt->execute()) {
    // Check if any changes were made
    if ($stmt->affected_rows > 0) {
        echo 1; // Return 1 for success
    } else {
        echo 5; // Return 5 for no changes made
    }
} else {
    echo 0; // Return 0 for error
}

// Close the statement and the connection
$stmt->close();
$conn->close();
?>
