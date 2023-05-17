<?php
$search_value = $_POST['search'];

$output = '<table class="w-full px-2 m-auto mt-4">
<thead class="border border-r-0 border-l-0 border-gray-600">
    <tr>
        <th class="py-2 pb-1 text-start px-2 text-gray-800 font-semibold text-md">S.N.</th>
        <th class="py-2 pb-1 text-start px-2 text-gray-800 font-semibold text-md">Customer Name</th>
        <th class="py-2 pb-1 text-start px-2 text-gray-800 font-semibold text-md">Invoice Number</th>
        <th class="py-2 pb-1 text-start px-2 text-gray-800 font-semibold text-md">Invoice Date</th>
        <th class="py-2 pb-1 text-start px-2 text-gray-800 font-semibold text-md">Total</th>
        <th class="py-2 pb-1 text-start px-2 text-gray-800 font-semibold text-md">Discount</th>
        <th class="py-2 pb-1 text-start px-2 text-gray-800 font-semibold text-md">Net Total</th>
        <th class="py-2 pb-1 text-center px-2 text-gray-800 font-semibold text-md ">Actions</th>
    </tr>
</thead>
<tbody>';

include "../../connection.php";

$stmt = $conn->prepare("SELECT * FROM customer WHERE c_name LIKE ? LIMIT 5");
$search_value = '%' . $search_value . '%';
$stmt->bind_param("s", $search_value);
$stmt->execute();
$result = $stmt->get_result();

$i = 0;
if ($result->num_rows > 0) {
    $sn = 0;
    while ($row = $result->fetch_assoc()) {
        $sn++;
        if ($i % 2 == 0) {
            $bg = "bg-gray-100";
        } else {
            $bg = "bg-white";
        }
        $sql = 'Select * from invoice where c_id = "' . $row['c_id'] . '" limit 1';
        $invoice_result = $conn->query($sql);
        $invoice_row = $invoice_result->fetch_assoc();
        if (isset($invoice_row['i_id'])) {
            $output .= '
        <tr class="' . $bg . '">
            <td class="py-2 px-2 ps-4 text-md text-gray-600">' . $sn . '</td>
            <td class="py-2 px-2 ps-4 text-md text-gray-600">' . $row['c_name'] . '</td>
            <td class="py-2 px-2 ps-4 text-md text-gray-600">' . $invoice_row["i_id"] . '</td>
            <td class="py-2 px-2 ps-4 text-md text-gray-600">' . $invoice_row["invoice_date"] . '</td>
            <td class="py-2 px-2 ps-4 text-md text-gray-600">' . $invoice_row["total"] + $invoice_row['discount'] . '</td>
            <td class="py-2 px-2 ps-4 text-md text-gray-600">' . $invoice_row["discount"] . '</td>
            <td class="py-2 px-2 ps-4 text-md text-gray-600">' . $invoice_row["total"] . '</td>
            <td class="text-center py-2 px-2 ps-4 text-md text-gray-600" >
            <button class="px-4 py-1 text-white border border-1 border-gray-700 rounded-md hover:scale-105 bg-pms-error delete-btn" data-cid="' . $row["c_id"] . '">Delete</button>
            </td>
        </tr>';
        }
        $i++;
    }

    $output .= '</tbody>
</table>';
    echo $output;

    $conn->close();
} else {
    $output .= '<tr><td class="py-2 px-2 ps-4 text-md text-gray-600 text-center"  colspan="5">No data found</td></tr>';
    $output .= '</tbody> </table>';
    echo $output;
}
