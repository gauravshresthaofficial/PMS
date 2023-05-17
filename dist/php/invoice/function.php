<?php
$json_data = array();
if (isset($_POST['for'])) {
    $for = $_POST['for'];

    if ($for == "row-add") {
        $num = $_POST['num'];
        $num = $num + 1;
        add_row($num);
    }
}


function add_row($num)
{
    $json_data['med_row'] = '<div class="mt-4 flex flex-row gap-6">
    <div class="basis-4/12">
      <input type="text" name="med_name_' . $num . '" id="med_name_' . $num . '" class="med_name w-full rounded-md border border-gray-200  py-1 ps-2"
        placeholder="Name" />
        
    </div>
    <div class="basis-3/12">
      <input type="text" name="med_qty_' . $num . '" id="med_qty_' . $num . '" class="med_qty w-full rounded-md border border-gray-200  py-1 ps-2"
        placeholder="For e.g. 10" />
    </div>
    <div class="basis-3/12">
      <input type="text" name="med_mrp_' . $num . '" id="med_mrp_' . $num . '" class="med_mrp w-full rounded-md border border-gray-200  py-1 ps-2" placeholder="MRP"  disabled/>
    </div>
    <div class="basis-2/12">
      <input type="text" name="med_total_' . $num . '" id="med_total_' . $num . '" class="med_total w-full rounded-md border border-gray-200  py-1 ps-2"
        placeholder="Total" disabled/>
    </div>
  </div>';

    $json_data['num'] = $num;

    echo json_encode($json_data);
}
