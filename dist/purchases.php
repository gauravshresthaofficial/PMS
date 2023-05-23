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
    <link rel="stylesheet" href="style01.css">
</head>

<body>
    <div class="grid grid-cols-12">


        <!-- sidebar -->
        <?php
        $active = "purchases";
        include "sidebar.php";
        ?>


        <!-- Header -->
        <div class="col-span-10 max-h-screen bg-slate-200 flex flex-col relative">
            <!-- <div class="bg-slate-200 flex flex-col h-screen"> -->
            <?php include "header.php";
            head("Purchases");
            ?>

            <!-- body -->
            <div id="error-message" class="absolute z-10 rounded-md right-1/2 top-3/4 bg-[#9c4150] text-white translate-y-1/2 translate-x-1/2 px-6 w-2/3 text-center py-2">
            </div>
            <div id="success-message" class="absolute z-10 rounded-md right-1/2 top-3/4 bg-teal-500 text-white translate-y-1/2 translate-x-1/2 px-6 w-2/3 text-center py-2"> nepal
            </div>
            <!-- <div id="table-data"></div> -->

            <div class="flex h-12 w-full flex-row gap-4 justify-end items-center px-6 py-4">
                <button type="submit" id="manage-invoice" class="toggle-id bg-[#2DD4BF] text-white py-1 px-3 rounded-md border border-pms-green hover:scale-105 delay-75">Manage Purchases</button>
                <button type="submit" id="sap" class="border border-pms-purple py-1 px-3 bg-[#F1F5F9] rounded-md hover:scale-105 delay-75">Save & Print</button>
                <button type="button" id="calculate" class="border border-pms-purple py-1 px-3 bg-[#F1F5F9] rounded-md hover:scale-105 delay-75">Save</button>
            </div>


            <div class="w-full pb-4 h-full">

                <div class="flex flex-col mx-4 py-4 px-8 bg-white rounded-lg h-full">

                    <div class="flex-none flex flex-row gap-6 w-full m-auto py-2 search-bar">
                        <div>
                            <label for="search-name" class="font-semibold text-pms-purple ps-2">By Supplier Name:</label>
                            <input type="text" id="search-name" class="bg-gray-50 rounded-md ms-2 py-1 ps-2 border border-gray-200 w-52" placeholder="By Supplier" />
                        </div>
                        <div>
                            <label for="search-date" class="font-semibold text-pms-purple ps-2">By Date:</label>
                            <input type="text" id="search-date" class="bg-gray-50 rounded-md ms-2 py-1 ps-2 border border-gray-200 w-52" placeholder="2023-xx-xx" />
                        </div>
                    </div>

                    <form id="new-purchase" class="flex flex-col gap-4 relative h-full ">

                    </form>

                </div>

            </div>
            <!-- </div> -->
        </div>

    </div>

    <script src="../js/jquery.js"></script>
    <script src="js/purchase.js"></script>
    <script src="js/sidebar.js"></script>
    <script src="js/header.js"></script>
</body>

</html>