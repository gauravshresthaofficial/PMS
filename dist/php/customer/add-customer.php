<?php
include "../../connection.php";

// Function to validate the input data
function validateData($name, $address, $number, $email) {
    if (empty($name) || empty($address) || empty($number) || empty($email)) {
        return 3; // Empty fields
    }
    if (!preg_match('/^(\+977-)?\d{10}$/', $number)) {
        return 4; // Number does not match the required pattern
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return 6; // Invalid email
    }
    return 0; // Validation successful
}

// Get the input data from the POST request
$c_name = ucwords(strtolower($_POST['c_name'])); // Capitalize first letter, convert to lowercase
$c_address = ucwords(strtolower($_POST['c_address'])); // Capitalize first letter, convert to lowercase
$c_number = $_POST['c_number'];
$c_email = $_POST['c_email'];

// Validate the input data
$validationResult = validateData($c_name, $c_address, $c_number, $c_email);

if ($validationResult !== 0) {
    echo $validationResult;
    return;
}

// Check for unique name
$sql = "SELECT COUNT(*) as count FROM customer WHERE LOWER(c_name) = LOWER(?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $c_name);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$count = $row['count'];

if ($count > 0) {
    echo 2; // Name already exists
    return;
}

// Check for unique email
$sql = "SELECT COUNT(*) as count FROM customer WHERE LOWER(c_email) = LOWER(?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $c_email);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$count = $row['count'];

if ($count > 0) {
    echo 7; // Email already exists
    return;
}

// Prepare the insert statement
$stmt = $conn->prepare("INSERT INTO customer (c_name, c_address, c_number, c_email, active) VALUES (?, ?, ?, ?, true)");
$stmt->bind_param("ssss", $c_name, $c_address, $c_number, $c_email);

// Execute the statement
if ($stmt->execute()) {
    echo 1; // Insertion successful
} else {
    echo 0; // Insertion failed
}

// Close the statement and the connection
$stmt->close();
$conn->close();
?>
