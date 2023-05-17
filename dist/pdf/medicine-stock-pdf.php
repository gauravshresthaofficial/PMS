<?php
require_once 'dompdf/autoload.inc.php';
// Reference the Dompdf namespace
use Dompdf\Dompdf;

date_default_timezone_set('Asia/Kathmandu');

// Get today's date and time
$date = date('Y-F-d');
$datetime = date('Ymd_His');

// Retrieve medicine stock data from your database
include '../connection.php';
$result = $conn->query("SELECT ms.stock_id, ms.exp_date, ms.qty, ms.mrp, ms.rate, m.med_name, m.med_pack, m.generic_name, m.s_name
                        FROM medicine_stock ms
                        LEFT JOIN medicine m ON ms.med_name = m.med_name
                        WHERE m.deleted = FALSE");
$rows = $result->fetch_all(MYSQLI_ASSOC);

// Generate the PDF content
$html = '<!DOCTYPE html>
<html>
<head>
    <title>Medicine Stock List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        h2 {
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
$html .= medicinestockdata($rows);

// Create a new Dompdf instance
$dompdf = new Dompdf();

// Load the HTML content into Dompdf
$dompdf->loadHtml($html);

// Set paper size and orientation
$dompdf->setPaper('A4', 'portrait');

// Render the PDF
$dompdf->render();

// Set the filename with current date and time
$filename = 'medicine_stock_list_' . $datetime . '.pdf';

// Output the PDF to the browser with the option to save
$dompdf->stream($filename, ['Attachment' => true]);

exit;

function medicinestockdata($rows)
{
    global $date;
    $data = '';
    $data .= '<body>
    <h2>Pharmacy Management System</h2>
    <h2>Medicine Stock List</h2>
    <p>Date: ' . $date . '</p>
    <table>
        <thead>
            <tr>
                <th>S.N.</th>
                <th>Medicine Name</th>
                <th>Pack</th>
                <th>Generic Name</th>
                <th>Supplier Name</th>
                <th>Expiry Date</th>
                <th>Quantity</th>
                <th>MRP</th>
                <th>Rate</th>
            </tr>
        </thead>
        <tbody>';
    $serialNumber = 1;
    foreach ($rows as $row) {
        $data .= '<tr>
                <td>' . $serialNumber . '</td>
                <td>' . $row['med_name'] . '</td>
                <td>' . $row['med_pack'] . '</td>
                <td>' . $row['generic_name'] . '</td>
                <td>' . $row['s_name'] . '</td>
                <td>' . $row['exp_date'] . '</td>
                <td>' . $row['qty'] . '</td>
                <td>' . $row['mrp'] . '</td>
                <td>' . $row['rate'] . '</td>
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
