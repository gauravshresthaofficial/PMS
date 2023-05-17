<?php
$output = "";
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

// Pagination variables
$results_per_page = 4;
$sql = "SELECT * FROM invoice";
$result = $conn->query($sql);
$number_of_results = mysqli_num_rows($result);
$total_pages = ceil($number_of_results / $results_per_page);

// Check if current page is set, else set it to 1
if (!isset($_POST['page'])) {
    $page = 1;
} else {
    $page = $_POST['page'];
}

// Calculate the starting limit number for the results on the displaying page
$starting_limit_number = ($page - 1) * $results_per_page;

// Retrieve the results for the displaying page
$sql = "SELECT * FROM invoice LIMIT $starting_limit_number, $results_per_page";
$result = $conn->query($sql);

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
        $sql = 'Select c_name from Customer where c_id = "' . $row['c_id'] . '" limit 1';
        $c_name_result = $conn->query($sql);
        $c_name_row = $c_name_result->fetch_assoc();
        $c_name = $c_name_row['c_name'];
        $output .= '
        <tr class="' . $bg . '">
        <td class="py-2 px-2 ps-4 text-md text-gray-600">' . $sn . '</td>
        <td class="py-2 px-2 ps-4 text-md text-gray-600">' . $c_name . '</td>
        <td class="py-2 px-2 ps-4 text-md text-gray-600">' . $row["i_id"] . '</td>
        <td class="py-2 px-2 ps-4 text-md text-gray-600">' . $row["invoice_date"] . '</td>
        <td class="py-2 px-2 ps-4 text-md text-gray-600">' . $row["total"] + $row['discount'] . '</td>
        <td class="py-2 px-2 ps-4 text-md text-gray-600">' . $row["discount"] . '</td>
        <td class="py-2 px-2 ps-4 text-md text-gray-600">' . $row["total"] . '</td>
        <td class="text-center py-2 px-2 ps-4 text-md text-gray-600" >
        <button class="px-4 py-1 text-white border border-1 border-gray-700 rounded-md hover:scale-105 bg-pms-error delete-btn" data-cid="' . $row["c_id"] . '">Delete</button>
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
                $output .= '<li class="mx-2"><button class="pagination px-2 py-1 bg-pms-green-light text-white rounded-md" data-page="' . $j . '" >' . $j . '</button></li>';
            } else {
                $output .= '<li class="mx-2"><button class="pagination px-2 py-1 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-400 transition duration-300" data-page="' . $j . '" >' . $j . '</button></li>';
            }
        }
        $output .= '</ul>';
        $output .= '</div>';
    }
}
echo $output;
