<?php
session_start();
if(!isset($_SESSION['name'])){
    header("location: index.php");
        exit();
}
else{
    $name=$_SESSION['name'];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="style01.css">
</head>

<body>
    <div class="grid grid-cols-12">


        <!-- sidebar -->
        <?php
        $active = "invoice";
        include "sidebar.php";
        ?>


        <!-- Header -->
        <div class="col-span-10 max-h-screen bg-slate-200 flex flex-col">
            <!-- <div class="bg-slate-200 flex flex-col h-screen"> -->
            <?php include "header.php";
            head("Dashboard");
            ?>

            <!-- body -->
            <div id="notice" class="w-full">
            </div>
            <!-- <div id="table-data"></div> -->

            <div class="flex h-12 w-full flex-row gap-4 justify-end items-center px-6 py-4">
                <button type="submit" id="manage-invoice" class="toggle-id bg-pms-green-light text-white py-1 px-3 rounded-md border border-pms-green hover:scale-105 delay-75">Manage Invoice</button>
                <button type="submit" id="sap" class="border border-pms-purple py-1 px-3 bg-pms-white rounded-md hover:scale-105 delay-75">Save & Print</button>
            </div>

            <div class="w-full pb-4 h-full">

                <div class="flex flex-col mx-4 py-4 px-8 bg-white rounded-lg h-full">

                    <div class="flex-none w-full m-auto py-2" id="search-bar">
                        <label for="search" class="font-semibold text-pms-purple ps-2">Search:</label>
                        <input type="text" id="search" class="bg-gray-50 rounded-md ms-2 py-1 ps-2 border border-gray-200 w-52" placeholder="Search Customer" />
                    </div>

                    <form id="new-invoice" class="flex flex-col gap-4 relative h-full ">

                    </form>

                </div>

            </div>
            <!-- </div> -->
        </div>

    </div>

    <script src="../js/jquery.js"></script>
    <script src="js/header.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            function load_list() {
                if ($(".toggle-id").attr("id") != "manage-invoice") {
                    $(".toggle-id").attr("id", "manage-invoice");
                    $(".toggle-id").text("Manage Invoice");
                }
                $("#sap").show();
                $("#search-bar").hide();
                // $("#search").val("");

                $.ajax({
                    url: "new-invoice.html",
                    type: "POST",
                    success: function(data) {
                        $("#new-invoice").html(data).slideDown();
                        invoice_number();
                    }
                });

            }

            function invoice_number() {
                $.ajax({
                    url: "php/invoice/invoice-number.php",
                    type: "POST",
                    dataType: "JSON",
                    data: {
                        act: "get"
                    },
                    success: function(data) {
                        disable("#i_id", data.invoice_number);
                    }
                });
            }

            load_list();

            // Show option for customer name
            $(document).on("keyup", "#c_name", function() {
                var searchValue = $(this).val();
                enable("#c_address");
                enable("#c_number");
                if (searchValue.length >= 2) {
                    $.ajax({
                        url: "php/invoice/autocomplete.php",
                        type: "POST",
                        data: {
                            search: searchValue,
                            for: "name",
                            of: "customer",
                            attr: "c_name"
                        },
                        success: function(data) {
                            $("#c-name-results").fadeIn("fast").html(data);
                        }
                    });
                } else {
                    $("#c-name-results").fadeOut();

                }
            });

            // If not active fadeout the suggestion
            $(document).on("blur", "#c_name", function() {
                $("#c-name-results").fadeOut();
            });

            //Auto complete name for customer details
            $(document).on("click", "#c-name-results li", function() {
                $("#c_name").val($(this).text());
                $("#c-name-results").fadeOut();

                var searchValue = $("#c_name").val();

                $.ajax({
                    url: "php/invoice/autocomplete.php",
                    type: "POST",
                    dataType: "JSON",
                    data: {
                        search: searchValue,
                        for: "details",
                        of: "customer"
                    },
                    success: function(data) {
                        if (data) {
                            disable(c_address, data.c_address);
                            disable(c_number, data.c_number);
                        }
                    }
                });
            });

            // Show option for medicine name
            $(document).on("keyup", ".med_name", function() {
                var searchValue = $(this).val();
                var parentDiv = $(this).closest('.med-row');
                var medResults = parentDiv.find('.med-results');
                // var div = '<div id="med-results" class="med_results relative"></div>';

                if (searchValue.length >= 2) {
                    $.ajax({
                        url: "php/invoice/autocomplete.php",
                        type: "POST",
                        data: {
                            search: searchValue,
                            for: "name",
                            of: "medicine_stock",
                            attr: "med_name"
                        },
                        success: function(data) {
                            // alert(2);
                            medResults.fadeIn("fast").append(data);
                        }
                    });
                } else {
                    medResults.fadeOut();

                }
            });

            // If not active fadeout the suggestion
            $(document).on("blur", ".med_name", function() {
                $(".med-results").fadeOut();
            });

            //Auto complete name for medicine details
            $(document).on("click", ".med-results li", function() {
                var parentDiv = $(this).closest('.med-row');
                var med_name = parentDiv.find('.med_name');
                med_name.val($(this).text());
                $(".med-results").fadeOut();

                var searchValue = parentDiv.find(".med_name").val();
                var med_mrp = parentDiv.find(".med_mrp");
                // alert(med_mrp.val());
                var med_exp_date = ("#med_exp_date");
                var med_ava_qty = ("#med_ava_qty");

                $.ajax({
                    url: "php/invoice/autocomplete.php",
                    type: "POST",
                    dataType: "JSON",
                    data: {
                        search: searchValue,
                        for: "details",
                        of: "medicine_stock"
                    },
                    success: function(data) {
                        if (data) {
                            disable(med_mrp, data.mrp);
                            disable(med_exp_date, data.exp_date);
                            disable(med_ava_qty, data.qty);
                            medTotalcal(parentDiv);
                        }
                    }
                });
            });

            //Calculation of total on entry of qty
            $(document).on("keyup", ".med_qty", function() {
                var parentDiv = $(this).closest('.med-row');
                medTotalcal(parentDiv);

            });



            //add row for another medicine
            $(document).on("click", "#add_med", function(e) {
                e.preventDefault();
                var row = $('.med_list .med-row:last').clone();
                row.find('input').val('');
                row.find('input:not([id="remove_med"])').val('');
                var addBtn = $(".add-btn");
                var num = $('#add_med').data("num");
                num++;

                addBtn.remove();
                $('.med_list').append(row);
                row.hide().slideDown(200);

                $('.med_list').append(addBtn);
                $('#add_med').data("num", num);
            });

            // Remove row
            $(document).on("click", "#remove_med", function(e) {
                e.preventDefault();
                var parentDiv = $(this).closest('.med-row');
                if ($('.med_list .med-row').length > 1) {
                    // alert($('.med_list .med-row').length);
                    // alert(parentDiv.html());
                    parentDiv.slideUp(100, function() {
                        parentDiv.remove();
                    });
                    // parentDiv.remove();
                }
            });

            $(document).on("click", "#calculate", function(e) {
                e.preventDefault();
                var total = 0;

                $('.med_total').each(function() {
                    total += parseFloat($(this).val());
                });

                disable("#total", total);
                netTotal();
                change();
            });

            // Calculate nettotal after discount
            $(document).on("keyup", "#discount", function() {
                netTotal();
            });


            $(document).on("keyup", "#paid", function() {
                change();
            });

            function change() {
                var paid = $("#paid").val();
                var change = $("#change").val();
                var netTotal = $("#net_total").val();

                if (netTotal === "" || paid === '') {
                    disable("#change", 0);
                } else {
                    disable("#change", paid - netTotal);
                }
            }


            function netTotal() {
                var discount = $("#discount").val();
                var total = $("#total").val();
                var netTotal = $("#net_total").val();

                if (total === '') {
                    netTotal = 0;
                } else {
                    netTotal = total * (100 - discount) / 100;
                }

                disable("#net_total", netTotal);
            }


            function disable(input, value) {
                $(input).val(value);
                $(input).prop('disabled', true);
            }

            function enable(input) {
                $(input).prop('disabled', false);
            }

            //Calculate each medicine total
            function medTotalcal(parentDiv) {
                var qtyValue = parentDiv.find('.med_qty').val();
                var mrpValue = parentDiv.find('.med_mrp').val();
                var medTotal = parentDiv.find('.med_total');
                var medTotalValue = medTotal.val();
                if (mrpValue != "") {
                    medTotalValue = qtyValue * mrpValue;
                } else {
                    medTotalValue = 0;
                }
                disable(medTotal, medTotalValue);
            }

            //Display table of Invoice
            $(document).on("click", "#manage-invoice", function() {
                var element = this;

                function invoice_list() {
                    if ($(".toggle-id").attr("id") == "manage-invoice") {
                        $(".toggle-id").attr("id", "go-back");
                        $(".toggle-id").text("Go Back");
                    }

                    $("#sap").hide();
                    $("#search-bar").show();

                    $.ajax({
                        url: "php/invoice/invoice-list.php",
                        type: "POST",
                        success: function(data) {
                            $("#new-invoice").html(data).slideDown();
                            // $("#new-invoice").slideDown();   
                        }
                    });
                }
                invoice_list();

            });

            $(document).on("click", ".pagination", function() {
                page = $(this).data("page");
                $.ajax({
                    url: "php/invoice/invoice-list.php",
                    type: "POST",
                    data: {
                        page: page,
                    },
                    success: function(data) {
                        $("#new-invoice").html(data);
                    }
                });
            });

            //live search
            $(document).on("keyup", "#search", function() {
                var search_term = $(this).val();

                if ($(this).val().length === 0) {
                    invoice_list();
                } else {

                    $.ajax({
                        url: "php/invoice/live-search.php",
                        type: "POST",
                        data: {
                            search: search_term
                        },
                        success: function(data) {
                            $('#new-invoice').html(data);
                        }
                    });
                }
            });

            //Go back from invoice table to new invoice
            $(document).on("click", "#go-back", function() {
                load_list();
            });

        });
    </script>
</body>

</html>