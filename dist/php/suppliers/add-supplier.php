<?php
include "../../connection.php";

// Set the parameters
$s_name = ucwords(strtolower(trim($_POST['s_name'])));
$s_email = strtolower(trim($_POST['s_email']));
$s_address = ucwords(strtolower(trim($_POST['s_address'])));
$s_number = trim($_POST['s_number']);

// Check if any field is empty
if (empty($s_name) || empty($s_email) || empty($s_address) || empty($s_number)) {
    echo 3;
    return;
}

// Check if name already exists
$sql = "SELECT s_name FROM suppliers WHERE LOWER(s_name) = LOWER(?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $s_name);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    echo 2; // Name already exists
    $stmt->close();
    $conn->close();
    return;
}

// Check if email already exists
$sql = "SELECT s_email FROM suppliers WHERE LOWER(s_email) = LOWER(?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $s_email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    echo 7; // Email already exists
    $stmt->close();
    $conn->close();
    return;
}

// Validate phone number format
$phoneNumberRegex = "/^(\+977-)?(\d{1,3}-)?\d{7,}$/";
if (!preg_match($phoneNumberRegex, $s_number)) {
    echo 4; // Invalid phone number format
    $stmt->close();
    $conn->close();
    return;
}

// Prepare the insert statement
$stmt = $conn->prepare("INSERT INTO suppliers (s_name, s_email, s_address, s_number) VALUES (?, ?, ?, ?)");

// Bind the parameters to the statement
$stmt->bind_param("ssss", $s_name, $s_email, $s_address, $s_number);

// Execute the statement
if ($stmt->execute()) {
    echo 1; // Record added successfully
} else {
    echo 0; // Failed to add record
}

// Close the statement and the connection
$stmt->close();
$conn->close();
?>
