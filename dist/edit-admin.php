<?php
session_start();
if (!isset($_SESSION['name'])) {
    header("location: index.php");
    exit();
} else {
    $name = $_SESSION['name'];
}
include "connection.php";
$default = array();

// SET DEFAULT VALUE
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];

    // Prepare SQL statement
    $stmt = $conn->prepare("SELECT * FROM admin WHERE username = ? LIMIT 1");
    $stmt->bind_param("s", $username);

    // Execute statement
    $stmt->execute();

    // Get result
    $result = $stmt->get_result();

    // Check if any rows were returned
    if ($result->num_rows > 0) {
        // Output data of each row
        $row = $result->fetch_assoc();
        $default['username'] = $_SESSION['username'];
        $default['fullname'] = $row['fullname'];
        $default['email'] = $row['email'];
        $default['password'] = $row['password'];
    } else {
        return;
    }
}

// Check for error message in session
if (isset($_SESSION['error'])) {
    $errorMessage = $_SESSION['error'];
    unset($_SESSION['error']);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Admin</title>
    <script src="../js/jquery.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet" href="style01.css">
    <style>
        .new:hover div {
            /*  border: 2px solid #2DD4BF; */
            background-color: #2DD4BF;
        }
    </style>
</head>

<body>
    <div class="grid grid-cols-12">
        <!-- sidebar -->
        <?php
        $active = "admin";
        // $name=$_SESSION['name'];
        include "sidebar.php";
        ?>

        <!-- Header -->
        <div class="col-span-10 max-h-screen bg-slate-200 flex flex-col relative">
            <!-- <div class="bg-slate-200 flex flex-col h-screen"> -->
            <?php include "header.php";
            head("Edit Admin");
            ?>

            <!-- Body -->
            <!-- Error Message -->
            <?php if (isset($errorMessage)) : ?>
                <div id="notice" class="w-full">
                    <div id="error-message" class="absolute rounded-md right-1/2 top-3/4 bg-pms-error text-white translate-y-1/2 translate-x-1/2 px-6 w-2/3 text-center py-2">
                        <?php echo $errorMessage; ?>
                    </div>
                </div>
                <?php unset($errorMessage); ?>
            <?php endif; ?>

            <div class="w-full py-4 h-full">
                <div class="grid grid-rows-3 divide-y-2 mx-4 py-4 px-8 gap-6 bg-white shadow-lg rounded-lg h-full">
                    <div class="p-4">
                        <!-- Add or edit heading -->
                        <div class="text-lg ps-2 font-bold border border-t-0 border-l-0 border-r-0 pb-2 border-gray-200">
                            Edit Admin Details
                        </div>
                                                <!-- Form -->
                                                <form action="update_admin.php" method="POST">
                            <div class="w-fit pt-4 flex flex-col gap-4">
                                <div>
                                    <div class="w-[200px] inline-block text-pms-dark font-semibold ps-2">Username:</div>
                                    <input type="text" name="username" id="username" class="bg-gray-50 w-[300px] rounded-md py-1 ps-2 border" value="<?php echo $default['username']; ?>" placeholder="Username" readonly>
                                </div>
                                <div>
                                    <div class="w-[200px] inline-block text-pms-dark font-semibold ps-2">Email:</div>
                                    <input type="text" name="email" id="email" class="w-[300px] rounded-md py-1 ps-2 border" value="<?php echo $default['email']; ?>" placeholder="Email" required>
                                </div>
                                <div>
                                    <div class="w-[200px] inline-block text-pms-dark font-semibold ps-2">Fullname:</div>
                                    <input type="text" name="fullname" id="fullname" class="w-[300px] rounded-md py-1 ps-2 border" value="<?php echo $default['fullname']; ?>" placeholder="Fullname" required>
                                </div>
                                <div>
                                    <div class="w-[200px] inline-block text-pms-dark font-semibold ps-2">Password:</div>
                                    <div class=" inline-block relative">
                                        <input type="password" name="password" id="password" class="w-[300px] rounded-md py-1 ps-2 border " value="<?php echo $default['password']; ?>" placeholder="Password" minlength="6" required>
                                        <span class="password-toggle cursor-pointer right-4 top-1  bg-pms-light-blue text-pms-dark rounded-md ml-2 absolute">Show</span>
                                    </div>
                                </div>

                                <div class="mt-2 text-end">
                                    <button type="submit" id="update-admin" class="bg-[#2DD4BF] text-white py-1 px-6 rounded-md border border-pms-green hover:scale-105 delay-75">
                                        Update
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Show/Hide Password
        $(document).ready(function () {
            $(".password-toggle").click(function () {
                var passwordField = $("#password");
                var passwordFieldType = passwordField.attr("type");

                if (passwordFieldType === "password") {
                    passwordField.attr("type", "text");
                    $(this).text("Hide");
                } else {
                    passwordField.attr("type", "password");
                    $(this).text("Show");
                }
            });
        });
    </script>
</body>

</html>
