<?php
session_start();
include "connection.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['name'])) {
        header("location: index.php");
        exit();
    }

    $username = $_SESSION['username'];
    $email = $_POST['email'];
    $fullname = $_POST['fullname'];
    $password = $_POST['password'];

    // Retrieve the existing admin details
    $stmt = $conn->prepare("SELECT * FROM admin WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $admin = $result->fetch_assoc();

    // Check if the email already exists for a different admin
    $stmt = $conn->prepare("SELECT * FROM admin WHERE email = ? AND username != ?");
    $stmt->bind_param("ss", $email, $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Email already exists
        $_SESSION['error'] = "Email already exists";
        header("location: edit-admin.php");
        exit();
    }

    // Check if any changes were made
    if ($email === $admin['email'] && $fullname === $admin['fullname'] && $password === $admin['password']) {
        $_SESSION['success'] = "No changes were made";
        header("location: home.php");
        exit();
    }

    // Update the admin details
    $stmt = $conn->prepare("UPDATE admin SET email = ?, fullname = ?, password = ? WHERE username = ?");
    $stmt->bind_param("ssss", $email, $fullname, $password, $username);

    if ($stmt->execute()) {
        // Update successful
        $_SESSION['name'] = $fullname;
        $_SESSION['success'] = "Update successfully.";
        header("location: home.php");
        exit();
    } else {
        // Update failed
        $_SESSION['error'] = "Failed to update admin details";
        header("location: edit-admin.php");
        exit();
    }
} else {
    // Invalid request method
    header("location: index.php");
    exit();
}
