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
    <!-- <link rel="stylesheet" href="style001.css"> -->
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
        $active = "";
        // $name=$_SESSION['name'];
        include "sidebar.php";
        ?>


        <!-- Header -->
        <div class="col-span-10 max-h-screen bg-slate-200 flex flex-col relative">
            <!-- <div class="bg-slate-200 flex flex-col h-screen"> -->
            <?php include "header.php";
            head("Dashboard");


            // <!-- body -->
            // Check for error message in session
            if (isset($_SESSION['success'])) : ?>
                <div id="success-message" class="absolute rounded-md right-1/2 top-3/4 bg-teal-500 shadow-md text-white translate-y-1/2 translate-x-1/2 px-6 w-2/3 text-center py-2" data-success-message="<?php echo $_SESSION['success']; ?>">
                    <?php echo $_SESSION['success']; ?>
                </div>
                <?php unset($_SESSION['success']); ?>
            <?php endif; ?>
            


            <!-- <div class="w-full pb-4 h-full"> -->

                <div class="grid grid-rows-3 divide-y-2 m-4 px-8 gap-6 bg-white shadow-lg rounded-lg h-full">

                    <div class="grid row-span-2 grid-cols-12 grid-rows-2 h-full py-4 mt-2">
                        <div id="customer-list" class="flex flex-col gap-6 justify-center shadow-inner  border-2 rounded-md col-span-3 row-span-1 m-2">
                            <p id="customer-num" class="font-bold text-2xl text-center"></p>
                            <p class="font-semibold text-center">Total Customers</p>
                        </div>
                        <div id="medicine-list" class="flex flex-col gap-6 justify-center shadow-inner  border-2 rounded-md col-span-3 row-span-1 m-2">
                            <p id="medicine-num" class="font-bold text-2xl text-center"></p>
                            <p class="font-semibold text-center">Total Medicine</p>
                        </div>
                        <div class="grid grid-rows-6 px-6 pb-4 shadow-inner  border-2 rounded-md col-span-6 row-span-2 mx-2 mt-2">
                            <div class="flex gap-4 justify-center">
                                <p class="font-semibold text-xl text-center w-full my-auto">Report</p>
                            </div>
                            <table class="row-span-5 w-full">
                                <tr class="">
                                    <td class=" border w-2/3 ps-12 text-lg font-medium">Today's Sales</td>
                                    <td id="today-sales" class=" border w-1/3 text-center ps-4 text-lg font-medium">Rs </td>
                                </tr>
                                <tr class="">
                                    <td class=" border w-2/3 ps-12 text-lg font-medium">Today's Purchases</td>
                                    <td id="today-purchases" class=" border w-1/3 text-center ps-4 text-lg font-medium">Rs </td>
                                </tr>
                                <tr class="">
                                    <td class=" border w-2/3 ps-12 text-lg font-medium">Expired Medicine</td>
                                    <td id="expired-med" class=" border w-1/3 text-center ps-4 text-lg font-medium"></td>
                                </tr>
                                <tr class="">
                                    <td class=" border w-2/3 ps-12 text-lg font-medium">Out of Stock</td>
                                    <td id="out-of-stock" class=" border w-1/3 text-center ps-4 text-lg font-medium"></td>
                                </tr>

                            </table>

                        </div>
                        <div id="supplier-list" class="flex flex-col gap-6 justify-center shadow-inner  border-2 rounded-md col-span-3 row-span-1 mx-2 mt-2">
                            <p id="supplier-num" class="font-bold text-2xl text-center"></p>
                            <p class="font-semibold text-center">Total Suppliers</p>
                        </div>
                        <div id="invoice-list" class="flex flex-col gap-6 justify-center shadow-inner  border-2 rounded-md col-span-3 row-span-1 mx-2 mt-2">
                            <p id="invoice-num" class="font-bold text-2xl text-center"></p>
                            <p class="font-semibold text-center">Total Invoices</p>
                        </div>

                    </div>

                    <div class="flex justify-around items-center w-full text-white">
                        <a href="invoice.php" class="new  text-white hover:text-[#2DD4BF] flex flex-col gap-2 justify-center bg-[#2DD4BF]  h-4/5 w-[18%]  border-2  rounded-md hover:bg-white hover:scale-105">
                            <div class="image p-4 w-16 h-16 mx-auto rounded-full  border-2  border-white">
                                <img src="../icons/invoice.svg" class="p-1/2 h-full mx-auto">
                            </div>
                            <p class="font-semibold text-center">New Invoice</p>
                        </a>
                        <a href="medicine.php" id="new-medicine" class="new shadow-md hover:text-[#2DD4BF] flex flex-col gap-2 justify-center bg-[#2DD4BF]  h-4/5 w-[18%]  border-2  rounded-md hover:bg-white hover:scale-105">
                            <div class="image p-4 w-16 h-16 mx-auto rounded-full  border-2  border-white">
                                <img src="../icons/medicine.svg" class="p-1/2 h-full mx-auto">
                            </div>
                            <p class="font-semibold text-center">New Medicine</p>
                        </a>
                        <a href="customer.php" id="new-customer" class="new shadow-md hover:text-[#2DD4BF] flex flex-col gap-2 justify-center bg-[#2DD4BF]  h-4/5 w-[18%]  border-2  rounded-md hover:bg-white hover:scale-105">
                            <div class="image p-4 w-16 h-16 mx-auto rounded-full  border-2  border-white">
                                <img src="../icons/customer.svg" class="p-1/2 h-full mx-auto">
                            </div>
                            <p class="font-semibold text-center">New Customer</p>
                        </a>
                        <a href="suppliers.php" id="new-supplier" class="new shadow-md hover:text-[#2DD4BF] flex flex-col gap-2 justify-center bg-[#2DD4BF]  h-4/5 w-[18%]  border-2  rounded-md hover:bg-white hover:scale-105">
                            <div class="image p-4 w-16 h-16 mx-auto rounded-full  border-2  border-white">
                                <img src="../icons/suppliers.svg" class="p-1/2 h-full mx-auto">
                            </div>
                            <p class="font-semibold text-center ">New Supplier</p>
                        </a>
                        <a href="purchases.php" class="new shadow-md hover:text-[#2DD4BF] flex flex-col gap-2 justify-center bg-[#2DD4BF]  h-4/5 w-[18%]  border-2  rounded-md hover:bg-white hover:scale-105">
                            <div class="image p-4 w-16 h-16 mx-auto rounded-full  border-2  border-white">
                                <img src="../icons/purchase.svg" class="p-1/2 h-full mx-auto">
                            </div>
                            <p class="font-semibold text-center">New Purchase</p>
                        </a>


                    </div>

                </div>

            <!-- </div> -->
            <!-- </div> -->
        </div>

    </div>


    <script src="../js/jquery.js"></script>
    <script src="js/home.js"></script>
    <script src="js/sidebar.js"></script>
    <script src="js/header.js"></script>
</body>

</html>