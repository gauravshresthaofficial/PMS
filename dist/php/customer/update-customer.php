<?php
include "../../connection.php";

// Set the response variable
$response = '';

// Retrieve the POST data
$c_id = $_POST['c_id'];
$c_name = ucwords(strtolower($_POST['c_name'])); // Capitalize first letter, convert to lowercase
$c_address = ucwords(strtolower($_POST['c_address'])); // Capitalize first letter, convert to lowercase
$c_number = $_POST['c_number'];
$c_email = $_POST['c_email'];

// Check if any field is empty
if (empty($c_id) || empty($c_name) || empty($c_address) || empty($c_number) || empty($c_email)) {
    $response = '3'; // Field required error
} else {
    // Check if the number is not numeric or does not match the desired pattern
    $phoneNumberRegex = '/^(\+977-)?\d{10}$/';
    if (!preg_match($phoneNumberRegex, $c_number)) {
        $response = '4'; // Invalid number error
    } else {
        // Check if the email is not valid
        if (!filter_var($c_email, FILTER_VALIDATE_EMAIL)) {
            $response = '6'; // Invalid email error
        } else {
            // Check if the email already exists for other customers
            $stmt = $conn->prepare("SELECT c_id FROM customer WHERE LOWER(c_email)=LOWER(?) AND c_id<>?");
            $stmt->bind_param("si", $c_email, $c_id);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                $response = '7'; // Email already exists error
            } else {
                // Check if the name already exists for other customers
                $stmt = $conn->prepare("SELECT c_id FROM customer WHERE LOWER(c_name)=LOWER(?) AND c_id<>?");
                $stmt->bind_param("si", $c_name, $c_id);
                $stmt->execute();
                $stmt->store_result();

                if ($stmt->num_rows > 0) {
                    $response = '2'; // Name already exists error
                } else {
                    // Check if any changes were made
                    $stmt = $conn->prepare("SELECT c_id FROM customer WHERE c_id=? AND LOWER(c_name)=LOWER(?) AND LOWER(c_address)=LOWER(?) AND c_number=? AND LOWER(c_email)=LOWER(?)");
                    $stmt->bind_param("issss", $c_id, $c_name, $c_address, $c_number, $c_email);
                    $stmt->execute();
                    $stmt->store_result();

                    if ($stmt->num_rows > 0) {
                        $response = '5'; // No changes made error
                    } else {
                        // Prepare the update statement
                        $stmt = $conn->prepare("UPDATE customer SET c_name=?, c_address=?, c_number=?, c_email=? WHERE c_id=?");
                        $stmt->bind_param("ssssi", $c_name, $c_address, $c_number, $c_email, $c_id);

                        // Execute the statement
                        if ($stmt->execute()) {
                            $response = '1'; // Update successful
                        } else {
                            $response = '0'; // Update failed
                        }

                        // Close the statement
                        $stmt->close();
                    }
                }
            }
        }
    }
}

// Close the connection
$conn->close();

// Echo the response
echo $response;
?>
