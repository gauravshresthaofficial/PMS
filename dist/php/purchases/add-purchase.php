<?php
// Get the database connection
include '../../connection.php';

$medicines = $_POST['medicines'];

$medNames = array();
$expDates = array();
$qtys = array();
$rates = array();
$mrps = array();
$medTotals = array();

if (!empty($medicines) && is_array($medicines)) {
    foreach ($medicines as $medicine) {
        $medNames[] = $medicine['medName'];
        $expDates[] = $medicine['medExp'];
        $qtys[] = $medicine['medQty'];
        $rates[] = $medicine['medRate'];
        $mrps[] = $medicine['medMrp'];
        $medTotals[] = $medicine['medTotal'];
    }
}

// Check if all the medicines exist
$medicineExists = true;
$query = "SELECT med_name FROM medicine_stock WHERE med_name IN ('" . implode("','", $medNames) . "')";
$result = $conn->query($query);
$existingMedicines = array();
while ($row = $result->fetch_assoc()) {
    $existingMedicines[] = $row['med_name'];
}
$missingMedicines = array_diff($medNames, $existingMedicines);
if (!empty($missingMedicines)) {
    echo "One or more medicines do not exist.";
} else {
    // Prepare the INSERT statement for the medicine_stock table
    $query = "INSERT INTO medicine_stock (med_name, exp_date, qty, rate, mrp) VALUES (?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE exp_date=VALUES(exp_date), rate=VALUES(rate), mrp=VALUES(mrp), qty=qty+VALUES(qty)";
    $stmt = $conn->prepare($query);

    // Loop through the data and execute the INSERT statement for each row
    for ($i = 0; $i < count($medNames); $i++) {
        $medName = $medNames[$i];
        $expDate = $expDates[$i];
        $qty = $qtys[$i];
        $rate = $rates[$i];
        $mrp = $mrps[$i];

        // Bind the parameters for the medicine_stock table
        $stmt->bind_param("ssidd", $medName, $expDate, $qty, $rate, $mrp);

        // Execute the statement
        $stmt->execute();
    }

    // Calculate the total for each supplier
    $supplierTotals = array();
    for ($i = 0; $i < count($medTotals); $i++) {
        $medTotal = $medTotals[$i];
        $medName = $medNames[$i];

        // Retrieve the supplier name from the medicine table
        $query = "SELECT s_name FROM medicine WHERE med_name = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $medName);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $supplier = $row['s_name'];

        if (!isset($supplierTotals[$supplier])) {
            $supplierTotals[$supplier] = 0;
        }
        $supplierTotals[$supplier] += $medTotal;
    }

    // Prepare the INSERT statement for the purchases table
    $query = "INSERT INTO purchases (s_name, medicines_name, purchase_date, total) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($query);

    // Loop through the supplierTotals array and insert data into the purchases table for each supplier
    foreach ($supplierTotals as $supplier => $total) {
        // Get the common medicines for the current supplier
        $commonMedicines = array();
        for ($i = 0; $i < count($medNames); $i++) {
            $medName = $medNames[$i];

            // Check if the medicine belongs to the current supplier
            $query = "SELECT med_name FROM medicine WHERE med_name = ? AND s_name = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ss", $medName, $supplier);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $commonMedicines[] = $medName;
            }
        }

        // Insert data into the purchases table for the current supplier and their common medicines
        if (!empty($commonMedicines)) {
            // Prepare the INSERT statement for the purchases table
            $query = "INSERT INTO purchases (s_name, medicines_name, purchase_date, total) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($query);
            $medicinesString = implode(", ", $commonMedicines);

            // Bind the parameters for the purchases table
            $stmt->bind_param("sssd", $supplier, $medicinesString, $_POST['purchase_date'], $total);

            // Execute the statement
            if(!$stmt->execute()){
                echo 0;
                return;
            }
            
        }
    }


    // Send a success response to the client-side
    echo "1";

    $stmt->close();
}

$conn->close();
