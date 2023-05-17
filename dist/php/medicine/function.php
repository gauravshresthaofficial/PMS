<?php
include "../../connection.php";

if (isset($_POST['action']) && $_POST['action'] == "table") {
    // Check if current page is set, else set it to 1
    if (!isset($_POST['page'])) {
        $page = 1;
    } else {
        $page = $_POST['page'];
    }
    showMedicines($page);
}

if (isset($_POST['action']) && $_POST['action'] == "stock") {
    // Check if current page is set, else set it to 1
    if (!isset($_POST['page'])) {
        $page = 1;
    } else {
        $page = $_POST['page'];
    }
    showMedicineStock($page);
}

if (isset($_POST['action']) && $_POST['action'] == "s_name_option") {
    $searchValue = $_POST['search'];
    name($searchValue);
}


//Delete the medicine from database
if (isset($_POST['action']) && $_POST['action'] == "delete") {
    global $conn;
    $id = $_POST['id'];

    $sql = "Delete from medicine where med_id = $id";
    $result = $conn->query($sql) or die("Sql query failed");
    $conn->close();

    if ($result) {
        echo 1;
    } else {
        echo 0;
    }
}

// if (isset($_POST['action']) && $_POST['action'] == "update") {
//     global $conn;
//     // Set the parameters
//     $med_id = $_POST['med_id'];
//     $med_name = $_POST['med_name'];
//     $med_pack = $_POST['med_pack'];
//     $generic_name = $_POST['generic_name'];
//     if ($_POST['new_supplier'] == 1) {
//         $s_name = $_POST['s_name'];
//         $s_email = $_POST['s_email'];
//         $s_address = $_POST['s_address'];
//         $s_number = $_POST['s_number'];

//         // Add new supplier
//         $check = addSupplier($conn, $s_name, $s_email, $s_number, $s_address);

//         if ($check == 3) {
//             echo 3;
//             return;
//         } else if ($check == 0) {
//             echo 0;
//             return;
//         }

//         // Get the supplier id
//         $s_id = $conn->insert_id;
//     } else {
//         $s_id = $_POST['s_id'];
//     }


//     // Prepare the update statement
//     $stmt = $conn->prepare("UPDATE medicine SET med_name=?, med_pack=?, generic_name=?, s_id=? WHERE med_id=?");

//     // Bind the parameters to the statement
//     $stmt->bind_param("sssii", $med_name, $med_pack, $generic_name, $s_id, $med_id);

//     // Execute the statement
//     if ($stmt->execute()) {
//         echo 1;
//     } else {
//         echo 0;
//     }

//     // Close the statement and the connection
//     $stmt->close();
//     $conn->close();
// }

if (isset($_POST['action']) && $_POST['action'] == "update") {
    if ($_POST['data_for'] == "med") {
        addMedicine();
    } else {
        updateStock();
    }
}

if (isset($_POST['action']) && $_POST['action'] == "add") {
    addMedicine();
}


function name($s_name)
{
    global $conn;

    $sql = 'SELECT * from Suppliers';
    $result = $conn->query($sql);
    $output["list"] = "";
    $output["list"] .= '<ul class="absolute w-[300px] right-0 border border-gray-200 rounded-md bg-white grid grid-cols-1 divide-y" style="max-height: 150px; overflow-y: auto;">';
    $output["show"] = "0";
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            if ($s_name == $row['s_name']) {
                $output["show"] = "1";
            }
            $output["list"] .= '<li class="py-2 ps-2 hover:bg-pms-green-light hover:text-white" data-id=' . $row['s_id'] . '>' . $row['s_name'] . "</li>";
        }
    } else {
        $output["list"] .= '<li class="py-2 ps-2 hover:bg-pms-green-light hover:text-white">0 results.</li>';
    }
    $output["list"] .= "</ul>";

    echo json_encode($output);
    $result->close();
    $conn->close();
}


function addSupplier($conn, $s_name, $s_email, $s_number, $s_address)
{
    // Prepare the insert statement
    $stmt = $conn->prepare("INSERT INTO suppliers (s_name, s_email, s_address, s_number) VALUES (?, ?, ?, ?)");

    // Bind the parameters to the statement
    $stmt->bind_param("ssss", $s_name, $s_email, $s_address, $s_number);

    //Check for Unique name
    $sql = "SELECT s_name FROM suppliers WHERE LOWER(s_name) = LOWER(?)";
    $stmt_check = $conn->prepare($sql);
    $stmt_check->bind_param("s", $s_name);
    $stmt_check->execute();
    $result = $stmt_check->get_result();

    if ($result->num_rows > 0) {
        return 3;
    }

    // Execute the statement
    if ($stmt->execute()) {
        return 1;
    } else {
        return 0;
    }

    // Close the statement
    $stmt->close();
}

function addMedicine()
{
    global $conn;
    // Set the parameters
    $med_name = $_POST['med_name'];
    $med_pack = $_POST['med_pack'];
    $generic_name = $_POST['generic_name'];
    $s_name = $_POST['s_name'];
    if ($_POST['new_supplier'] == 1) {
        $s_email = $_POST['s_email'];
        $s_address = $_POST['s_address'];
        $s_number = $_POST['s_number'];

        // Add new supplier
        $check = addSupplier($conn, $s_name, $s_email, $s_number, $s_address);

        if ($check == 3) {
            echo 3;
            return;
        } else if ($check == 0) {
            echo 0;
            return;
        }

        // Get the supplier id
        $s_id = $conn->insert_id;
    } else {
        $s_id = $_POST['s_id'];
    }


    if ($_POST['action'] == "update") {
        $med_id = $_POST['med_id'];
        // Prepare the update statement
        $stmt = $conn->prepare("UPDATE medicine SET med_name=?, med_pack=?, generic_name=?, s_name=? WHERE med_id=?");

        // Bind the parameters to the statement
        $stmt->bind_param("ssssi", $med_name, $med_pack, $generic_name, $s_name, $med_id);
    } else {

        // Prepare the insert statement
        $stmt = $conn->prepare("INSERT INTO medicine (med_name, med_pack, generic_name, s_name) VALUES (?, ?, ?, ?)");

        // Bind the parameters to the statement
        $stmt->bind_param("ssss", $med_name, $med_pack, $generic_name, $s_name);


        //Check for Unique name
        $sql = "SELECT med_name FROM medicine WHERE LOWER(med_name) = LOWER(?)";
        $stmt_check = $conn->prepare($sql);
        $stmt_check->bind_param("s", $med_name);
        $stmt_check->execute();
        $result = $stmt_check->get_result();

        if ($result->num_rows > 0) {
            echo 2;
            return;
        }
    }
    // Execute the statement
    if ($stmt->execute()) {
        echo 1;
    } else {
        echo 0;
    }

    // Close the statement and the connection
    $stmt->close();
    $conn->close();
}

function updateStock()
{
    global $conn;
    $stock_id = $_POST['stock_id'];
    $date = $_POST['exp_date'];
    $exp_date = date('Y-m-d', strtotime($date));
    $qty = $_POST['qty'];
    $mrp = $_POST['mrp'];
    $rate = $_POST['rate'];
    
   // Prepare the SQL query
   $stmt = $conn->prepare("UPDATE medicine_stock SET exp_date = ?, qty = ?, mrp = ?, rate = ? WHERE medicine_stock.stock_id = ?");
    
   // Bind the parameters to values
   $stmt->bind_param('siddi', $exp_date, $qty, $mrp, $rate, $stock_id);


    
    // Execute the prepared statement
    if ($stmt->execute()) {
        echo 1;
    } else {
        echo 0;
    }
    
    
}



function showMedicines($page)
{
    global $conn;
    $output = "";
    $output = '<table class="w-full px-2 m-auto mt-4">
                    <thead class="border border-r-0 border-l-0 border-gray-600">
                        <tr>
                            <th class="py-2 pb-1 text-start px-2 text-gray-800 font-semibold text-md">S.N.</th>
                            <th class="py-2 pb-1 text-start px-2 text-gray-800 font-semibold text-md">Medicine Name</th>
                            <th class="py-2 pb-1 text-start px-2 text-gray-800 font-semibold text-md">Packing</th>
                            <th class="py-2 pb-1 text-start px-2 text-gray-800 font-semibold text-md">Generic Name</th>
                            <th class="py-2 pb-1 text-start px-2 text-gray-800 font-semibold text-md">Supplier</th>
                            <th class="py-2 pb-1 text-center px-2 text-gray-800 font-semibold text-md ">Actions</th>
                        </tr>
                    </thead>
                    <tbody>';


    // Pagination variables
    $results_per_page = 4;
    $sql = "SELECT * FROM medicine";
    $result = $conn->query($sql);
    $number_of_results = mysqli_num_rows($result);
    $total_pages = ceil($number_of_results / $results_per_page);



    // Calculate the starting limit number for the results on the displaying page
    $starting_limit_number = ($page - 1) * $results_per_page;

    // Retrieve the results for the displaying page
    $sql = "SELECT * FROM medicine LIMIT $starting_limit_number, $results_per_page";
    $result = $conn->query($sql);

    $i = 0;
    if ($result->num_rows > 0) {
        $sn = $starting_limit_number;
        while ($row = $result->fetch_assoc()) {
            $sn++;
            if ($i % 2 == 0) {
                $bg = "bg-gray-100";
            } else {
                $bg = "bg-white";
            }
            $output .= '
        <tr class="' . $bg . '">
        <td class="py-2 px-2 ps-4 text-md text-gray-600">' . $sn . '</td>
        <td class="py-2 px-2 ps-4 text-md text-gray-600">' . $row["med_name"] . '</td>
        <td class="py-2 px-2 ps-4 text-md text-gray-600">' . $row["med_pack"] . '</td>
        <td class="py-2 px-2 ps-4 text-md text-gray-600">' . $row["generic_name"] . '</td>
        <td class="py-2 px-2 ps-4 text-md text-gray-600">' . $row["s_name"] . '</td>
        <td class="text-center py-2 px-2 ps-4 text-md text-gray-600" >
        <button data-for="med"  class="px-4 py-1 bg-white border border-1 border-black rounded-md me-2 hover:scale-105 edit-btn" data-id="' . $row["med_id"] . '">Edit</button>
        <button class="px-4 py-1 text-white border border-1 border-gray-700 rounded-md hover:scale-105 bg-pms-error delete-btn" data-id="' . $row["med_id"] . '">Delete</button>
        </td>
    </tr>';
            $i++;
        }

        $output .= '</tbody>
            </table>';

        // Display pagination buttons
        if ($total_pages > 1) {
            $output .= '<div class="absolute bottom-2 right-0">';
            $output .= '<ul class="flex justify-center">';
            for ($j = 1; $j <= $total_pages; $j++) {
                if ($j == $page) {
                    $output .= '<li class="mx-2"><button data-for="med" class="pagination px-2 py-1 bg-pms-green-light text-white rounded-md" data-page="' . $j . '" >' . $j . '</button></li>';
                } else {
                    $output .= '<li class="mx-2"><button data-for="med" class="pagination px-2 py-1 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-400 transition duration-300" data-page="' . $j . '" >' . $j . '</button></li>';
                }
            }
            $output .= '</ul>';
            $output .= '</div>';
        }
    }
    echo $output;
}


function showMedicineStock($page)
{
    global $conn;
    $output = "";
    $output = '<table class="w-full px-2 m-auto mt-4">
                    <thead class="border border-r-0 border-l-0 border-gray-600">
                        <tr>
                            <th class="py-2 pb-1 text-start px-2 text-gray-800 font-semibold text-md">S.N.</th>
                            <th class="py-2 pb-1 text-start px-2 text-gray-800 font-semibold text-md">Medicine Name</th>
                            <th class="py-2 pb-1 text-start px-2 text-gray-800 font-semibold text-md">Packing</th>
                            <th class="py-2 pb-1 text-start px-2 text-gray-800 font-semibold text-md">Generic Name</th>
                            <th class="py-2 pb-1 text-start px-2 text-gray-800 font-semibold text-md">Supplier</th>
                            <th class="py-2 pb-1 text-start px-2 text-gray-800 font-semibold text-md">Expiry Date</th>
                            <th class="py-2 pb-1 text-start px-2 text-gray-800 font-semibold text-md">Qty</th>
                            <th class="py-2 pb-1 text-start px-2 text-gray-800 font-semibold text-md">MRP</th>
                            <th class="py-2 pb-1 text-start px-2 text-gray-800 font-semibold text-md">Rate</th>
                            <th class="py-2 pb-1 text-center px-2 text-gray-800 font-semibold text-md ">Actions</th>
                        </tr>
                    </thead>
                    <tbody>';


    // Pagination variables
    $results_per_page = 4;
    $sql = "SELECT * FROM medicine_stock";
    $result = $conn->query($sql);
    $number_of_results = mysqli_num_rows($result);
    $total_pages = ceil($number_of_results / $results_per_page);



    // Calculate the starting limit number for the results on the displaying page
    $starting_limit_number = ($page - 1) * $results_per_page;

    // Retrieve the results for the displaying page
    $sql = "SELECT * FROM medicine_stock LEFT JOIN medicine ON medicine.med_name = medicine_stock.med_name LIMIT $starting_limit_number, $results_per_page";
    $result = $conn->query($sql);

    $i = 0;
    if ($result->num_rows > 0) {
        $sn = $starting_limit_number;
        while ($row = $result->fetch_assoc()) {
            if ($i % 2 == 0) {
                $bg = "bg-gray-100";
            } else {
                $bg = "bg-white";
            }
            $output .= '
        <tr class="' . $bg . '">
        <td class="py-2 px-2 ps-4 text-md text-gray-600">' . $i + 1 . '</td>
        <td class="py-2 px-2 ps-4 text-md text-gray-600">' . $row["med_name"] . '</td>
        <td class="py-2 px-2 ps-4 text-md text-gray-600">' . $row["med_pack"] . '</td>
        <td class="py-2 px-2 ps-4 text-md text-gray-600">' . $row["generic_name"] . '</td>
        <td class="py-2 px-2 ps-4 text-md text-gray-600">' . $row["s_name"] . '</td>
        <td class="py-2 px-2 ps-4 text-md text-gray-600">' . $row["exp_date"] . '</td>
        <td class="py-2 px-2 ps-4 text-md text-gray-600">' . $row["qty"] . '</td>
        <td class="py-2 px-2 ps-4 text-md text-gray-600">' . $row["mrp"] . '</td>
        <td class="py-2 px-2 ps-4 text-md text-gray-600">' . $row["rate"] . '</td>
        <td class="text-center py-2 px-2 ps-4 text-md text-gray-600" >
        <button data-for="med_stock" class="px-4 py-1 bg-white border border-1 border-black rounded-md me-2 hover:scale-105 edit-btn" data-id="' . $row["stock_id"] . '">Edit</button>
        </td>
    </tr>';
            $i++;
        }

        $output .= '</tbody>
            </table>';

        // Display pagination buttons
        if ($total_pages > 1) {
            $output .= '<div class="absolute bottom-2 right-0">';
            $output .= '<ul class="flex justify-center">';
            for ($j = 1; $j <= $total_pages; $j++) {
                if ($j == $page) {
                    $output .= '<li class="mx-2"><button data-for="med_stock" class="pagination px-2 py-1 bg-pms-green-light text-white rounded-md" data-page="' . $j . '" >' . $j . '</button></li>';
                } else {
                    $output .= '<li class="mx-2"><button data-for="med_stock" class="pagination px-2 py-1 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-400 transition duration-300" data-page="' . $j . '" >' . $j . '</button></li>';
                }
            }
            $output .= '</ul>';
            $output .= '</div>';
        }
    }
    echo $output;
}
