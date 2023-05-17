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
</head>

<body>
    <div class="grid grid-cols-12">

        <!-- sidebar -->
        <?php
        $active = "suppliers";
        include "sidebar.php";
        ?>

        <!-- Header -->
        <div class="col-span-10 relative">
            <div class="bg-slate-200 h-screen flex flex-col">
                <?php include "header.php";
                head("Suppliers");
                ?>


                <!-- body -->
                <div id="error-message" class="absolute rounded-md right-1/2 top-3/4 bg-[#9c4150] text-white translate-y-1/2 translate-x-1/2 px-6 w-2/3 text-center py-2">
                </div>
                <div id="success-message" class="absolute rounded-md right-1/2 top-3/4 bg-teal-500 text-white translate-y-1/2 translate-x-1/2 px-6 w-2/3 text-center py-2">
                </div>
                <div id="table-data"></div>

                <div class="flex h-12 w-full flex-row gap-4 justify-end items-center px-6 py-4">
                    <button type="submit" id="new-btn" class="toggle-id bg-teal-500 text-white py-1 px-3 rounded-md border border-pms-green hover:scale-105 delay-75">New Supplier</button>
                    <a href="pdf/supplier-pdf.php" id="print" class="border border-gray-900 py-1 px-6 bg-[#F1F5F9] rounded-md hover:scale-105 delay-75">Save & Print</a>
                </div>




                <div class="w-full pb-4 h-full">

                    <div class="flex flex-col mx-4 py-4 px-8 bg-white rounded-lg h-full">
                        <div class="flex-none w-full m-auto py-2" id="search-bar">
                            <label for="search" class="font-semibold text-gray-900 ps-2">By Name:</label>
                            <input type="text" class="search-input bg-gray-50 rounded-md ms-2 py-1 ps-2 border border-gray-200 w-52" data-type="s_name" placeholder="Search Supplier" />
                            <label for="search" class="font-semibold text-gray-900 ps-2">By Address:</label>
                            <input type="text" class="search-input bg-gray-50 rounded-md ms-2 py-1 ps-2 border border-gray-200 w-52" data-type="s_address" placeholder="Search Supplier" />
                        </div>

                        <div id="suppliers-list" class="grow relative">

                        </div>

                    </div>

                </div>
                <script src="../js/jquery.js"></script>
                <script src="js/supplier.js"></script>
                <script src="js/sidebar.js"></script>
                <script src="js/header.js"></script>
                <script type="text/javascript">
                    // $(document).ready(function() {


                    //     if (localStorage.getItem('createNewSupplier') === 'true') {
                    //         // Display the "New Supplier" form here
                    //         localStorage.removeItem('createNewSupplier'); // Clear the flag once it's been used
                    //         newSupplier();
                    //         return;
                    //     }
                    //     else{
                    //         load_list();
                    //     }
                    //     function load_list() {

                    //             if ($(".toggle-id").attr("id") != "new-btn") {
                    //                 $(".toggle-id").attr("id", "new-btn");
                    //             $(".toggle-id").text("New Supplier");
                    //         }
                    //         $("#sap").show();
                    //         $("#search-bar").show();
                    //         $("#search").val("");

                    //         $.ajax({
                    //             url: "php/suppliers/suppliers-list.php",
                    //             type: "POST",
                    //             success: function(data) {
                    //                 $("#suppliers-list").html(data);
                    //             }
                    //         });


                    //     }



                    //     $(document).on("click", ".pagination", function() {
                    //         page = $(this).data("page");
                    //         $.ajax({
                    //             url: "php/suppliers/suppliers-list.php",
                    //             type: "POST",
                    //             data: {
                    //                 page: page,
                    //             },
                    //             success: function(data) {
                    //                 $("#suppliers-list").html(data);
                    //             }
                    //         });
                    //     });

                    //     $(document).on("click", "#go-back", function() {
                    //         load_list();
                    //     });

                    //     $(document).on("click", ".delete-btn", function() {
                    //         if (confirm("Do you really want to delete this record ?")) {
                    //             var sid = $(this).data("sid");
                    //             var element = this;
                    //             var message = '<div id="error-message" class="absolute w-1/3 rounded-md right-1/2 top-3/4 opacity-60 bg-pms-error text-white translate-y-1/2 translate-x-1/2 px-6 w-2/3 text-center py-2">Record Deleted</div>';
                    //             $.ajax({
                    //                 url: "php/suppliers/delete-supplier.php",
                    //                 type: "POST",
                    //                 data: {
                    //                     sid: sid
                    //                 },
                    //                 success: function(data) {
                    //                     alert(data);
                    //                     if (data == 1) {
                    //                         $(element).closest("tr").fadeOut();
                    //                         $("#notice").append(message);
                    //                         $("#notice").delay(4000).fadeOut();
                    //                     } else {
                    //                         $("#error-message").html("Can't Delete Record.").slideDown();
                    //                         // $("#success-message").slideUp();
                    //                     }
                    //                 }

                    //             })
                    //         }
                    //     });

                    //     //Display form to update
                    //     $(document).on("click", ".edit-btn", function() {
                    //         var s_id = $(this).data("eid");
                    //         var element = this;

                    //         function isEmpty(variable) {
                    //             return $.trim(variable) == '';
                    //         }

                    //         if ($(".toggle-id").attr("id") == "new-btn") {
                    //             $(".toggle-id").attr("id", "go-back");
                    //             $(".toggle-id").text("Show Suppliers");
                    //         }

                    //         $("#sap").hide();
                    //         $("#search-bar").hide();

                    //         $.ajax({
                    //             url: "php/suppliers/new-supplier.php",
                    //             type: "POST",
                    //             data: {
                    //                 s_id: s_id,
                    //                 act: 'edit'
                    //             },
                    //             success: function(data) {
                    //                 if (!isEmpty(data)) {
                    //                     $("#suppliers-list").html(data);
                    //                 } else {
                    //                     load_list();
                    //                     var message = '<div id="error-message" class="absolute w-1/3 rounded-md right-1/2 top-3/4 opacity-60 bg-pms-error text-white translate-y-1/2 translate-x-1/2 px-6 w-2/3 text-center py-2">Operation Failed</div>';
                    //                     $("#notice").append(message);
                    //                     $("#notice").delay(4000).fadeOut();

                    //                 }
                    //             }

                    //         })
                    //     });

                    //     //Update data to database and go back to table
                    //     $(document).on("click", "#update-btn", function() {
                    //         var s_id = $("#s_id").val();
                    //         var s_name = $("#s_name").val();
                    //         var s_email = $("#s_email").val();
                    //         var s_address = $("#s_address").val();
                    //         var s_number = $("#s_number").val();

                    //         var message = '<div id="error-message" class="absolute w-1/3 rounded-md right-1/2 top-3/4 opacity-60 bg-pms-error text-white translate-y-1/2 translate-x-1/2 px-6 w-2/3 text-center py-2">Record Updated</div>';
                    //         $.ajax({
                    //             url: "php/suppliers/update-supplier.php",
                    //             type: "POST",
                    //             data: {
                    //                 s_id: s_id,
                    //                 s_name: s_name,
                    //                 s_email: s_email,
                    //                 s_address: s_address,
                    //                 s_number: s_number
                    //             },
                    //             success: function(data) {
                    //                 if (data == 1) {
                    //                     load_list();
                    //                     $("#notice").append(message);
                    //                     $("#notice").delay(4000).fadeOut();
                    //                 } else {
                    //                     load_list();
                    //                     $("#notice").append(message);
                    //                     $("#error-message").html("Can't Update Record.").slideDown();
                    //                     $("#notice").delay(4000).fadeOut();
                    //                 }
                    //             }

                    //         })






                    //     });

                    //     //Display form to add
                    //     $(document).on("click", "#new-btn", function() {
                    //         var element = this;

                    //         newSupplier();
                    //     });

                    //     function isEmpty(variable) {
                    //             return $.trim(variable) == '';
                    //         }

                    //     function newSupplier() {
                    //             if ($(".toggle-id").attr("id") == "new-btn") {
                    //                 $(".toggle-id").attr("id", "go-back");
                    //                 $(".toggle-id").text("Show Suppliers");
                    //             }

                    //             $("#sap").hide();
                    //             $("#search-bar").hide();

                    //             $.ajax({
                    //                 url: "php/suppliers/new-supplier.php",
                    //                 type: "POST",
                    //                 data: {
                    //                     act: 'add'
                    //                 },
                    //                 success: function(data) {
                    //                     if (!isEmpty(data)) {
                    //                         $("#suppliers-list").html(data);
                    //                     } else {
                    //                         load_list();
                    //                         var message = '<div id="error-message" class="absolute w-1/3 rounded-md right-1/2 top-3/4 opacity-60 bg-pms-error text-white translate-y-1/2 translate-x-1/2 px-6 w-2/3 text-center py-2">Operation Failed</div>';
                    //                         $("#notice").append(message);
                    //                         $("#notice").delay(4000).fadeOut();

                    //                     }
                    //                 }

                    //             })
                    //         }

                    //     //Add data to database and go back to table
                    //     $(document).on("click", "#add-btn", function() {
                    //         // var s_id = $("#s_id").val();
                    //         var s_name = $("#s_name").val();
                    //         var s_email = $("#s_email").val();
                    //         var s_address = $("#s_address").val();
                    //         var s_number = $("#s_number").val();

                    //         var message = '<div id="error-message" class="absolute w-1/3 rounded-md right-1/2 top-3/4 opacity-60 bg-pms-error text-white translate-y-1/2 translate-x-1/2 px-6 w-2/3 text-center py-2">Record Added.</div>';
                    //         $.ajax({
                    //             url: "php/suppliers/add-supplier.php",
                    //             type: "POST",
                    //             data: {
                    //                 s_name: s_name,
                    //                 s_email: s_email,
                    //                 s_address: s_address,
                    //                 s_number: s_number
                    //             },
                    //             success: function(data) {
                    //                 alert(data);
                    //                 if (data == 1) {
                    //                     load_list();
                    //                     $("#notice").append(message);
                    //                     $("#notice").delay(4000).fadeOut();
                    //                 } else if (data == 2) {
                    //                     load_list();
                    //                     $("#notice").append(message);
                    //                     $("#error-message").html("Name already exists.").slideDown();
                    //                     $("#notice").delay(4000).fadeOut();
                    //                 } else {
                    //                     load_list();
                    //                     $("#notice").append(message);
                    //                     $("#error-message").html("Can't Add Record.").slideDown();
                    //                     $("#notice").delay(4000).fadeOut();
                    //                 }
                    //             }

                    //         })






                    //     });



                    //     //live search
                    //     $(document).on("keyup", "#search", function() {
                    //         var search_term = $(this).val();

                    //         if ($(this).val().length === 0) {
                    //             load_list();
                    //         } else {


                    //             $.ajax({
                    //                 url: "php/suppliers/live-search.php",
                    //                 type: "POST",
                    //                 data: {
                    //                     search: search_term
                    //                 },
                    //                 success: function(data) {
                    //                     $('#suppliers-list').html(data);
                    //                 }
                    //             });
                    //         }
                    //     });


                    // });
                </script>
            </div>
        </div>
</body>

</html>