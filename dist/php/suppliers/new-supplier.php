<?php
include "../../connection.php";
// check for edit / ADD
$edit = $_POST['act'];

$default = array();
$operation = "Add";

//SET DEFAULT VALUE
if ($edit == "edit") {
    if (isset($_POST['s_id'])) {
        $operation = "Edit";
        $s_id = $_POST['s_id'];

        // Prepare SQL statement
        $stmt = $conn->prepare("SELECT * FROM Suppliers WHERE s_id = ? LIMIT 1");
        $stmt->bind_param("i", $s_id);

        // Execute statement
        $stmt->execute();

        // Get result
        $result = $stmt->get_result();

        // Check if any rows were returned
        if ($result->num_rows > 0) {
            // Output data of each row
            $row = $result->fetch_assoc();
            $default['s_id'] = $s_id;
            $default['s_name'] = $row['s_name'];
            $default['s_email'] = $row['s_email'];
            $default['s_number'] = $row['s_number'];
            $default['s_address'] = $row['s_address'];
        } else {
            return;
        }
    }
}



?>


<div class="p-4">
    <!-- Add or edit heading -->
    <div class="text-lg ps-2 font-bold border border-t-0 border-l-0 border-r-0 pb-2 border-gray-200">
        <?php
        echo $operation;
        ?> Suppliers Details</div>

    <!-- Form -->
    <div class="w-fit pt-4 flex flex-col gap-4">
        <input type="hidden" name="s_id" id="s_id" <?php
                                                    if ($edit == "edit") {
                                                        echo "value = $default[s_id]";
                                                    }
                                                    ?>>
        <div class="">
            <div class=" w-[200px] inline-block text-[#1E1E1E] font-semibold ps-2">Suppliers Name:
            </div>
            <input type="text" name="s_name" id="s_name" class="w-[300px] rounded-md py-1 ps-2 border " <?php
                                                                                                        if ($edit == "edit") {
                                                                                                            echo 'value = "' . $default['s_name'] . '"';
                                                                                                        } else {
                                                                                                            echo  'placeholder="Suppliers Name"';
                                                                                                        }
                                                                                                        ?>>
        </div>
        <div class="">
            <div class=" w-[200px] inline-block text-[#1E1E1E] font-semibold ps-2">Suppliers Email:
            </div>
            <input type="text" name="s_email" id="s_email" class="w-[300px] rounded-md py-1 ps-2 border " <?php
                                                                                                        if ($edit == "edit") {
                                                                                                            echo 'value = "' . $default['s_email'] . '"';
                                                                                                        } else {
                                                                                                            echo  'placeholder="Suppliers Email"';
                                                                                                        }
                                                                                                        ?>>
        </div>
        
        <div class="">
            <div class="w-[200px] inline-block text-[#1E1E1E] font-semibold ps-2">Suppliers Number:</div>
            <input type="text" name="s_number" id="s_number" class="w-[300px] rounded-md py-1 ps-2 border" <?php
                                                                                                            if ($edit == "edit") {
                                                                                                                echo 'value = "' . $default['s_number'] . '"';
                                                                                                            } else {
                                                                                                                echo  'placeholder="Suppliers Number"';
                                                                                                            }
                                                                                                            ?>>
        </div>
        <div class="">
            <div class="w-[200px] inline-block text-[#1E1E1E] font-semibold ps-2">Suppliers Address:</div>
            <input type="text" name="s_address" id="s_address" class="w-[300px] rounded-md py-1 ps-2 border " <?php
                                                                                                                if ($edit == "edit") {
                                                                                                                    echo 'value = "' . $default['s_address'] . '"';
                                                                                                                } else {
                                                                                                                    echo  'placeholder="Suppliers Address"';
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

                                    ?> class="bg-[#2DD4BF] text-white py-1 px-6 rounded-md border border-[#01A768] hover:scale-105 delay-75">
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