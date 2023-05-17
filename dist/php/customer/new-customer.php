<?php
include "../../connection.php";
// check for edit / ADD
$edit = $_POST['act'];

$default = array();
$operation = "Add";

//SET DEFAULT VALUE
if ($edit == "edit") {
    if (isset($_POST['c_id'])) {
        $operation = "Edit";
        $c_id = $_POST['c_id'];

        // Prepare SQL statement
        $stmt = $conn->prepare("SELECT * FROM customer WHERE c_id = ? LIMIT 1");
        $stmt->bind_param("i", $c_id);

        // Execute statement
        $stmt->execute();

        // Get result
        $result = $stmt->get_result();

        // Check if any rows were returned
        if ($result->num_rows > 0) {
            // Output data of each row
            $row = $result->fetch_assoc();
            $default['c_id'] = $c_id;
            $default['c_name'] = $row['c_name'];
            $default['c_address'] = $row['c_address'];
            $default['c_number'] = $row['c_number'];
            $default['c_email'] = $row['c_email'];
        } else {
            return ;
        }
    }
}



?>


<div class="p-4">
    <!-- Add or edit heading -->
    <div class="text-lg ps-2 font-bold border border-t-0 border-l-0 border-r-0 pb-2 border-gray-200">
        <?php
        echo $operation;
        ?> Customer Details</div>

    <!-- Form -->
    <div class="w-fit pt-4 flex flex-col gap-4">
        <input type="hidden" name="c_id" id="c_id" <?php
                                                    if ($edit == "edit") {
                                                        echo "value = $default[c_id]";
                                                    }
                                                    ?>>
        <div class="">
            <div class=" w-[100px] inline-block text-[#1E1E1E] font-semibold ps-2">Name:
            </div>
            <input type="text" name="c_name" id="c_name" class="w-[300px] rounded-md py-1 ps-2 border " <?php
                                                                                                        if ($edit == "edit") {
                                                                                                            echo 'value = "'.$default['c_name'].'"';
                                                                                                        } else {
                                                                                                            echo  'placeholder="Customer Name"';
                                                                                                        }
                                                                                                        ?>>
        </div>
        <div class="">
            <div class="w-[100px] inline-block text-[#1E1E1E] font-semibold ps-2">Email:</div>
            <input type="text" name="c_email" id="c_email" class="w-[300px] rounded-md py-1 ps-2 border" <?php
                                                                                                            if ($edit == "edit") {
                                                                                                                echo 'value = "'.$default['c_email'].'"';
                                                                                                            } else {
                                                                                                                echo  'placeholder="Customer Email"';
                                                                                                            }
                                                                                                            ?>>
        </div>
        <div class="">
            <div class="w-[100px] inline-block text-[#1E1E1E] font-semibold ps-2">Number:</div>
            <input type="text" name="c_number" id="c_number" class="w-[300px] rounded-md py-1 ps-2 border" <?php
                                                                                                            if ($edit == "edit") {
                                                                                                                echo 'value = "'.$default['c_number'].'"';
                                                                                                            } else {
                                                                                                                echo  'placeholder="Customer Number"';
                                                                                                            }
                                                                                                            ?>>
        </div>
        <div class="">
            <div class="w-[100px] inline-block text-[#1E1E1E] font-semibold ps-2">Address:</div>
            <input type="text" name="c_address" id="c_address" class="w-[300px] rounded-md py-1 ps-2 border " <?php
                                                                                                                if ($edit == "edit") {
                                                                                                                    echo 'value = "'.$default['c_address'].'"';
                                                                                                                } else {
                                                                                                                    echo  'placeholder="Customer Address"';
                                                                                                                }
                                                                                                                ?>>
        </div>
        



        <div class="mt-2 text-end">
            <button type="submit" <?php
                                    if ($edit == "edit") {

                                        echo 'id="update-btn"';
                                    } else {
                                        echo 'id="add-btn"';
                                    }

                                    ?> class="bg-[#2DD4BF] text-white py-1 px-6 rounded-md border border-[01A768] hover:scale-105 delay-75">
                <?php
                if ($edit == "edit") {
                    echo "Update";
                } else {
                    echo "Add";
                }

                ?>
            </button>
        </div>
    </div>
</div>