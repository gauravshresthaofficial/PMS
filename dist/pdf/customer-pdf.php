<?php
require_once 'dompdf/autoload.inc.php';
// Reference the Dompdf namespace
use Dompdf\Dompdf;

date_default_timezone_set('Asia/Kathmandu');

// Get today's date and time
$date = date('Y-F-d');
$datetime = date('Ymd_His');

// Retrieve customer data from your database
include '../connection.php';
$result = $conn->query("SELECT * FROM customer WHERE active = TRUE");
$rows = $result->fetch_all(MYSQLI_ASSOC);

// Generate the PDF content
$html = '<!DOCTYPE html>
<html>
<head>
    <title>Customer List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        h2{
            font-size: 24px;
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 8px;
            border: 1px solid #000;
        }
        th {
            font-weight: bold;
            background-color: #f2f2f2;
        }
    </style>
</head>';
 $html .= customerdata($rows);

// Create a new Dompdf instance
$dompdf = new Dompdf();

// Load the HTML content into Dompdf
$dompdf->loadHtml($html);

// Set paper size and orientation
$dompdf->setPaper('A4', 'protrait');

// Render the PDF
$dompdf->render();

// Set the filename with current date and time
$filename = 'customer_list_' . $datetime . '.pdf';

// Output the PDF to the browser with the option to save
$dompdf->stream($filename, ['Attachment' => true]);


exit;


function customerdata($rows)
{
    global $date;
    $data = '';
    $data .= '<body>
    <h2>Pharmacy Management System</h2>
    <h2>Customer List</h2>
    <p>Date: ' . $date . '</p>
    <table>
        <thead>
            <tr>
                <th>S.N.</th>
                <th>Name</th>
                <th>Number</th>
                <th>Address</th>
            </tr>
        </thead>
        <tbody>';
    $serialNumber = 1;
    foreach ($rows as $row) {
        $data .= '<tr>
                <td>' . $serialNumber . '</td>
                <td>' . $row['c_name'] . '</td>
                <td>' . $row['c_number'] . '</td>
                <td>' . $row['c_address'] . '</td>
            </tr>';
        $serialNumber++;
    }
    $data .= '</tbody>
    </table>
</body>
</html>';
    return $data;
}

?>
