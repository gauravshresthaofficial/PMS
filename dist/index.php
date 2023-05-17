<?php

session_start();
if (isset($_POST['submit_check'])) {
    if ($error = validate_form()) {
        show_form($error);
    } else {
        header("location: home.php");
        exit();
    }
} else {
    show_form();
}

echo '
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>


</head>';
// show_form("");

function show_form($error = "")
{

    print <<<HTML
<body >
    <div class="wrapper bg-[#1E1E1E] h-screen font-poppins flex justify-center items-center">
        <form action="$_SERVER[PHP_SELF]" method="post" class="bg-[#F1F5F9] p-6 w-3/12 my-auto rounded-md">
            <h4 class="text-center text-[#01A768] font-bold text-2xl">PMS</h4>
            <hr class="my-3">
            <span class="text-sm text-red-500 text-center block">$error</span>
            <div class="mb-2">
                <label for="Username" class="block mb-1 ps-1">Username:</label>
                <input type="text" name="username" required class="block px-2 py-1 w-full border focus:outline-none focus:ring-0 focus:border-gray-600 rounded" placeholder="Enter your username">
            </div>

            <div class="mb-2.5">
                <label for="Password" class="block mb-1 ps-1">Password:</label>
                <input type="password" name="password" required class="block px-2 py-1 w-full border focus:outline-none focus:ring-0 focus:border-gray-600 rounded" placeholder="Enter your password">
            </div>
            <div class="text-end">
                <a href="reset-password.php" class="block w-full text-end text-sm text-[#1E1E1E] mb-2" >Forget password?</a>
            </div>
            <div>
                <input type="submit" value="Login" class="w-full bg-[#01A768] text-[#F1F5F9] p-1 rounded font-semibold">
                <input type="hidden" name="submit_check" value="1">
            </div>
            <div>
                <p class="text-center text-sm text-[#1E1E1E] mt-4">Don't have an account?<a href="signup.php" class="font-semibold"> Sign Up</a></p>
            </div>
        </form>
    </div>
</body>
</html>

HTML;
}

function validate_form()
{
    $error = "";
    $name = strtolower(trim($_POST['username']));
    $pw = strtolower(trim($_POST['password']));


    // require "validate.php";

    function check_login($name, $pw)
    {
        require "connection.php";

        if ($conn) {
            $error = "";
            $stmt = $conn->prepare("SELECT * FROM admin WHERE USERNAME = ?");
            $stmt->bind_param("s", $name);
            $stmt->execute();
            $result = $stmt->get_result();

            // Check if username exists in the database
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $stored_password = $row['password'];
                if ($pw === $stored_password) {
                    // Password is correct, store full name in session
                    $_SESSION['name'] = $row['fullname'];
                    $_SESSION['username'] = $row['username'];

                } else {
                    $error = "Username and Password do not match!";
                }
            } else {
                $error = "Username not found!";
            }

            $stmt->close();
        } else {
            $error = "Connection error";
        }


        return $error;
    }


    $error = check_login($name, $pw);

    if (empty($error)) {
        header("Location: home.php");
        exit();
    }

    return $error;
}
