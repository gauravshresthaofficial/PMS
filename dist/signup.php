<?php
session_start();
include "connection.php";

if (isset($_POST['submit_check'])) {
    $errors = validate_form();
    if (!empty($errors)) {
        show_form($errors);
    } else {
        $username = strtolower(trim($_POST['username']));
        $fullname = ucwords(strtolower(trim($_POST['fullname'])));
        $password = strtolower(trim($_POST['password']));
        $email = strtolower(trim($_POST['email']));

        $stmt = $conn->prepare("INSERT INTO admin (username, fullname, password, email) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $username, $fullname, $password, $email);
        $stmt->execute();
        $stmt->close();

        $_SESSION['name'] = $row['fullname'];
        $_SESSION['username'] = $row['username'];

        header("Location: home.php");
        exit();
    }
} else {
    show_form();
}

function show_form($errors = array())
{
    echo '
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Sign Up</title>
        <script src="https://cdn.tailwindcss.com"></script>


    </head>
    <body>
        <div class="wrapper bg-[#1E1E1E] h-screen font-poppins flex justify-center items-center w-screen">
            <form action="' . $_SERVER['PHP_SELF'] . '" method="post" class="bg-[#F1F5F9] p-6 mx-auto w-1/3 rounded-md">
                <h4 class="text-center text-[#01A768] font-bold text-2xl">Pharmacy Management System</h4>
                <hr class="my-3">';

    if (!empty($errors)) {
        echo '<ul class="text-sm text-red-500 text-center block">';
        foreach ($errors as $error) {
            echo '<li>' . $error . '</li>';
        }
        echo '</ul>';
    }

    echo '
                <div class="mb-2.5">
                    <label for="username" class="block mb-1 ps-1">Username:</label>
                    <input type="text" name="username" required class="block px-2 py-1 w-full border focus:outline-none focus:ring-0 focus:border-gray-600 rounded" placeholder="Enter your username">
                </div>
                <div class="my-2.5">
                    <label for="fullname" class="block mb-1 ps-1">Full Name:</label>
                    <input type="text" name="fullname" required class="block px-2 py-1 w-full border focus:outline-none focus:ring-0 focus:border-gray-600 rounded" placeholder="Enter your full name">
                </div>
                <div class="mb-2.5">
                    <label for="password" class="block mb-1 ps-1">Password:</label>
                    <input type="password" name="password" required class="block px-2 py-1 w-full border focus:outline-none focus:ring-0 focus:border-gray-600 rounded" placeholder="Enter your password">
                </div>
                <div class="mb-2.5">
                    <label for="email" class="block mb-1 ps-1">Email:</label>
                    <input type="email" name="email" required class="block px-2 py-1 w-full border focus:outline-none focus:
                    ring-0 focus:border-gray-600 rounded" placeholder="Enter your email">
                    </div>
                    <div>
                        <input type="submit" value="Register" class="mt-2 w-full bg-[#01A768] text-[#F1F5F9] p-1 rounded font-semibold">
                        <input type="hidden" name="submit_check" value="1">
                    </div>
                    <div>
                        <p class="text-center text-sm text-p[#1E1E1E] mt-4">Already have an account? <a href="index.php" class="font-semibold">Sign In</a></p>
                    </div>
                </form>
            </div>
        </body>
        </html>
        ';
}

function validate_form()
{
    $errors = array();

    $username = strtolower(trim($_POST['username']));
    $fullname = ucwords(strtolower(trim($_POST['fullname'])));
    $password = strtolower(trim($_POST['password']));
    $email = strtolower(trim($_POST['email']));


    if (strlen($username) < 6) {
        $errors[] = "Username must be at least 6 characters long.";
        return $errors;
    }

    if (username_exists($username)) {
        $errors[] = "Username already exists. Please choose a different username.";
        return $errors;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
        return $errors;
    }


    if (email_exists($email)) {
        $errors[] = "Email already exists. Please use a different email address.";
        return $errors;
    }

    if (strlen($password) < 6) {
        $errors[] = "Password must be at least 6 characters long.";
        return $errors;
    }

    return $errors;
}

function username_exists($username)
{
    global $conn;

    $stmt = $conn->prepare("SELECT * FROM admin WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $stmt->close();
        return true;
    } else {
        $stmt->close();
        return false;
    }
}

function email_exists($email)
{
    global $conn;

    $stmt = $conn->prepare("SELECT * FROM admin WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $stmt->close();
        return true;
    } else {
        $stmt->close();
        return false;
    }
}
?>