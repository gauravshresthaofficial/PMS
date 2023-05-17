<?php
$search_value = $_POST['search'];

include "../../connection.php";

if ($_POST['data_for'] == "med") {

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


    $stmt = $conn->prepare("SELECT * FROM medicine WHERE med_name LIKE ? LIMIT 5");
    $search_value = '%' . $search_value . '%';
    $stmt->bind_param("s", $search_value);
    $stmt->execute();
    $result = $stmt->get_result();

    $i = 0;
    if ($result->num_rows > 0) {
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
        <td class="text-center py-2 px-2 ps-4 text-md text-gray-600" >
        <button class="px-4 py-1 bg-white border border-1 border-black rounded-md me-2 hover:scale-105 edit-btn" data-id="' . $row["med_id"] . '">Edit</button>
        <button class="px-4 py-1 text-white border border-1 border-gray-700 rounded-md hover:scale-105 bg-pms-error delete-btn" data-id="' . $row["med_id"] . '">Delete</button>
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
        echo $output;
    }
} else {
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


    // Retrieve the results for the displaying page
    $sql = "SELECT * FROM medicine_stock LEFT JOIN medicine ON medicine.med_name = medicine_stock.med_name WHERE medicine_stock.med_name LIKE ? LIMIT 5";

    $stmt = $conn->prepare($sql);
    $search_value = '%' . $search_value . '%';
    $stmt->bind_param("s", $search_value);
    $stmt->execute();

    $result = $stmt->get_result();

    $i = 0;
    if ($result->num_rows > 0) {
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
    }
    echo $output;
}
