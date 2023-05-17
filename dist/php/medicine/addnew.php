<?php
include "../../connection.php";
// check for edit / ADD
$edit = $_POST['action'];

$default = array();
$default["value"] = "0";
if (isset($_POST['addition'])) {
    $default["value"] = "value";
    $default['med_name'] = $_POST['med_name'];
    $default['med_pack'] = $_POST['med_pack'];
    $default['generic_name'] = $_POST['generic_name'];
    $default['s_name'] = $_POST['s_name'];
}

$operation = "Add";

//SET DEFAULT "VALUE"
if ($edit == "edit") {
    if (isset($_POST['id'])) {
        $operation = "Edit";
        $id = $_POST['id'];

        if (isset($_POST['data_for']) && $_POST['data_for'] == "med") {
            $stmt = $conn->prepare("SELECT * FROM medicine LEFT JOIN suppliers ON medicine.s_name = suppliers.s_name WHERE med_id = ? LIMIT 1");
        } else if (isset($_POST['data_for']) && $_POST['data_for'] == "med_stock") {
            $stmt = $conn->prepare("SELECT * 
            FROM medicine_stock 
            LEFT JOIN medicine ON medicine.med_name = medicine_stock.med_name 
            LEFT JOIN suppliers ON medicine.s_name = suppliers.s_name 
            WHERE stock_id = ? 
            LIMIT 1");
        }

        // Prepare SQL statement
        $stmt->bind_param("i", $id);

        // Execute statement
        $stmt->execute();

        // Get result
        $result = $stmt->get_result();

        // Check if any rows were returned
        if ($result->num_rows > 0) {
            // Output data of each row
            $row = $result->fetch_assoc();
            $default["value"] = "value";
            $default['med_id'] = $id;
            $default['med_name'] = $row['med_name'];
            $default['med_pack'] = $row['med_pack'];
            $default['generic_name'] = $row['generic_name'];
            $default['s_name'] = $row['s_name'];
            $default['s_id'] = $row['s_id'];

            if ($_POST['data_for'] == "med_stock") {
                $default['stock_id'] = $id;
                $default['qty'] = $row['qty'];
                $default['exp_date'] = $row['exp_date'];
                $default['mrp'] = $row['mrp'];
                $default['rate'] = $row['rate'];
            }
        } else {
            return;
        }
    }
}



?>


<div class="">
    <!-- Add or edit heading -->
    <button id="close-modal" class="bg-pink-500 hover:bg-pink-700 text-white font-bold w-10 h-10 rounded-full float-right">X</button>
    <div class="text-lg ps-2 p-4 font-bold border border-t-0 border-l-0 border-r-0 pb-2 border-gray-200">
        <?php
        echo $operation;
        ?> Medicine Details</div>

    <!-- Form -->
    <div class="w-fit pt-4 flex flex-col gap-4">
        <input type="hidden" name="med_id" id="med_id" <?php
                                                        if ($edit == "edit") {
                                                            echo "value = $default[med_id]";
                                                        }
                                                        ?>>
        <div class="">
            <div class=" w-[200px] inline-block text-pms-dark font-semibold ps-2">Medicine Name:
            </div>
            <input type="text" name="med_name" id="med_name" class="w-[300px] rounded-md py-1 ps-2 border " <?php
                                                                                                            if ($default['value'] == "value" && $default['med_name'] != "") {
                                                                                                                echo 'value = "' . $default['med_name'] . '"';
                                                                                                            } else {
                                                                                                                echo  'placeholder="Medicine Name"';
                                                                                                            }
                                                                                                            ?>>
        </div>
        <div class="">
            <div class=" w-[200px] inline-block text-pms-dark font-semibold ps-2">Packing:
            </div>
            <input type="text" name="med_pack" id="med_pack" class="w-[300px] rounded-md py-1 ps-2 border " <?php
                                                                                                            if ($default['value'] == "value" && $default['med_pack'] != "") {
                                                                                                                echo 'value = "' . $default['med_pack'] . '"';
                                                                                                            } else {
                                                                                                                echo  'placeholder="for e.g 1 x 10"';
                                                                                                            }
                                                                                                            ?>>
        </div>

        <div class="">
            <div class="w-[200px] inline-block text-pms-dark font-semibold ps-2">Generic Name:</div>
            <input type="text" name="generic_name" id="generic_name" class="w-[300px] rounded-md py-1 ps-2 border" <?php
                                                                                                                    if ($default['value'] == "value" && $default['generic_name']  != "") {
                                                                                                                        echo 'value = "' . $default['generic_name'] . '"';
                                                                                                                    } else {
                                                                                                                        echo  'placeholder="Generic Number"';
                                                                                                                    }
                                                                                                                    ?>>
        </div>
        <?php
        if (isset($_POST['addition']) && $_POST['addition'] == "supplier-details") {
            echo '</div><div class="text-lg ps-2 mt-4 font-bold border border-t-0 border-l-0 border-r-0 pb-2 border-gray-200">';
            echo $operation;
            echo ' Suppliers Details</div>
        <div class="w-fit pt-4 flex flex-col gap-4">';
        }
        ?>
        <div class="relative">
            <div class="w-[200px] inline-block text-pms-dark font-semibold ps-2">Supplier Name:</div>
            <input type="text" name="s_name" id="s_name" class="w-[300px] rounded-md py-1 ps-2 border " <?php
                                                                                                        if ($default['value'] == "value" && $default['s_name'] != "") {
                                                                                                            echo 'value = "' . $default['s_name'] . '"';
                                                                                                        } else {
                                                                                                            echo  'placeholder="Supplier Name"';
                                                                                                        }
                                                                                                        ?>>
            <div id="s-name-results" class="relative z-50"></div>
            <input type="hidden" name="s_id" id="s_id" class="w-[300px] rounded-md py-1 ps-2 border " <?php
                                                                                                        if ($edit == "edit") {
                                                                                                            echo 'value = "' . $default['s_id'] . '"';
                                                                                                        }
                                                                                                        ?>>
            <div id="s-name-results" class="relative z-50"></div>
            <button type="submit" id="add-supplier" data-details="0" class="hidden absolute translate-x-[120%] top-0 right-4 bg-pms-green-light text-white py-1 px-6 rounded-md border border-pms-green hover:scale-105 delay-75">Add Supplier</button>
        </div>

        <?php
        if (isset($_POST['addition']) && $_POST['addition'] == "supplier-details") {
            echo '
            <div class="">
            <div class=" w-[200px] inline-block text-pms-dark font-semibold ps-2">Suppliers Email:</div>
            <input type="text" name="s_email" id="s_email" class="w-[300px] rounded-md py-1 ps-2 border " placeholder="Suppliers Email">
            </div>
        
            <div class="">
            <div class="w-[200px] inline-block text-pms-dark font-semibold ps-2">Suppliers Number:</div>
            <input type="text" name="s_number" id="s_number" class="w-[300px] rounded-md py-1 ps-2 border" placeholder="Suppliers Number">
            </div>
            <div class="">
            <div class="w-[200px] inline-block text-pms-dark font-semibold ps-2">Suppliers Address:</div>
            <input type="text" name="s_address" id="s_address" class="w-[300px] rounded-md py-1 ps-2 border " placeholder="Suppliers Address">
            </div>';
        }

        if ($_POST['data_for'] == "med_stock") {
            
            echo '<div class="hidden">';
            echo '<input type="text" name="stock_id" id="stock_id" class="w-[300px] rounded-md py-1 ps-2 border hidden" value = "' . $default['stock_id'] . '"' . '>
            </div>';
            echo '<div class="">';
            echo '<div class=" w-[200px] inline-block text-pms-dark font-semibold ps-2">Expiry Date:</div>
            <input type="date" name="exp_date" id="exp_date" class="w-[300px] rounded-md py-1 ps-2 border" value = "' . $default['exp_date'] . '"' . '>
            </div>';
            echo '<div class="">
            <div class=" w-[200px] inline-block text-pms-dark font-semibold ps-2">Qty:
            </div>
            <input type="text" name="qty" id="qty" class="w-[300px] rounded-md py-1 ps-2 border" value = "' . $default['qty'] . '"' . '>
            </div>';
            echo '<div class="">
            <div class=" w-[200px] inline-block text-pms-dark font-semibold ps-2">MRP:
            </div>
            <input type="text" name="mrp" id="mrp" class="w-[300px] rounded-md py-1 ps-2 border" value = "' . $default['mrp'] . '"' . '>
            </div>';
            echo '<div class="">
            <div class=" w-[200px] inline-block text-pms-dark font-semibold ps-2">Rate:
            </div>
            <input type="text" name="rate" id="rate" class="w-[300px] rounded-md py-1 ps-2 border" value = "' . $default['rate'] . '"' . '>
            </div>';
        }
        ?>

        <div class="mt-2 text-end">
            <button type="submit" <?php
                                    if ($edit == "edit") {
                                        echo 'id="update-btn"';

                                        if ($_POST['data_for'] == "med") {
                                            echo ' data-for = "med" ';
                                        } else {
                                            echo ' data-for = "med_stock" ';
                                        }
                                    } else {
                                        echo 'id="add-btn"';
                                    }

                                    ?> class="toggle-btn bg-pms-green-light text-white py-1 px-6 rounded-md border border-pms-green hover:scale-105 delay-75">
                <?php
                if ($edit == "edit") {
                    echo "Update";
                } else {
                    echo "Add";
                }

                ?>
            </button>
        </div>

        <?php
        if (isset($_POST['addition']) && $_POST['addition'] == "supplier-details") {
            echo '</div>';
        }
        ?>
    </div>
</div>