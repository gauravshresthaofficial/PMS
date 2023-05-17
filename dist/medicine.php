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
    <div class="grid grid-cols-12 gap-0">

        <!-- sidebar -->
        <?php
        $active = "medicine";
        include "sidebar.php";
        ?>

        <!-- Header -->
        <div class="col-span-10 relative">
            <div class="bg-slate-200 h-screen flex flex-col">
                <?php include "header.php";
                head("Medicine");
                ?>


                <!-- body -->
                <div id="error-message" class="absolute z-10 rounded-md right-1/2 top-3/4 bg-[#9c4150] text-white translate-y-1/2 translate-x-1/2 px-6 w-2/3 text-center py-2">
                </div>
                <div id="success-message" class="absolute z-10 rounded-md right-1/2 top-3/4 bg-teal-500 text-white translate-y-1/2 translate-x-1/2 px-6 w-2/3 text-center py-2"> nepal
                </div>

                <div class="flex h-12 w-full flex-row gap-4 justify-end items-center px-6 py-4">
                    <button type="submit" id="new-btn" class="toggle-id bg-teal-500 text-white py-1 px-3 rounded-md border border-teal-700 hover:scale-105 delay-75">New Medicine</button>
                    <button type="submit" id="med_list" class="med_list border border-pms-purple py-1 px-3 bg-white rounded-md hover:scale-105 delay-75">Medicine List</button>
                    <button type="submit" id="med_stock" class="stock med_stock border border-pms-purple py-1 px-3 bg-white rounded-md hover:scale-105 delay-75" data-for = "stock">Medicine Stock</button>
                    <a href="pdf/medicine-pdf.php" id="print" class="border border-gray-900 py-1 px-6 bg-pms-white rounded-md hover:scale-105 delay-75">Save & Print</a>
                </div>


                <div class="w-full pb-4 h-full">

                    <div class="flex flex-col mx-4 py-4 px-8 bg-white rounded-lg h-full">
                        <div data-for="med" class="flex-none flex justify-between w-full m-auto py-2" id="search-bar">
                            <div>
                                <label for="search" class="font-semibold text-pms-purple ps-2">Search:</label>
                                <input type="text" id="search" class=" bg-gray-50 rounded-md ms-2 py-1 ps-2 border border-gray-200 w-52" placeholder="Search Medicine" />
                            </div>
                            <div id="button" class="flex gap-4">

                            </div>
                        </div>

                        <div id="table-list" class="grow relative">

                        </div>

                    </div>

                </div>

            </div>
        </div>
        <!-- modal for editing the user details -->
        <div class="modal absolute">
            <div class="fixed backdrop-blur w-screen h-screen flex items-center justify-center">
                <div class="modal-overlay z-50 absolute w-full h-full bg-gray-900 opacity-80"></div>
                <div id="modalcontent" class="modal-container bg-white w-2/5 h-[80%] px-6 py-2 rounded shadow-lg z-50 overflow-y-auto">
                    
                </div>
            </div>
        </div>
        <script src="../js/jquery.js"></script>
        <script src="js/medicine.js"></script>
        <script src="js/sidebar.js"></script>
        <script src="js/header.js"></script>

</body>

</html>