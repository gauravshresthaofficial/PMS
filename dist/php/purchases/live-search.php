<?php
$search_value = $_POST['search'];

$output = '<table class="w-full px-2 m-auto mt-4">
<thead class="border border-r-0 border-l-0 border-gray-600">
    <tr>
        <th class="py-2 pb-1 text-start px-2 text-gray-800 font-semibold text-md">S.N.</th>
        <th class="py-2 pb-1 text-start px-2 text-gray-800 font-semibold text-md">Supplier Name</th>
        <th class="py-2 pb-1 text-start px-2 text-gray-800 font-semibold text-md">Invoice Number</th>
        <th class="py-2 pb-1 text-start px-2 text-gray-800 font-semibold text-md">Purchase Date</th>
        <th class="py-2 pb-1 text-start px-2 text-gray-800 font-semibold text-md">Total</th>
        <th class="py-2 pb-1 text-center px-2 text-gray-800 font-semibold text-md ">Actions</th>
    </tr>
</thead>
<tbody>';

include "../../connection.php";
// Retrieve the results for the displaying page
if(($_POST['value'] == "name")){
    $sql = "SELECT * FROM purchases WHERE s_name LIKE ? LIMIT 5";
}
else{
    $sql = "SELECT * FROM purchases WHERE purchase_date LIKE ? LIMIT 5";
}

$stmt = $conn->prepare($sql);
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
        $output .= '
        <tr class="' . $bg . '">
        <td class="py-2 px-2 ps-4 text-md text-gray-600">' . $sn . '</td>
        <td class="py-2 px-2 ps-4 text-md text-gray-600">' . $row['s_name'] . '</td>
        <td class="py-2 px-2 ps-4 text-md text-gray-600">' . $row["invoice_number"] . '</td>
        <td class="py-2 px-2 ps-4 text-md text-gray-600">' . $row["purchase_date"]. '</td>
        <td class="py-2 px-2 ps-4 text-md text-gray-600">' . $row["total"] . '</td>
        <td class="text-center py-2 px-2 ps-4 text-md text-gray-600" >
        <button class="px-4 py-1 text-white border border-1 border-gray-700 rounded-md hover:scale-105 bg-pms-error delete-btn" data-cid="' . $row["p_id"] . '">Delete</button>
        </td>
    </tr>';
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
