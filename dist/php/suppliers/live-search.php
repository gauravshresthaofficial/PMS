<?php
$search_value = $_POST['search'];
$value = $_POST['value'];

$output = '<table class="w-full px-2 m-auto mt-4">
<thead class="border border-r-0 border-l-0 border-gray-600">
<tr class="grid grid-cols-12">
    <tr class="grid grid-cols-12 py-2">
        <td class="py-2 pb-1 text-start px-2 text-gray-800 font-semibold text-md col-span-1">S.N.</td>
        <td class="py-2 pb-1 text-start px-2 text-gray-800 font-semibold text-md col-span-2">Name</td>
        <td class="py-2 pb-1 text-start px-2 text-gray-800 font-semibold text-md col-span-3">Email</td>
        <td class="py-2 pb-1 text-start px-2 text-gray-800 font-semibold text-md col-span-2">Address</td>
        <td class="py-2 pb-1 text-start px-2 text-gray-800 font-semibold text-md col-span-2">Number</td>
        <td class="py-2 pb-1 px-2 text-gray-800 font-semibold text-md col-span-2 text-center">Actions</td>
    </tr>
</thead>
<tbody>
    
';
include "../../connection.php";

$stmt = $conn->prepare("SELECT * FROM suppliers WHERE $value LIKE ? LIMIT 5");
$search_value = '%'.$search_value.'%';
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
        <tr class="' . $bg . ' grid grid-cols-12 py-2">
            <td class="flex items-center px-4 text-md text-gray-600 col-span-1">' .($i + 1) .'</td>
            <td class="flex items-center ps-2 pe-4 text-md text-gray-600 col-span-2 overflow-hidden whitespace-nowrap overflow-ellipsis">' . $row["s_name"] . '</td>
            <td class="flex items-center ps-2 pe-4 text-md text-gray-600 col-span-3 overflow-hidden whitespace-nowrap overflow-ellipsis">' . $row["s_email"] . '</td>
            <td class="flex items-center ps-2 pe-4 text-md text-gray-600 col-span-2">' . $row["s_address"] . '</td>
            <td class="flex items-center ps-2 pe-4 text-md text-gray-600 col-span-2">' . $row["s_number"] . '</td>
            <td class="flex items-center justify-center px-2 ps-4 text-md text-gray-600 col-span-2">
                <button class="px-4 py-1 bg-white border border-1 border-black rounded-md me-2 hover:scale-105 edit-btn" data-eid="' . $row["s_id"] . '">Edit</button>
                <button class="px-4 py-1 text-white border border-1 border-gray-700 rounded-md hover:scale-105 bg-[#9c4150] delete-btn" data-sid="' . $row["s_id"] . '">Delete</button>
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

?>