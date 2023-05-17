<?php
// // Get the database connection
// include '../../connection.php';


// // Prepare the INSERT statement
// $query = "INSERT INTO purchases (s_id, invoice_number, purchase_date, total) VALUES (?, ?, ?, ?)";
// $stmt = $conn->prepare($query);

// // Set the parameter values
// $s_id = $_POST["s_id"];
// $invoice_number = $_POST["invoice_number"];
// $date = $_POST["purchase_date"];
// $purchase_date = date('Y-m-d', strtotime($date));;
// $total = $_POST["total"];

// // Bind the parameters
// $stmt->bind_param("iisd", $s_id, $invoice_number, $purchase_date, $total);


// // Execute the prepared statement
// if ($stmt->execute()) {
//     // Redirect back to the purchase list with a success message
//     echo 1;
// } else {
//     // Redirect back to the purchase form with an error message
//     echo 0;
// }
?>
<?php
// Get the database connection
include '../../connection.php';

$medNames = array(); // initialize an empty array to store the med_names
$expDates = array(); // initialize an empty array to store the med_names
$qtys = array(); // initialize an empty array to store the med_names
$rates = array(); // initialize an empty array to store the med_names
$mrps = array(); // initialize an empty array to store the med_names

if (isset($_POST['medicines']) && is_array($_POST['medicines'])) {
    foreach ($_POST['medicines'] as $medicine) {
        $medNames[] = $medicine['medName']; // add the med_name to the array
        $expDates[] = $medicine['expDate']; // add the exp_date to the array
        $qtys[] = $medicine['qty']; // add the med_qty to the array
        $rates[] = $medicine['rate']; // add the med_rate to the array
        $mrps[] = $medicine['mrp']; // add the med_mrp to the array
}
}

// Now the $medNames array contains all the med_names sent in the AJAX request


// Retrieve the data from the form
// $medNames = $_POST['med_name'];
// $expDates = $_POST['exp_date'];
// $qtys = $_POST['med_qty'];
// $rates = $_POST['med_rate'];
// $mrps = $_POST['med_mrp'];

// Validate the data

// Prepare the INSERT statement
$query = "INSERT INTO medicine_stock (med_name, exp_date, qty, rate, mrp) VALUES (?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE exp_date=VALUES(exp_date), rate=VALUES(rate), mrp=VALUES(mrp), qty=qty+VALUES(qty)";
$stmt = $conn->prepare($query);

// Loop through the data and execute the INSERT statement for each row
for ($i = 0; $i < count($medNames); $i++) {
    $medName = $medNames[$i];
    $expDate = $expDates[$i];
    $qty = $qtys[$i];
    $rate = $rates[$i];
    $mrp = $mrps[$i];

    // Bind the parameters
    $stmt->bind_Param(1, $medName);
    $stmt->bind_Param(2, $expDate);
    $stmt->bind_Param(3, $qty);
    $stmt->bind_Param(4, $rate);
    $stmt->bind_Param(5, $mrp);

    // Execute the statement
    // $stmt->execute();
    print_r($stmt);
    return 0;
}


// Set the parameter values for the purchases table
$s_id = $_POST["s_id"];
$invoice_number = $_POST["invoice_number"];
$date = $_POST["purchase_date"];
$purchase_date = date('Y-m-d', strtotime($date));;
$total = $_POST["total"];

// Prepare the INSERT statement for the purchases table
$query = "INSERT INTO purchases (s_id, invoice_number, purchase_date, total) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($query);

// Bind the parameters for the purchases table
$stmt->bind_param("iisd", $s_id, $invoice_number, $purchase_date, $total);

// Execute the prepared statement for the purchases table
if ($stmt->execute()) {
    // Send a success response to the client-side
    $response = array('status' => 'success', 'message' => 'Data saved successfully.');
    echo json_encode($response);
} else {
    // Send an error response to the client-side
    $response = array('status' => 'error', 'message' => 'Unable to save data.');
    echo json_encode($response);
}
?>




