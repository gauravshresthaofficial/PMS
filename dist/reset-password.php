<?php
session_start();

if (isset($_POST['submit_check'])) {
    if ($error = validate_form()) {
        show_form($error);
    } else {
        $email = strtolower(trim($_POST['email']));
        $newPassword = strtolower(trim($_POST['new_password']));

        if (email_exists($email)) {
            reset_password($email, $newPassword);
            header("Location: index.php");
            exit();
        } else {
            show_form("Email not found. Sign up below.");
        }
    }
} else {
    show_form();
}

function show_form($error = "")
{
    echo '
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Reset Password</title>
        <script src="https://cdn.tailwindcss.com"></script>


    </head>
    <body>
        <div class="wrapper bg-[#1E1E1E] h-screen font-poppins flex justify-center items-center">
            <form action="' . $_SERVER['PHP_SELF'] . '" method="post" class="bg-[#F1F5F9] p-6 my-auto w-3/12 rounded-md">
                <h4 class="text-center text-[#01A768] font-bold text-2xl">Pharmacy Management System</h4>
                <hr class="my-3">
                <span class="text-sm text-red-500 text-center block">' . $error . '</span>
                <div class="mb-2.5">
                    <label for="email" class="block mb-1 ps-1">Email:</label>
                    <input type="email" name="email" required class="block px-2 py-1 w-full border focus:outline-none focus:ring-0 focus:border-gray-600 rounded" placeholder="Enter your email">
                </div>
                <div class="mb-2.5">
                    <label for="new_password" class="block mb-1 ps-1">New Password:</label>
                    <input type="password" name="new_password" required class="block px-2 py-1 w-full border focus:outline-none focus:ring-0 focus:border-gray-600 rounded" placeholder="Enter your new password">
                </div>
                <div>
                    <input type="submit" value="Reset Password" class="mt-2 w-full bg-[#01A768] text-[#F1F5F9] p-1 rounded font-semibold">
                    <input type="hidden" name="submit_check" value="1">
                </div>
                <div>
                <p class="text-center text-sm text-[#1E1E1E] mt-4">Don\'t have an account?<a href="signup.php" class="font-semibold"> Sign Up</a></p>
                <p class="text-center text-sm text-[#1E1E1E] mt-2">Go back to <a href="index.php" class="font-semibold">Login</a></p>
                </div>
                </form>
        </div>
    </body>
    </html>
    ';
}


function validate_form()
{
    $error = "";

    if (empty($_POST['new_password'])) {
        $error = "Please enter a new password.";
    } elseif (strlen($_POST['new_password']) < 6) {
        $error = "New password must be at least 6 characters long.";
    }

    return $error;
}


function email_exists($email)
{
    require "connection.php";

    if ($conn) {
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
    } else {
        $error = "Connection error";
        return false;
    }
}

function reset_password($email, $newPassword)
{
    require "connection.php";

    if ($conn) {

        $stmt = $conn->prepare("UPDATE admin SET password = ? WHERE email = ?");
        $stmt->bind_param("ss", $newPassword, $email);
        $stmt->execute();
        $stmt->close();
    } else {
        $error = "Connection error";
    }
}
