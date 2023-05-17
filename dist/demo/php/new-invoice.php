<form action="php/new-invoice.php" method="post" class="flex flex-col grow">
    <?php
    $c_default = array(
        "c_name" => "",
        "c_address" => "",
        "c_number" => ""
    );

    $med_default = array(
        "med_name" => "Medicine Name",
        "qty" => "",
        "mrp" => "",
        "total" => "",
        "available_qty" => "",
        "exp_date" => ""
    );

    ?>
    <div class="flex-none h-14">
        <div class="flex h-14 w-full justify-end items-center">
            <input type="submit" value="New Customer" class="bg-pms-green-light text-white py-1 px-3 rounded-md border border-pms-green hover:scale-105 delay-75" />
            <input type="submit" value="Save & Print" class="border border-pms-purple ms-4 me-5 py-1 px-3 bg-pms-white rounded-md hover:scale-105 delay-75" />
        </div>
    </div>

    <div class="flex flex-col grow bg-pms-white z-10 rounded-md justify-items-stretch p-4">
        <div class="flex flex-row gap-6 mx-4 flex-none">
            <div class="basis-4/12">
                <label for="Customer" class="block text-pms-purple mb-1 font-semibold ps-2">Customer:</label>
                <input type="text" name="c_name" value="<?php echo $c_default['c_name'] ?>" class="w-full rounded-md py-1 ps-2" <?php
                                                                                                                                if (($c_default['c_name']) == "") {
                                                                                                                                    echo 'placeholder="Name"';
                                                                                                                                }
                                                                                                                                ?> />
            </div>
            <div class="basis-3/12">
                <label for="Address" class="block text-pms-purple mb-1 font-semibold ps-2">Address:</label>
                <input type="text" name="c_address" value="<?php echo $c_default['c_address'] ?>" class="text-slate-400 w-full rounded-md py-1 ps-2" <?php
                                                                                                                                                        if (($c_default['c_address']) == "") {
                                                                                                                                                            echo 'placeholder="Address"';
                                                                                                                                                        }
                                                                                                                                                        ?> />
            </div>
            <div class="basis-3/12">
                <label for="Contact_Number" class="block text-pms-purple mb-1 font-semibold ps-2">Contact Number:</label>
                <input type="text" name="c_number" value="<?php echo $c_default['c_number'] ?>" class="w-full rounded-md py-1 ps-2" <?php
                                                                                                                                    if (($c_default['c_name']) == "") {
                                                                                                                                        echo 'placeholder="98xxxxxxxx"';
                                                                                                                                    }
                                                                                                                                    ?> />
            </div>
            <div class="basis-3/12">
                <label for="Invoice_No" class="block text-pms-purple mb-1 font-semibold ps-2">Invoice No:</label>
                <input type="text" name="Invoice_No" class="w-full rounded-md py-1 ps-2" placeholder="Invoice No" />
            </div>

        </div>

        <div>
            <hr class="m-5 border-05 border-slate-300" />
        </div>

        <!-- //////////Medicine list///////////// -->
        <!-- //////////////////////////////////// -->
        <div class="medicine-list flex flex-row grow">
            <div class="mx-4 basis-9/12">
                <div class="flex flex-row gap-6">
                    <div class="basis-4/12">
                        <label for="Medicine_name" class="block text-pms-purple mb-1 font-semibold ps-2">Medicine Name:</label>
                        <input type="text" name="med_name" class="w-full rounded-md py-1 ps-2" <?php

                                                                                                if (($med_default['med_name']) == "") {
                                                                                                    echo 'placeholder="Name"';
                                                                                                } else {
                                                                                                    echo 'value="' . $med_default['med_name'] . '"';
                                                                                                }

                                                                                                ?> />
                    </div>
                    <div class="basis-3/12">
                        <label for="Quantity" class="block text-pms-purple mb-1 font-semibold ps-2">Quantity:</label>
                        <input type="text" name="qty" class="w-full rounded-md py-1 ps-2" <?php

                                                                                            if (($med_default['qty']) == "") {
                                                                                                echo 'placeholder="for e.g. 10"';
                                                                                            } else {
                                                                                                echo 'value="' . $med_default['qty'] . '"';
                                                                                            }

                                                                                            ?> />
                    </div>
                    <div class="basis-3/12">
                        <label for="mrp" class="block text-pms-purple mb-1 font-semibold ps-2">MRP:</label>
                        <input type="text" name="mrp" class="w-full rounded-md py-1 ps-2" <?php

                                                                                            if (($med_default['mrp']) == "") {
                                                                                                echo 'placeholder="10"';
                                                                                            } else {
                                                                                                echo 'value="' . $med_default['mrp'] . '"';
                                                                                            }

                                                                                            ?> />
                    </div>
                    <div class="basis-2/12">
                        <label for="Total" class="block text-pms-purple mb-1 font-semibold ps-2">Total:</label>
                        <input type="text" name="Total" class="w-full rounded-md py-1 ps-2" value="<?php $med_default['total'] ?>" />
                    </div>
                </div>
                <div class="mt-4 text-end">
                    <input type="submit" value="Add" class="bg-pms-green-light text-white py-1 px-3 rounded-md border border-pms-green hover:scale-105 delay-75" />
                </div>
            </div>

            <!-- ============================================= -->
            <!-- //////////////////Details//////////////////// -->
            <!-- ============================================= -->
            <div class="flex flex-col gap-2 basis-3/12 border-l me-4 ps-2 border-slate-300">
                <p class="flex-none text-center font-semibold text-lg mb-2">Details</p>
                <div class="flex flex-col grow gap-2">
                    <div class="flex gap-2 flex-row justify-between">
                        <label for="Available_qty" class="grow text-sm text-pms-purple font-semibold ms-1">Available
                            Qty:</label>
                        <input type="text" name="Available_qty" class="flex-none w-16 text-xm rounded-md py-1 ps-2" value="<?php $med_default['available_qty'] ?>" />
                    </div>
                    <div class="flex gap-2 flex-row justify-between items-center">
                        <label for="exp_date" class="grow text-sm text-pms-purple font-semibold ms-1">Expiry Date:</label>
                        <input type="text" name="exp_date" class="flex-none w-16 text-xm rounded-md py-1 ps-2" value="<?php $med_default['exp_date'] ?>" />
                    </div>
                </div>
                <div class="flex-none mt-4 text-end">
                    <input type="submit" value="Save" name="save" class="bg-pms-green-light text-white py-1 px-4 rounded-md border border-pms-green hover:scale-105 delay-75" />
                </div>
            </div>
        </div>

        <!-- Total calculation -->
        <div class="bg-yellow-200 flex gap-4 justify-end border-t border-slate-300 mt-2 p-2">
            <div class="text-end">
                <div class="mb-1">
                    <label for="Customer" class="text-sm text-pms-purple mb-1 font-semibold ps-2">Total:</label>
                    <input type="text" name="username" class="text-sm rounded-md py-1 ps-2 w-1/2" placeholder="Name" />
                </div>
                <div class="mb-1">
                    <label for="Customer" class="text-sm text-pms-purple mb-1 font-semibold ps-2">Discount:</label>
                    <input type="text" name="username" class="text-sm rounded-md py-1 ps-2 w-1/2" placeholder="Name" />
                </div>
                <div>
                    <label for="Customer" class="text-sm text-pms-purple mb-1 font-semibold ps-2">Net Total:</label>
                    <input type="text" name="username" class="text-sm rounded-md py-1 ps-2 w-1/2" placeholder="Name" />
                </div>
            </div>

            <div class="text-end">
                <div class="mb-1">
                    <label for="Customer" class="text-sm text-pms-purple mb-1 font-semibold ps-2">Payment type:</label>
                    <select name="method" id="" class="text-sm rounded-md py-1 ps-2">
                        <option value="cash">Cash</option>
                        <option value="card">Card</option>
                        <option value="mobile">Mobile Banking</option>
                    </select>
                    <!-- <input type="text" name="username" class="text-sm rounded-md py-1 ps-2" placeholder="Name" /> -->
                </div>
                <div class="mb-1">
                    <label for="Customer" class="text-sm text-pms-purple mb-1 font-semibold ps-2">Paid:</label>
                    <input type="text" name="username" class="text-sm rounded-md py-1 ps-2 w-1/2" placeholder="Name" />
                </div>
                <div>
                    <label for="Customer" class="text-sm text-pms-purple mb-1 font-semibold ps-2 3">Change:</label>
                    <input type="text" name="username" class="text-sm rounded-md py-1 ps-2 w-1/2" placeholder="Name" />
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="bg-yellow-200 flex-none h-12 w-full"></div>
</form>


</div>
</div>

<?php

if(isset($_POST['c_name']))
{
    $sql = 'select * from customer where name ="'.$_post['c_name'].'" limit 1';

    include_once "../connection.php";
    $result = $conn->query($sql);
    $c_default = $result->fetch_assoc();
    print_r($c_default);
}

?>