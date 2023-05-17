<?php
session_start();
if (!isset($_SESSION['name'])) {
    header("location: index.php");
    exit();
} else {
    $name = $_SESSION['name'];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- <link rel="stylesheet" href="style01.css"> -->
    <style>
        * {
            margin: 0;
            padding: 0;
        }

        .hide {
            display: none;
        }
    </style>
</head>

<body>
    <div class="grid grid-cols-12 gap-0">

        <!-- sidebar -->
        <?php
        $active = "customer";
        include "sidebar.php";
        ?>

        <!-- Header -->
        <div class="col-span-10 relative">
            <div class="bg-slate-200 h-screen flex flex-col">
                <?php include "header.php";
                head("Customer");
                ?>

                <!-- body -->

                <div id="error-message" class="absolute z-10 rounded-md right-1/2 top-3/4 bg-[#9c4150] text-white translate-y-1/2 translate-x-1/2 px-6 w-2/3 text-center py-2">
                </div>
                <div id="success-message" class="absolute z-10 rounded-md right-1/2 top-3/4 bg-teal-500 text-white translate-y-1/2 translate-x-1/2 px-6 w-2/3 text-center py-2"> nepal
                </div>
                <div id="table-data"></div>

                <div class="flex h-12 w-full flex-row gap-4 justify-end items-center px-6 py-4">
                    <button type="submit" id="new-btn" class="toggle-id bg-teal-500 text-white py-1 px-3 rounded-md border border-pms-green hover:scale-105 delay-75">New Customer</button>
                    <a href="pdf/customer-pdf.php" id="print" class="border border-gray-900 py-1 px-6 bg-pms-white rounded-md hover:scale-105 delay-75">Save & Print</a>
                </div>


                <div class="w-full pb-4 h-full">

                    <div class="flex flex-col mx-4 py-4 px-8 bg-white rounded-lg h-full">
                        <div class="flex-none w-full m-auto py-2" id="search-bar">
                            <label for="search" class="font-semibold text-gray-900 ps-2">By Name:</label>
                            <input type="text" class="search-input bg-gray-50 rounded-md ms-2 py-1 ps-2 border border-gray-200 w-52" data-type="c_name" placeholder="Search Customer" />
                            <label for="search" class="font-semibold text-gray-900 ps-2">By Address:</label>
                            <input type="text" class="search-input bg-gray-50 rounded-md ms-2 py-1 ps-2 border border-gray-200 w-52" data-type="c_address" placeholder="Search Customer" />
                        </div>


                        <div id="customer-list" class="grow relative">

                        </div>

                    </div>

                </div>
                <script src="../js/jquery.js"></script>
                <script src="js/sidebar.js"></script>
                <script src="js/customer.js"></script>
                <script src="js/header.js"></script>


            </div>
        </div>
</body>

</html>