<?php

include "../../connection.php";
$GLOBALS['result']='';

if (isset($_POST['search'])) {
    $searchValue = $_POST['search'];
    $for = $_POST['for'];
    $of = $_POST['of'];
    if(isset($_POST['attr']))
    {
        $attr = $_POST['attr'];
    }

    if($for == "name")
    {
        global $searchValue;
        $searchValue = '%' . $searchValue . '%';
            select_data($of, $attr, 5);
            name($attr);      
    }

    if($for == "details")
    {
        if($of == "supplier")
        {
            $attr = "s_name";
        }
        if($of == "medicine")
        {
            $attr = "med_name";
        }
        select_data($of, $attr, 1);
        details();
    }

}

//Fetch data from table
function select_data($table, $attr, $n){
    global $conn;
    global $searchValue;
    if($table == "medicine")
    {
        $table = "$table FULL JOIN medicine ON medicine.s_name = {$table}.s_name";
    }
    $stmt = $conn->prepare("SELECT * FROM $table  WHERE $attr LIKE ? LIMIT $n");
    $stmt->bind_param("s", $searchValue);
    $stmt->execute();
    $result = $stmt->get_result();
    $GLOBALS['result']= $result;
}


//Return list of name of given inputs
function name($attr)
{
    if($attr == "med_name") {
        $id = "med_id";
    }
    else {
        $id = "s_id";
    }
    $result = $GLOBALS['result'];
    if ($result->num_rows > 0) {
        echo '<ul class="absolute w-full border border-gray-200 rounded-md bg-white grid grid-cols-1 divide-y">';
        while ($row = $result->fetch_assoc()) {
            echo '<li class="py-2 ps-2 hover:bg-pms-green-light hover:text-white" data-id = "'.$row[$id].'">' . $row[$attr] . "</li>";
        }
        echo "</ul>";
    }
}

//Return details of given input
function details()
{
    $result = $GLOBALS['result'];
    $row = $result->fetch_assoc();
    if($row)
    if(isset($row['exp_date']))
    {
        $row['exp_date'] = date('m-y', strtotime($row['exp_date']));
    }
    echo json_encode($row);

}
